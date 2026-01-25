<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmailLogResource;
use App\Models\Project;
use App\Services\ProjectFeedbackEmailService;
use Illuminate\Http\JsonResponse;

class ProjectFeedbackEmailController extends Controller
{
    /**
     * Send project feedback email via ProjectFeedbackEmailService.
     */
    public function __invoke(ProjectFeedbackEmailService $service, Project $project): JsonResponse
    {
        $emailLog = $service->send($project->id);
        $emailLog->load('feedbackLink');

        return response()->json([
            'message' => 'Feedback email sent successfully.',
            'data' => new EmailLogResource($emailLog),
        ], 201);
    }
}
