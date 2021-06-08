<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Super/User', [
            'dataUsers' => User::getUsers($request->input('search'))->paginate(10),
            'perPage' => 10,
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'   => "User Management",
                    'active'  => true
                ]
            ),
            '__create'  => 'super.user.create',
            '__edit'    => 'super.user.edit',
            '__show'    => 'super.user.show',
            '__destroy' => 'super.user.destroy',
            '__index'   => 'super.user.index'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Super/User/create', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'   => "User Management",
                    'href'  => "super.user.index"
                ],
                [
                    'title'   => "Create",
                    'active'  => true
                ]
            ),
            'dataRoles' => [
                [
                    "id" => 0,
                    "name" => "User"
                ],
                [
                    "id" => 1,
                    "name" => "Admin"
                ],
                [
                    "id" => 2,
                    "name" => "Super Admin"
                ]
            ],
            'dataEmployees' => Employee::select('id', 'nik')->get(),
            '_token' => csrf_token(),
            '__store'  => 'super.user.store',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'email'        => 'required|unique:App\User,email|max:50',
            'password'     => 'required|min:8',
            'role'         => 'required',
            'employee'     => 'required',
        ]);
        $user = User::create([
            'name'              => $request->input('name'),
            'email'             => $request->input('email'),
            'password'          => Hash::make($request->input('password')),
            'email_verified_at' => now(),
            'role'              => $request->input('role'),
            'id_employee'       => $request->input('employee'),
        ]);
        return Redirect::route('super.user.index')->with('success', "Successfull Create new User $user->email");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('Super/User/edit', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'   => "User Management",
                    'href'  => "super.user.index"
                ],
                [
                    'title'   => $user->email,
                    'active'  => true
                ]
            ),
            'dataRoles' => [
                [
                    "id" => 0,
                    "name" => "User"
                ],
                [
                    "id" => 1,
                    "name" => "Admin"
                ],
                [
                    "id" => 2,
                    "name" => "Super Admin"
                ]
            ],
            'dataEmployees' => Employee::select('id', 'nik')->get(),
            'dataUser' => $user,
            '_token' => csrf_token(),
            '__update'  => 'super.user.update',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required',
            'email'        => "required|unique:App\User,email,$id|max:50",
            'newpassword'  => 'nullable',
            'role'         => 'required',
            'id_employee'     => 'required',
        ]);
        User::where('id', $id)->update([
            'name'         => $request->input('name'),
            'email'        => $request->input('email'),
            'role'         => $request->input('role'),
            'id_employee'  => $request->input('id_employee'),
        ]);

        if ($request->input('newpassword')) {
            User::where('id', $id)->update([
                'password' => Hash::make($request->input('newpassword'))
            ]);
        }
        return Redirect::route('super.user.index')->with('success', "Successfull updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();
        return Redirect::route('super.user.index')->with('success', "User $user->email deleted.");
    }
}
