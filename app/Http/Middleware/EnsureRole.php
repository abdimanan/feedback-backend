<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $userRole = $request->user()->role;

        $allowedRoles = array_map(fn (string $role) => Role::from($role), $roles);

        if (! in_array($userRole, $allowedRoles, true)) {
            return response()->json([
                'message' => 'Unauthorized. Insufficient role permissions.',
            ], 403);
        }

        return $next($request);
    }
}
