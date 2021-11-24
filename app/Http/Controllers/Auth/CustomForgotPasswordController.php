<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CustomForgotPasswordController extends Controller
{
    public function getEmail()
    {
        return Inertia::render('Auth/ForgotPassword', [
            '__postEmail' => 'forget-password.email',
            '__login' => 'login'
        ]);
    }

    public function postEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        $details = [
            'subject' => 'Reset Password Notification',
            'url'     => route('forget-password.reset', $token)
        ];

        Mail::to($request->email)->send(new \App\Mail\ResetPasswordVerify($details));


        return Redirect::route('login')->with('success', 'We have e-mailed your password reset link!');
    }
}
