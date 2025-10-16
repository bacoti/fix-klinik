<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        // Ensure user is authenticated first
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }

        // Support multiple roles passed as comma-separated list. Comparison is
        // case-insensitive and trims whitespace to be more forgiving of input.
        $roleList = array_map('strtolower', array_map('trim', explode(',', $roles)));
        $userRole = strtolower(trim(auth()->user()->role));

        if (!in_array($userRole, $roleList, true)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
