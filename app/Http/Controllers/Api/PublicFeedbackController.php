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
            'statement_1_rating' => $request->statement_1_rating,
            'statement_2_rating' => $request->statement_2_rating,
            'statement_3_rating' => $request->statement_3_rating,
            'likes_text' => $request->likes_text,
            'dislikes_text' => $request->dislikes_text,
            'overall_rating' => $request->overall_rating,
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
