<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\EmailOpenTrackingController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\FeedbackLinkController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ProjectFeedbackEmailController;
use App\Http\Controllers\Api\PublicFeedbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public authentication routes
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Admin-only registration route
Route::post('/register', [AuthController::class, 'register'])
    ->middleware(['auth:sanctum', 'role:admin'])
    ->name('register');

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');

    Route::apiResource('clients', ClientController::class);
    Route::apiResource('projects', ProjectController::class);

    Route::post('/projects/{project}/feedback-link', [FeedbackLinkController::class, 'store'])
        ->name('projects.feedback-link.store');

    Route::get('/feedbacks', [FeedbackController::class, 'index'])
        ->name('feedbacks.index');

    Route::post('/projects/{project}/send-feedback-email', ProjectFeedbackEmailController::class)
        ->name('projects.send-feedback-email');
});

// Public feedback submission (no authentication required)
Route::post('/public/feedback/{token}', [PublicFeedbackController::class, 'store'])
    ->name('public.feedback.store');

// Public email open tracking (1x1 pixel)
Route::get('/public/email-open/{emailLog}', [EmailOpenTrackingController::class, 'track'])
    ->name('public.email.open');
