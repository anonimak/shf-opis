<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return Inertia::render('Admin/Department', [
            'dataDepartments' => Department::getDepartments($request->input('search')),
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "admin.dashboard"
                ],
                [
                    'title'   => "Department",
                    'active'  => true
                ]
            ),
            '__create'  => 'admin.department.create',
            '__edit'    => 'admin.department.edit',
            '__show'    => 'admin.department.show',
            '__destroy' => 'admin.department.destroy',
            '__index'   => 'admin.department.index'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Department/create', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "admin.dashboard"
                ],
                [
                    'title'   => "Department",
                    'href'  => "admin.department.index"
                ],
                [
                    'title'   => "Create",
                    'active'  => true
                ]
            ),
            '_token'    => csrf_token(),
            '__store'   => 'admin.department.store'
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
            'department'   => 'required|max:50'
        ]);
        $department = Department::create([
            'department_name'   => $request->input('department')
        ]);
        return Redirect::route('admin.department.index')->with('success', "Successfull Create new Department $department->department_name");
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
    public function edit(Department $department)
    {
        return Inertia::render('Admin/Department/edit', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "admin.dashboard"
                ],
                [
                    'title'   => "Department",
                    'href'  => "admin.department.index"
                ],
                [
                    'title'   => $department->department_name,
                    'active'  => true
                ]
            ),
            'dataDepartment'      => [
                'department'      => $department->department_name,
                'id'              => $department->id
            ],
            '_token'    => csrf_token(),
            '__create'  => 'admin.department.create',
            '__update'    => 'admin.department.update',
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
            'department'   => 'required|max:50',
        ]);

        Department::where('id', $id)->update([
            'department_name'   => $request->input('department')
        ]);
        return Redirect::route('admin.department.index')->with('success', "Successfull updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::where('id', $id)->first();
        $department->delete();
        return Redirect::route('admin.department.index')->with('success', "Department Office $department->department_name deleted.");
    }
}
