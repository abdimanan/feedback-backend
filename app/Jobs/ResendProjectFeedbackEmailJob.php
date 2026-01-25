<?php

namespace App\Jobs;

use App\Models\EmailLog;
use App\Services\ProjectFeedbackEmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ResendProjectFeedbackEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $emailLogId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ProjectFeedbackEmailService $service): void
    {
        $emailLog = EmailLog::with('feedbackLink')->find($this->emailLogId);

        if ($emailLog === null) {
            return;
        }

        if ($emailLog->feedbackLink->used_at !== null) {
            return;
        }

        if ($emailLog->resent_count >= 3) {
            return;
        }

        $service->resend($emailLog);
    }
}
