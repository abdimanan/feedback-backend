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
            'resent_count' => $this->resent_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($this->relationLoaded('feedbackLink')) {
            $data['feedback_url'] = url("/api/public/feedback/{$this->feedbackLink->token}");
        }

        return $data;
    }
}
