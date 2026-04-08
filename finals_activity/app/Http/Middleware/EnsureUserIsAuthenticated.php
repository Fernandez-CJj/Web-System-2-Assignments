<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAuthenticated
{
  /**
   * Handle an incoming request.
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (! $request->session()->has('auth_user_id')) {
      return redirect('/login')->with('error', 'Please login first.');
    }

    return $next($request);
  }
}
