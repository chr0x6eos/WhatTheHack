<?php

namespace App\Http\Middleware;

use Closure;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!$request->user()) {
            abort(404);
        }

        if (!$request->user()->hasRole('admin')) {
            if (!$request->user()->hasRole($role)) {
                abort(404);
            }
        }

        return $next($request);
    }
}
