<?php

namespace App\Http\Controllers\Api;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateUserByAdminRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(): JsonResponse
    {
        $query = User::query();

        // Filter by role
        if (request()->has('role')) {
            $query->where('role', request()->get('role'));
        }

        // Search by name or email
        if (request()->has('search')) {
            $search = request()->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest('created_at')->paginate(request()->get('per_page', 15));

        return response()->json([
            'data' => $users->map(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->value,
                'role_label' => $user->role->label(),
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]),
            'meta' => [
                'current_page' => $users->currentPage(),
                'from' => $users->firstItem(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'to' => $users->lastItem(),
                'total' => $users->total(),
            ],
        ]);
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->value,
                'role_label' => $user->role->label(),
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ],
        ]);
    }

    /**
     * Update the specified user (Admin only).
     */
    public function update(UpdateUserByAdminRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();

        // Prepare data for update
        $data = [];

        if (isset($validated['name'])) {
            $data['name'] = $validated['name'];
        }

        if (isset($validated['email'])) {
            $data['email'] = $validated['email'];
        }

        if (isset($validated['password']) && ! empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        if (isset($validated['role'])) {
            $data['role'] = Role::from($validated['role']);
        }

        $user->update($data);

        return response()->json([
            'message' => 'User updated successfully.',
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
     * Remove the specified user (Admin only).
     */
    public function destroy(User $user): JsonResponse
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return response()->json([
                'message' => 'You cannot delete your own account.',
            ], 403);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully.',
        ]);
    }
}
