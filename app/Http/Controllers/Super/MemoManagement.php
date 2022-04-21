<?php

namespace App\Http\Controllers\Super;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Memo;
use App\Models\Ref_Type_Memo;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MemoManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return Inertia::render('Super/Memo_Management', [
            'dataMemos' => Memo::getAllMemo($request->input('search'))->paginate(10),
            'perPage' => 10,
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'   => "Memo Management",
                    'active'  => true
                ]
            ),
            '__index'   => 'super.memo_management.index',
            '__update'  => 'super.memo_management.update',
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
        Memo::where('id', $id)->update([
            'id_employee2' => $request->input('id_employee2'),
            'id_type' => $request->input('id_type_memo'),
            'confirmed_payment_by' => $request->input('id_confirmed_payment'),
        ]);

        return Redirect::route('super.memo_management.index')->with('success', "Successfull Edit Memo");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
