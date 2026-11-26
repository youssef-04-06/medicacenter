<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Only allow logged-in users with the is_admin flag through.
     * Everyone else is bounced back to the login page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        $user = auth()->user();

        if (! $user->is_admin && strtolower((string) $user->role) !== 'admin') {
            abort(403, 'You do not have permission to access the admin area.');
        }

        return $next($request);
    }
}
