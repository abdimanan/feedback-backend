<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreFeedbackLinkRequest;
use App\Http\Resources\FeedbackLinkResource;
use App\Models\FeedbackLink;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class FeedbackLinkController extends Controller
{
    /**
     * Generate a unique feedback link token for a project.
     */
    public function store(StoreFeedbackLinkRequest $request, Project $project): JsonResponse
    {
        // Generate unique token
        do {
            $token = Str::random(64);
        } while (FeedbackLink::where('token', $token)->exists());

        // Create feedback link with 7 days expiration
        $feedbackLink = FeedbackLink::create([
            'project_id' => $project->id,
            'token' => $token,
            'expires_at' => now()->addDays(7),
        ]);

        return response()->json([
            'message' => 'Feedback link generated successfully.',
            'data' => new FeedbackLinkResource($feedbackLink),
        ], 201);
    }
}
