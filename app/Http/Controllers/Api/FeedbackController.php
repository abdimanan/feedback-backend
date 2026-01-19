<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FeedbackController extends Controller
{
    /**
     * Display a listing of feedback with optional filtering.
     */
    public function index(): AnonymousResourceCollection
    {
        $query = Feedback::query()->with(['project.client']);

        // Filter by client_id
        if (request()->has('client_id')) {
            $query->whereHas('project', function ($q) {
                $q->where('client_id', request()->get('client_id'));
            });
        }

        // Filter by project_id
        if (request()->has('project_id')) {
            $query->where('project_id', request()->get('project_id'));
        }

        $feedbacks = $query->latest('created_at')->paginate(request()->get('per_page', 15));

        return FeedbackResource::collection($feedbacks);
    }
}
