<?php

namespace App\Http\Middleware;

use Closure;

class CheckResourceExists
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
        $resource = $request->segment(1);

        if (!class_exists("\\App\\".$resource)) {
            return response()->json([
                'status' => "Resource not found",
                'reason' => 'not_found',
                "code" => "404",
                "message" => "The requested resource does not exist"
            ]);
        }

        return $next($request);
    }
}