<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'client_id' => $this->client_id,
            'feedback_link_id' => $this->feedback_link_id,
            'to_email' => $this->to_email,
            'subject' => $this->subject,
            'sent_at' => $this->sent_at,
            'opened_at' => $this->opened_at,
            'is_opened' => $this->opened_at !== null,
            'resent_count' => $this->resent_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($this->relationLoaded('client')) {
            $data['client'] = [
                'id' => $this->client->id,
                'name' => $this->client->name,
                'email' => $this->client->email,
            ];
        }

        if ($this->relationLoaded('project')) {
            $data['project'] = [
                'id' => $this->project->id,
                'name' => $this->project->name,
            ];
        }

        if ($this->relationLoaded('feedbackLink')) {
            $data['feedback_url'] = config('app.frontend_url')."/feedback/{$this->feedbackLink->token}";
            $data['api_endpoint'] = config('app.url')."/api/public/feedback/{$this->feedbackLink->token}";
            $data['feedback_link'] = [
                'id' => $this->feedbackLink->id,
                'token' => $this->feedbackLink->token,
                'used_at' => $this->feedbackLink->used_at,
            ];
        }

        return $data;
    }
}
