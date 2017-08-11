<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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

        if (isset($_SERVER['HTTP_ORIGIN']))
            header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
        else {
            //header('Access-Control-Allow-Origin: http://localhost:8081');
            header('Access-Control-Allow-Origin: localhost:8082');   
        }

        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

        return $next($request);
    }
}
