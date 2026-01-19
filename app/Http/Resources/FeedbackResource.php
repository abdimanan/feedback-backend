<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'project' => new ProjectResource($this->whenLoaded('project')),
            'statement_1_rating' => $this->statement_1_rating,
            'statement_2_rating' => $this->statement_2_rating,
            'statement_3_rating' => $this->statement_3_rating,
            'likes_text' => $this->likes_text,
            'dislikes_text' => $this->dislikes_text,
            'overall_rating' => $this->overall_rating,
            'created_at' => $this->created_at,
        ];
    }
}
