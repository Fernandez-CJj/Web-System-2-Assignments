<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LogActivity
{
  /**
   * Handle an incoming request.
   */
  public function handle(Request $request, Closure $next): Response
  {
    $response = $next($request);

    if ($this->shouldSkipPath($request->path())) {
      return $response;
    }

    try {
      DB::table('activity_logs')->insert([
        'user_id' => $request->session()->get('auth_user_id'),
        'event' => 'request',
        'method' => $request->method(),
        'path' => $request->getPathInfo(),
        'status_code' => $response->getStatusCode(),
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'details' => json_encode([
          'query' => $request->query(),
          'at' => now()->toDateTimeString(),
        ]),
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    } catch (Throwable $exception) {
      // Prevent logging failures from interrupting requests.
    }

    return $response;
  }

  private function shouldSkipPath(string $path): bool
  {
    if ($path === '_ignition/health-check') {
      return true;
    }

    return str_starts_with($path, 'build/') || str_starts_with($path, 'storage/');
  }
}
