<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class StepForwardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $similarsRoles = array_intersect(auth()->user()->roles->pluck('name')->toArray(), ['owner', 'admin']);
        if (
            Auth::user()->steps_forward !== 'complate' &&
            sizeof($similarsRoles) === 0
        ) {
            return redirect()->route('steps-forward', Auth::user()->steps_forward);
        } else {
            return $next($request);
        }
    }
}
