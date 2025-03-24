<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!$request->user() || $request->user()->role !== $role) {
            if ($request->is('api/*')) {
                throw new AuthorizationException('Forbidden');
            }
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }
        return $next($request);
    }
}