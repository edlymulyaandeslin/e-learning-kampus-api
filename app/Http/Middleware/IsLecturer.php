<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsLecturer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('api')->check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if (auth('api')->user()->role !== 'lecturer') {
            return response()->json(['message' => 'Access denied. Lecturer role required.'], 403);
        }

        return $next($request);
    }
}
