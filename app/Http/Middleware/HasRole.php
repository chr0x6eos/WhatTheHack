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
                if ($request->user()->hasRole('student')) {
                    return redirect()->route('home');
                }

                abort(404);
            }

            if (!$request->user()->isVerified()) {
                // this redirects logged-in users to /email/verify.
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
