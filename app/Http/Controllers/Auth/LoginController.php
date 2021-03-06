<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return Inertia::render('Auth/Login', [
            'meta' => [
                'title' => 'tests',
                'foo' => 'bar'
            ],
            '__forgetPassword' => 'forget-password.request'
        ]);
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
            // return redirectWithoutInertia('admin.dashboard');
            $role = auth()->user()->role;
            $route = RouteServiceProvider::HOME;
            if ($role == 2) {
                $route = RouteServiceProvider::HOMESUPER;
            } elseif ($role == 1) {
                $route = RouteServiceProvider::HOMEADMIN;
            }
            if (session('url.intended')) {
                return redirect()->intended($route);
            }
            return Redirect()->route($route);
        } else {
            return Redirect()->route('login')
                ->with('error', 'Wrong email or password.');
        }
    }

    public function logout()
    {
        //logout user
        Auth::logout();
        // redirect to homepage
        return Redirect()->route('login');
    }
}
