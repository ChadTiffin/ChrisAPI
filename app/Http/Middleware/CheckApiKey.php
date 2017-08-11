<?php

namespace App\Http\Middleware;

use Closure;

class CheckApiKey
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
        $key = $request->input('key');

        $user = \App\User::where('api_key',$key)->first();

        if ($user) {
            $request->merge([
                'user_id' => $user->id
            ]);

            return $next($request);
        }
        else {
            return response()->json([
                'status' => "Unauthorized",
                'reason' => 'api_key',
                "code" => "403",
                "message" => "Api key not valid"
            ]);
        }
    }
}
