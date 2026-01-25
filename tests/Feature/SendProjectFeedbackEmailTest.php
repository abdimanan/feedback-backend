<?php

use App\Mail\ProjectFeedbackMail;
use App\Models\Client;
use App\Models\EmailLog;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();
});

it('sends feedback email and returns 201 with EmailLog data when project_manager', function () {
    $user = User::factory()->projectManager()->create();
    $client = Client::factory()->create();
    $project = Project::create([
        'client_id' => $client->id,
        'name' => 'Test Project',
        'description' => 'Test description',
        'start_date' => now(),
    ]);

    $response = $this->actingAs($user, 'sanctum')
        ->postJson(route('projects.send-feedback-email', $project));

    $response->assertCreated();
    $response->assertJsonStructure([
        'message',
        'data' => [
            'id',
            'project_id',
            'client_id',
            'feedback_link_id',
            'to_email',
            'subject',
            'sent_at',
            'opened_at',
            'resent_count',
            'created_at',
            'updated_at',
            'feedback_url',
        ],
    ]);
    $response->assertJsonPath('data.to_email', $client->email);
    $response->assertJsonPath('data.project_id', $project->id);

    Mail::assertSent(ProjectFeedbackMail::class);

    $emailLog = EmailLog::where('project_id', $project->id)->first();
    expect($emailLog)->not->toBeNull();
    expect($emailLog->to_email)->toBe($client->email);
    expect($emailLog->sent_at)->not->toBeNull();
});

it('returns 401 when unauthenticated', function () {
    $client = Client::factory()->create();
    $project = Project::create([
        'client_id' => $client->id,
        'name' => 'Test Project',
        'description' => null,
        'start_date' => now(),
    ]);

    $response = $this->postJson(route('projects.send-feedback-email', $project));

    $response->assertUnauthorized();
    Mail::assertNothingSent();
});

it('returns 403 when authenticated as admin', function () {
    $user = User::factory()->admin()->create();
    $client = Client::factory()->create();
    $project = Project::create([
        'client_id' => $client->id,
        'name' => 'Test Project',
        'description' => null,
        'start_date' => now(),
    ]);

    $response = $this->actingAs($user, 'sanctum')
        ->postJson(route('projects.send-feedback-email', $project));

    $response->assertForbidden();
    Mail::assertNothingSent();
});

it('returns 404 when project does not exist', function () {
    $user = User::factory()->projectManager()->create();
    $project = new Project;
    $project->id = 99999;

    $response = $this->actingAs($user, 'sanctum')
        ->postJson(route('projects.send-feedback-email', ['project' => 99999]));

    $response->assertNotFound();
    Mail::assertNothingSent();
});
