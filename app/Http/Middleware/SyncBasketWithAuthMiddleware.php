<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class SyncBasketWithAuthMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (Cookie::has('baskets')) {
      // Pass data to terminate method using the request's attributes
      $request->attributes->set('baskets', request()->cookie('baskets'));

      // Forget the 'baskets' cookie before sending the response
      Cookie::queue(Cookie::forget('baskets'));
    }
    return $next($request);
  }

  /**
   * Handle tasks after the response has been sent to the browser.
   */
  public function terminate(Request $request, Response $response): void
  {
    if (Auth::check() && $request->attributes->has('baskets')) {
      $baskets = unserialize($request->attributes->get('baskets'));
      $diffrentCourses = array_diff($baskets, Auth::user()->baskets->pluck('course_id')->toArray());

      // Add Diffrent in basket user
      foreach ($diffrentCourses as $id) {
        Auth::user()->baskets()->create(
          ['course_id' => $id]
        );
      }
    }
  }
}
