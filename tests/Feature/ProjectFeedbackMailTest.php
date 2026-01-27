<?php

use App\Mail\ProjectFeedbackMail;
use App\Models\EmailLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders mailable with client name, project name, description, feedback link, expiration, and tracking pixel', function () {
    $emailLog = EmailLog::factory()->create();
    $emailLog->project->update([
        'name' => 'Test Project',
        'description' => 'Test project description',
    ]);
    $emailLog->load(['client', 'project', 'feedbackLink']);
    $mailable = new ProjectFeedbackMail(
        $emailLog->client,
        $emailLog->project,
        $emailLog->feedbackLink,
        $emailLog
    );

    $html = $mailable->render();

    expect($html)
        ->toContain($emailLog->client->name)
        ->toContain('Test Project')
        ->toContain('Test project description')
        ->toContain(config('app.frontend_url').'/feedback/'.$emailLog->feedbackLink->token)
        ->toContain($emailLog->feedbackLink->expires_at->format('F j, Y \a\t g:i A'))
        ->toContain(route('public.email.open', $emailLog, true));
});
