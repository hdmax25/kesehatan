<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
  /**
   * Handle an incoming request.
   *
   * @param Request $request
   * @param Closure $next
   * @param $role
   * @return mixed
   */
  public function handle($request, Closure $next, $role)
  {
    $responseRule = explode('|', $role);
    if (!in_array($request->user()->role, $responseRule, false)) {
      return abort(404);
    }
    return $next($request);
  }
}
