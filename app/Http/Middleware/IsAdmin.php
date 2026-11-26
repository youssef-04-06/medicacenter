<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;



    /**
     * Handle an incoming request.
     *
     * This middleware ensures that the current user is logged in
     * and has the "is_admin" flag set to true.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // allow access
        }

        abort(403); // forbidden
    }
}