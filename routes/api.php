<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\FeedbackLinkController;
use App\Http\Controllers\Api\ProjectController;
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
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');

    Route::apiResource('clients', ClientController::class);
    Route::apiResource('projects', ProjectController::class);

    Route::post('/projects/{project}/feedback-link', [FeedbackLinkController::class, 'store'])
        ->name('projects.feedback-link.store');

    Route::get('/feedbacks', [FeedbackController::class, 'index'])
        ->name('feedbacks.index');
});

// Public feedback submission (no authentication required)
Route::post('/public/feedback/{token}', [PublicFeedbackController::class, 'store'])
    ->name('public.feedback.store');
