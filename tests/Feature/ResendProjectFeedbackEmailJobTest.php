<?php

use App\Jobs\ResendProjectFeedbackEmailJob;
use App\Mail\ProjectFeedbackMail;
use App\Models\EmailLog;
use App\Services\ProjectFeedbackEmailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();
});

it('resends mail and increments resent_count and updates sent_at when eligible', function () {
    $emailLog = EmailLog::factory()->create([
        'sent_at' => now()->subDays(4),
        'resent_count' => 1,
    ]);
    $emailLog->feedbackLink->update(['used_at' => null]);
    $emailLog->load(['feedbackLink', 'project', 'client']);

    $job = new ResendProjectFeedbackEmailJob($emailLog->id);
    $job->handle(app(ProjectFeedbackEmailService::class));

    Mail::assertSent(ProjectFeedbackMail::class);
    expect($emailLog->fresh()->resent_count)->toBe(2);
    expect($emailLog->fresh()->sent_at->isToday())->toBeTrue();
});

it('exits early without sending when feedback_link used_at is set', function () {
    $emailLog = EmailLog::factory()->create([
        'sent_at' => now()->subDays(4),
        'resent_count' => 0,
    ]);
    $emailLog->feedbackLink->update(['used_at' => now()]);

    $job = new ResendProjectFeedbackEmailJob($emailLog->id);
    $job->handle(app(ProjectFeedbackEmailService::class));

    Mail::assertNothingSent();
    expect($emailLog->fresh()->resent_count)->toBe(0);
});

it('exits early without sending when resent_count is 3 or more', function () {
    $emailLog = EmailLog::factory()->create([
        'sent_at' => now()->subDays(4),
        'resent_count' => 3,
    ]);
    $emailLog->feedbackLink->update(['used_at' => null]);

    $job = new ResendProjectFeedbackEmailJob($emailLog->id);
    $job->handle(app(ProjectFeedbackEmailService::class));

    Mail::assertNothingSent();
    expect($emailLog->fresh()->resent_count)->toBe(3);
});

it('exits early when EmailLog is not found', function () {
    $job = new ResendProjectFeedbackEmailJob(99999);
    $job->handle(app(ProjectFeedbackEmailService::class));

    Mail::assertNothingSent();
});
