<?php

use App\Jobs\ResendProjectFeedbackEmailJob;
use App\Models\EmailLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

uses(RefreshDatabase::class);

it('dispatches job per eligible EmailLog and logs count', function () {
    Queue::fake();
    Log::spy();

    $one = EmailLog::factory()->create([
        'sent_at' => now()->subDays(4),
        'resent_count' => 0,
    ]);
    $one->feedbackLink->update(['used_at' => null]);
    $two = EmailLog::factory()->create([
        'sent_at' => now()->subDays(5),
        'resent_count' => 1,
    ]);
    $two->feedbackLink->update(['used_at' => null]);

    $this->artisan('emails:resend-feedback')
        ->assertSuccessful()
        ->expectsOutput('Queued 2 feedback resend email(s).');

    Queue::assertPushed(ResendProjectFeedbackEmailJob::class, 2);
    Log::shouldHaveReceived('info')->once()->with('Queued feedback resend email(s).', ['count' => 2]);
});

it('queues zero jobs when no eligible EmailLogs', function () {
    Queue::fake();
    Log::spy();

    $this->artisan('emails:resend-feedback')
        ->assertSuccessful()
        ->expectsOutput('Queued 0 feedback resend email(s).');

    Queue::assertNotPushed(ResendProjectFeedbackEmailJob::class);
    Log::shouldHaveReceived('info')->once()->with('Queued feedback resend email(s).', ['count' => 0]);
});
