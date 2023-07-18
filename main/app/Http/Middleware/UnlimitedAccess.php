<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UnlimitedAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
     
        if (Auth::check() && Auth::user()->hasRole($role)) {
            // Allow access for admin
            return $next($request);
        }

        // Redirect or deny access for non-admin users
        abort(403, 'Access denied.');
    }
}
