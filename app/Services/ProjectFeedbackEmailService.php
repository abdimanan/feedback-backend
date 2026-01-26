<?php

namespace App\Services;

use App\Mail\ProjectFeedbackMail;
use App\Models\EmailLog;
use App\Models\FeedbackLink;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProjectFeedbackEmailService
{
    /**
     * Load project and client, create FeedbackLink and EmailLog, send ProjectFeedbackMail via SMTP,
     * set sent_at only after successful send. Throws on failure.
     */
    public function send(int $projectId): EmailLog
    {
        $project = Project::with('client')->findOrFail($projectId);
        $client = $project->client;

        do {
            $token = Str::random(64);
        } while (FeedbackLink::where('token', $token)->exists());

        $feedbackLink = FeedbackLink::create([
            'project_id' => $project->id,
            'token' => $token,
            'expires_at' => now()->addDays(7),
        ]);

        $emailLog = EmailLog::create([
            'project_id' => $project->id,
            'client_id' => $client->id,
            'feedback_link_id' => $feedbackLink->id,
            'to_email' => $client->email,
            'subject' => "Feedback request: {$project->name}",
            'sent_at' => Carbon::createFromTimestamp(0),
        ]);

        try {
            Mail::mailer('smtp')->send(
                new ProjectFeedbackMail($client, $project, $feedbackLink, $emailLog)
            );
            $emailLog->update(['sent_at' => now()]);
        } catch (\Exception $e) {
            Log::error('Failed to send project feedback email', [
                'email_log_id' => $emailLog->id,
                'to_email' => $client->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }

        return $emailLog->fresh();
    }

    /**
     * Resend ProjectFeedbackMail for an existing EmailLog. Reuse FeedbackLink.
     * Increment resent_count and update sent_at only after successful send. Throws on failure.
     */
    public function resend(EmailLog $emailLog): EmailLog
    {
        $emailLog->load(['feedbackLink', 'project', 'client']);

        Mail::mailer('smtp')->send(
            new ProjectFeedbackMail(
                $emailLog->client,
                $emailLog->project,
                $emailLog->feedbackLink,
                $emailLog
            )
        );

        $emailLog->increment('resent_count');
        $emailLog->update(['sent_at' => now()]);

        return $emailLog->fresh();
    }
}
