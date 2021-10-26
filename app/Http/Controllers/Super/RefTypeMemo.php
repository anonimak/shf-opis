<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Ref_Module_Approver;
use App\Models\Ref_Type_Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RefTypeMemo extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Super/Ref_Type_Memo', [
            'dataRefTypeMemo' => Ref_Type_Memo::getRef_Type_Memo($request->input('search'))->paginate(10),
            'perPage' => 10,
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'   => "Reference Type Memo",
                    'active'  => true
                ]
            ),
            '__create'  => 'super.ref_type_memo.create',
            '__edit'    => 'super.ref_type_memo.edit',
            '__show'    => 'super.ref_type_memo.show',
            '__destroy' => 'super.ref_type_memo.destroy',
            '__template' => 'super.ref_template_memo.index',
            '__index'   => 'super.ref_type_memo.index'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Super/Ref_Type_Memo/create', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'   => "Reference Type Memo",
                    'href'  => "super.ref_type_memo.index"
                ],
                [
                    'title'   => "Create",
                    'active'  => true
                ]
            ),
            'dataDepartments'       => Department::get(),
            'dataRefModuleApprovers' => Ref_Module_Approver::get(),
            '_token' => csrf_token(),
            '__store'  => 'super.ref_type_memo.store',
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
            'name'                 => 'required|max:50',
            'department'           => 'required',
            'refmoduleapprover'    => 'required',
        ]);
        $position = Ref_Type_Memo::create([
            'name'                      => $request->input('name'),
            'id_department'             => $request->input('department'),
            'id_ref_module_approver'    => $request->input('refmoduleapprover'),
        ]);
        return Redirect::route('super.ref_type_memo.index')->with('success', "Successfull Create new Reference Type Memo $position->name");
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
    public function edit($id)
    {
        $typememo = Ref_Type_Memo::where('id', $id)->first();
        return Inertia::render('Super/Ref_Type_Memo/edit', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'     => "Reference Type Memo",
                    'href'      => "super.ref_type_memo.index"
                ],
                [
                    'title'     => $typememo->name,
                    'active'    => true
                ]
            ),
            'dataRef_Type_Memo' => [
                'name'              => $typememo->name,
                'department'        => $typememo->id_department,
                'refmoduleapprover' => $typememo->id_ref_module_approver,
                'id'                => $typememo->id
            ],
            'dataDepartments'           => Department::get(),
            'dataRefModuleApprovers'    => Ref_Module_Approver::get(),
            '_token'                    => csrf_token(),
            '__create'                  => 'super.ref_type_memo.create',
            '__update'                  => 'super.ref_type_memo.update',
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
            'name'                 => 'required|max:50',
            'department'           => 'required',
            'refmoduleapprover'    => 'required',
        ]);

        Ref_Type_Memo::where('id', $id)->update([
            'name'                      => $request->input('name'),
            'id_department'             => $request->input('department'),
            'id_ref_module_approver'    => $request->input('refmoduleapprover'),
        ]);
        return Redirect::route('super.ref_type_memo.index')->with('success', "Successfull updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $typememo = Ref_Type_Memo::where('id', $id)->first();
        $typememo->delete();
        return Redirect::route('super.ref_type_memo.index')->with('success', "Ref_Position Office $typememo->name deleted.");
    }
}
