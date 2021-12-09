<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function indexChangePassword(Request $request)
    {
        return Inertia::render('User/Setting/Change_Password', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Change Password",
                    'active'  => true
                ]
            ),
            '__postUpdate' => 'user.setting.changepassword.update',
        ]);
    }

    public function ChangePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = User::where('email', auth()->user()->email)
            ->update(['password' => Hash::make($request->password)]);

        return Redirect::route('user.dashboard')->with('success', 'Your password has been changed!');
    }
}
