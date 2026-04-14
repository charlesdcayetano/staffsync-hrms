<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    // Use the Auth Facade instead of the auth() helper
    if (Auth::check() && Auth::user()->is_admin) {
        return $next($request);
    }

    return redirect('/dashboard')->with('error', 'Unauthorized access.');
}
}
