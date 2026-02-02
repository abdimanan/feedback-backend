<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePublicFeedbackRequest;
use App\Models\Feedback;
use App\Models\FeedbackLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PublicFeedbackController extends Controller
{
    /**
     * Get client and project information from feedback link token.
     */
    public function show(string $token): JsonResponse
    {
        // Find the feedback link by token
        $feedbackLink = FeedbackLink::where('token', $token)
            ->with(['project.client'])
            ->first();

        if (! $feedbackLink) {
            return response()->json([
                'message' => 'Invalid feedback link token.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Check if link is expired
        if ($feedbackLink->expires_at->isPast()) {
            return response()->json([
                'message' => 'This feedback link has expired.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Check if link is already used
        if ($feedbackLink->used_at !== null) {
            return response()->json([
                'message' => 'This feedback link has already been used.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'data' => [
                'client_name' => $feedbackLink->project->client->name,
                'project_name' => $feedbackLink->project->name,
                'contact_person' => $feedbackLink->project->client->contact_person,
                'service_date' => $feedbackLink->project->start_date,
            ],
        ]);
    }

    /**
     * Store feedback using a feedback link token.
     */
    public function store(StorePublicFeedbackRequest $request, string $token): JsonResponse
    {
        // Find the feedback link by token
        $feedbackLink = FeedbackLink::where('token', $token)->first();

        if (! $feedbackLink) {
            return response()->json([
                'message' => 'Invalid feedback link token.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Check if link is expired
        if ($feedbackLink->expires_at->isPast()) {
            return response()->json([
                'message' => 'This feedback link has expired.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Check if link is already used
        if ($feedbackLink->used_at !== null) {
            return response()->json([
                'message' => 'This feedback link has already been used.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Create feedback
        $feedback = Feedback::create([
            'project_id' => $feedbackLink->project_id,
            'overall_satisfaction' => $request->overall_satisfaction,
            'timeliness_delivery' => $request->timeliness_delivery,
            'communication_coordination' => $request->communication_coordination,
            'quality_final_outputs' => $request->quality_final_outputs,
            'professionalism_team' => $request->professionalism_team,
            'understanding_requirements' => $request->understanding_requirements,
            'nps_score' => $request->nps_score,
            'deliverables_met_expectations' => $request->deliverables_met_expectations,
            'issues_resolved_quickly' => $request->issues_resolved_quickly,
            'comment' => $request->comment,
            'created_at' => now(),
        ]);

        // Mark feedback link as used
        $feedbackLink->update([
            'used_at' => now(),
        ]);

        return response()->json([
            'message' => 'Feedback submitted successfully. Thank you!',
            'data' => [
                'id' => $feedback->id,
                'project_id' => $feedback->project_id,
            ],
        ], Response::HTTP_CREATED);
    }
}
