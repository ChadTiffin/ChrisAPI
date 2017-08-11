<?php

namespace App\Http\Middleware;

use Closure;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user_id = $request->input("user_id");
        $user = \App\User::find($user_id);

        $allowed = $user->canAccessRoute($request->path());

        if (!$allowed) {
            return response()->json([
                'status' => "unauthorized",
                'reason' => 'permissions',
                'code' => "403",
                "message" => "No permission to access this endpoint"
            ]);
        }

        return $next($request);
    }
}