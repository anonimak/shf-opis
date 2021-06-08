<?php

namespace App\Http\Middleware;

use Closure;
use Inertia\Inertia;

class IsSuper
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

        if (auth()->user()->role == 2) {
            return $next($request);
        }

        return redirect('dashboard')->with('error', "You don't have admin access.");
    }
}
