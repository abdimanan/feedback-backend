<?php

use App\Models\EmailLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns only EmailLogs with used_at null, resent_count less than 3, and sent_at older than 3 days', function () {
    $eligible = EmailLog::factory()->create([
        'sent_at' => now()->subDays(4),
        'resent_count' => 0,
    ]);
    $eligible->feedbackLink->update(['used_at' => null]);

    $result = EmailLog::eligibleForResend();

    expect($result)->toHaveCount(1);
    expect($result->first()->id)->toBe($eligible->id);
});

it('excludes EmailLogs when feedback_link used_at is set', function () {
    $emailLog = EmailLog::factory()->create([
        'sent_at' => now()->subDays(4),
        'resent_count' => 0,
    ]);
    $emailLog->feedbackLink->update(['used_at' => now()]);

    $result = EmailLog::eligibleForResend();

    expect($result)->toHaveCount(0);
});

it('excludes EmailLogs when resent_count is 3 or more', function () {
    EmailLog::factory()->create([
        'sent_at' => now()->subDays(4),
        'resent_count' => 3,
    ]);

    $result = EmailLog::eligibleForResend();

    expect($result)->toHaveCount(0);
});

it('excludes EmailLogs when sent_at is within last 3 days', function () {
    EmailLog::factory()->create([
        'sent_at' => now()->subDays(2),
        'resent_count' => 0,
    ]);

    $result = EmailLog::eligibleForResend();

    expect($result)->toHaveCount(0);
});
