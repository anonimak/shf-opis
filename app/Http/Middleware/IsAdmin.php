<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
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
        if (auth()->user()->role == 1) {
            return $next($request);
        } else if (auth()->user()->role == 2) {
            return Redirect()->route(RouteServiceProvider::HOMESUPER)->with('error', "You don't have access.");
        }
        return redirect('dashboard')->with('error', "You don't have admin access.");
    }
}
