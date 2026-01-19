<?php

use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\FeedbackLinkController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\PublicFeedbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('clients', ClientController::class);
Route::apiResource('projects', ProjectController::class);

Route::post('/projects/{project}/feedback-link', [FeedbackLinkController::class, 'store'])
    ->name('projects.feedback-link.store');

// Public feedback submission (no authentication required)
Route::post('/public/feedback/{token}', [PublicFeedbackController::class, 'store'])
    ->name('public.feedback.store');

// Internal feedback management (requires authentication later)
Route::get('/feedbacks', [FeedbackController::class, 'index'])
    ->name('feedbacks.index');
