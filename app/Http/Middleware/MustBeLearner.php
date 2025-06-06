<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustBeLearner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user=auth()->user();
        // dd($user);
        if ($user->role !=='learner') {
            return response()->json([
                'message' => 'You are not authorized to access this resource.',
            ], 403);
        } else {
            return $next($request);
        }
    }
}
