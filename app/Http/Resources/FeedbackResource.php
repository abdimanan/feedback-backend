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
            'overall_satisfaction' => $this->overall_satisfaction,
            'timeliness_delivery' => $this->timeliness_delivery,
            'communication_coordination' => $this->communication_coordination,
            'quality_final_outputs' => $this->quality_final_outputs,
            'professionalism_team' => $this->professionalism_team,
            'understanding_requirements' => $this->understanding_requirements,
            'nps_score' => $this->nps_score,
            'deliverables_met_expectations' => $this->deliverables_met_expectations,
            'issues_resolved_quickly' => $this->issues_resolved_quickly,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
        ];
    }
}
