<?php

use App\Models\EmailLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns 200 and image/gif for email open tracking pixel', function () {
    $emailLog = EmailLog::factory()->create(['opened_at' => null]);

    $response = $this->get(route('public.email.open', $emailLog));

    $response->assertOk();
    $response->assertHeader('Content-Type', 'image/gif');
});

it('sets opened_at when null on first pixel request', function () {
    $emailLog = EmailLog::factory()->create(['opened_at' => null]);

    $this->get(route('public.email.open', $emailLog));

    expect($emailLog->fresh()->opened_at)->not->toBeNull();
});

it('leaves opened_at unchanged when already set', function () {
    $openedAt = now()->subHour();
    $emailLog = EmailLog::factory()->create(['opened_at' => $openedAt]);
    $expected = $openedAt->toDateTimeString();

    $this->get(route('public.email.open', $emailLog));

    expect($emailLog->fresh()->opened_at->toDateTimeString())->toBe($expected);
});
