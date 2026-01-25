<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\EmailLog;
use App\Models\FeedbackLink;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmailLog>
 */
class EmailLogFactory extends Factory
{
    protected $model = EmailLog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $client = Client::factory()->create();
        $project = Project::create([
            'client_id' => $client->id,
            'name' => $this->faker->company(),
            'description' => $this->faker->optional()->sentence(),
            'start_date' => $this->faker->date(),
        ]);
        do {
            $token = Str::random(64);
        } while (FeedbackLink::where('token', $token)->exists());
        $feedbackLink = FeedbackLink::create([
            'project_id' => $project->id,
            'token' => $token,
            'expires_at' => now()->addDays(7),
        ]);

        return [
            'project_id' => $project->id,
            'client_id' => $client->id,
            'feedback_link_id' => $feedbackLink->id,
            'to_email' => $this->faker->safeEmail(),
            'subject' => $this->faker->sentence(),
            'sent_at' => now(),
            'opened_at' => null,
            'resent_count' => 0,
        ];
    }
}
