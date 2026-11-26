<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DoctorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        $user = auth()->user();

        if (strtolower((string) $user->role) !== 'doctor' || ! $user->doctor) {
            abort(403, 'You do not have permission to access the doctor area.');
        }

        return $next($request);
    }
}
