<?php

namespace App\Http\Middleware;

use Closure;
use Inertia\Inertia;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Inertia::share('userinfo', auth()->user());

        if (auth()->user()->is_admin == 1) {
            return $next($request);
        }

        return redirect('dashboard')->with('error', "You don't have admin access.");
    }
}
