<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    /**
     * Update the authenticated user's profile.
     */
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = $request->user();

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->value,
                'role_label' => $user->role->label(),
            ],
        ]);
    }

    /**
     * Change the authenticated user's password.
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = $request->user();

        $user->update([
            'password' => $validated['password'],
        ]);

        return response()->json([
            'message' => 'Password changed successfully.',
        ]);
    }
}
