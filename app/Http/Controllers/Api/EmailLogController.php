<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmailLogResource;
use App\Models\EmailLog;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EmailLogController extends Controller
{
    /**
     * Display a listing of email logs with optional filtering.
     */
    public function index(): AnonymousResourceCollection
    {
        $query = EmailLog::query()->with(['client', 'project', 'feedbackLink']);

        // Filter by client_id
        if (request()->has('client_id')) {
            $query->where('client_id', request()->get('client_id'));
        }

        // Filter by project_id
        if (request()->has('project_id')) {
            $query->where('project_id', request()->get('project_id'));
        }

        // Filter by opened status
        if (request()->has('opened')) {
            $opened = filter_var(request()->get('opened'), FILTER_VALIDATE_BOOLEAN);
            if ($opened) {
                $query->whereNotNull('opened_at');
            } else {
                $query->whereNull('opened_at');
            }
        }

        // Order by most recent first
        $emailLogs = $query->latest('sent_at')->paginate(request()->get('per_page', 15));

        return EmailLogResource::collection($emailLogs);
    }

    /**
     * Display the specified email log.
     */
    public function show(EmailLog $emailLog): EmailLogResource
    {
        $emailLog->load(['client', 'project', 'feedbackLink']);

        return new EmailLogResource($emailLog);
    }
}
