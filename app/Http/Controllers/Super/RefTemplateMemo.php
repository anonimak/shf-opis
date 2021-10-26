<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Ref_Template_Cost as ModelsRef_Template_Cost;
use App\Models\Ref_Type_Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RefTemplateMemo extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $typeMemo = Ref_Type_Memo::where('id', $id)->first();
        return Inertia::render('Super/Ref_Type_Memo/template/index', [
            'dataRefTemplateCost' => ModelsRef_Template_Cost::where('id_ref_type_memo', $id)->get(),
            'idTypeMemo'          => $id,
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
                    'href'    => "super.ref_type_memo.index"
                ],
                [
                    'title'   => $typeMemo->name,
                    'active'  => true
                ],
                [
                    'title'   => "Template",
                    'active'  => true
                ]
            ),
            // '__show'    => 'super.ref_type_memo.show',
            '__store_cost'  => 'super.ref_template_memo.store_template_cost',
            '__update_cost'    => 'super.ref_template_memo.update_template_cost',
            '__destroy_cost'     => 'super.ref_template_memo.destroy_template_cost',
            '__index'       => 'super.ref_template_memo.index'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTemplateCost(Request $request, $id)
    {
        $request->validate([
            'col_name'             => 'required|max:50',
            'width'                => 'required',
        ]);
        $templatecost = ModelsRef_Template_Cost::create([
            'col_name'                  => $request->input('col_name'),
            'width'                     => $request->input('width'),
            'id_ref_type_memo'          => $id,
        ]);
        return Redirect::back()->with('success', "Successfull Create new Reference Template Cost Memo $templatecost->col_name");
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTemplateCost(Request $request, $id)
    {
        // $request->validate([
        //     'edit_col_name'             => 'required|max:50',
        //     'edit_width'                => 'required',
        // ]);

        ModelsRef_Template_Cost::where('id', $id)->update([
            'col_name'                  => $request->input('edit_col_name'),
            'width'                     => $request->input('edit_width'),
        ]);
        return Redirect::back()->with('success', "Successfull updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyTemplateCost($id)
    {
        $templatecost = ModelsRef_Template_Cost::where('id', $id)->first();
        $templatecost->delete();
        return Redirect::back()->with('success', "Ref Template Cost $templatecost->col_name deleted.");
    }
}
