<?php

namespace App\Console\Commands;

use App\Jobs\ResendProjectFeedbackEmailJob;
use App\Models\EmailLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ResendFeedbackEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:resend-feedback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue eligible feedback emails for resend (used_at null, resent_count < 3, sent_at older than 3 days)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $eligible = EmailLog::eligibleForResend();
        $count = $eligible->count();

        foreach ($eligible as $emailLog) {
            ResendProjectFeedbackEmailJob::dispatch($emailLog->id);
        }

        Log::info('Queued feedback resend email(s).', ['count' => $count]);
        $this->info("Queued {$count} feedback resend email(s).");

        return self::SUCCESS;
    }
}
