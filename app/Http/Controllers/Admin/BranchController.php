<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Branch;
use Illuminate\Support\Facades\Redirect;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return Inertia::render('Admin/Branch', [
            'dataBranches' => Branch::getBranches($request->input('search'))->paginate(10),
            'perPage' => 10,
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "admin.dashboard"
                ],
                [
                    'title'   => "Branch Office",
                    'active'  => true
                ]
            ),
            '__create'  => 'admin.branch.create',
            '__edit'    => 'admin.branch.edit',
            '__show'    => 'admin.branch.show',
            '__destroy' => 'admin.branch.destroy',
            '__index'   => 'admin.branch.index'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return Inertia::render('Admin/Branch/create', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "admin.dashboard"
                ],
                [
                    'title'   => "Branch Office",
                    'href'  => "admin.branch.index"
                ],
                [
                    'title'   => "Create",
                    'active'  => true
                ]
            ),
            '_token' => csrf_token(),
            '__store'  => 'admin.branch.store',
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
            'branch'   => 'required|max:50',
            'isHead'    => 'required',
        ]);
        $branch = Branch::create([
            'branch_name'   => $request->input('branch'),
            'is_head'       => $request->input('isHead')
        ]);
        return Redirect::route('admin.branch.index')->with('success', "Successfull Create new Branch $branch->branch_name");
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
    public function edit(Branch $branch)
    {
        return Inertia::render('Admin/Branch/edit', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "admin.dashboard"
                ],
                [
                    'title'   => "Branch Office",
                    'href'  => "admin.branch.index"
                ],
                [
                    'title'   => $branch->branch_name,
                    'active'  => true
                ]
            ),
            'dataBranch'      => [
                'branch'        => $branch->branch_name,
                'isHead'        => $branch->is_head,
                'id'            => $branch->id
            ],
            '_token'    => csrf_token(),
            '__create'  => 'admin.branch.create',
            '__update'    => 'admin.branch.update',
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
            'branch'   => 'required|max:50',
            'isHead'    => 'required',
        ]);

        Branch::where('id', $id)->update([
            'branch_name'   => $request->input('branch'),
            'is_head'       => $request->input('isHead')
        ]);
        return Redirect::route('admin.branch.index')->with('success', "Successfull updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::where('id', $id)->first();
        $branch->delete();
        return Redirect::route('admin.branch.index')->with('success', "Branch Office $branch->branch_name deleted.");
    }
}
