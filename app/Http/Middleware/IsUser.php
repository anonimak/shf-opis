<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\User;
use Closure;
use Inertia\Inertia;

class IsUser
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

        if (auth()->user()->role == 0) {
            Inertia::share('userinfo', User::with('employee')->where('id', auth()->id())->first());
            return $next($request);
        } else if (auth()->user()->role == 1) {
            return Redirect()->route(RouteServiceProvider::HOMEADMIN)->with('error', "You don't have access.");
        }

        return redirect(RouteServiceProvider::HOMESUPER)->with('error', "You don't have admin access.");
    }
}
