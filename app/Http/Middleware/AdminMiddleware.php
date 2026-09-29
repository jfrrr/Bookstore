<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures only users with the 'admin' role can access admin routes.
 * Returns 403 Forbidden for authenticated non-admin users.
 */
class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk administrator.');
        }

        return $next($request);
    }
}
