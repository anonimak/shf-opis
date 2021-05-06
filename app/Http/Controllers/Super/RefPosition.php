<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Ref_Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RefPosition extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Super/Ref_Position', [
            'dataRefPositions' => Ref_Position::getRef_Positions($request->input('search'))->with('departement')->paginate(10),
            'perPage' => 10,
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'   => "Reference Position",
                    'active'  => true
                ]
            ),
            '__create'  => 'super.ref_position.create',
            '__edit'    => 'super.ref_position.edit',
            '__show'    => 'super.ref_position.show',
            '__destroy' => 'super.ref_position.destroy',
            '__index'   => 'super.ref_position.index'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return Inertia::render('Super/Ref_Position/create', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'   => "Reference Position",
                    'href'  => "super.ref_position.index"
                ],
                [
                    'title'   => "Create",
                    'active'  => true
                ]
            ),
            'dataDepartments'   => Department::get(),
            '_token' => csrf_token(),
            '__store'  => 'super.ref_position.store',
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
            'position'   => 'required|max:50',
            'departement'    => 'required',
        ]);
        $position = Ref_Position::create([
            'position_name'         => $request->input('position'),
            'id_departement'        => $request->input('departement')
        ]);
        return Redirect::route('super.ref_position.index')->with('success', "Successfull Create new Ref_Position $position->position_name");
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
        $position = Ref_Position::where('id', $id)->first();
        return Inertia::render('Super/Ref_Position/edit', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'     => "Reference Position",
                    'href'      => "super.ref_position.index"
                ],
                [
                    'title'     => $position->position_name,
                    'active'    => true
                ]
            ),
            'dataRef_Position'      => [
                'position'      => $position->position_name,
                'departement'   => $position->id_departement,
                'id'            => $position->id
            ],
            'dataDepartments'   => Department::get(),
            '_token'        => csrf_token(),
            '__create'      => 'super.ref_position.create',
            '__update'      => 'super.ref_position.update',
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
            'position'     => 'required|max:50',
            'departement'    => 'required',
        ]);

        Ref_Position::where('id', $id)->update([
            'position_name'   => $request->input('position'),
            'id_departement'       => $request->input('departement')
        ]);
        return Redirect::route('super.ref_position.index')->with('success', "Successfull updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $position = Ref_Position::where('id', $id)->first();
        $position->delete();
        return Redirect::route('super.ref_position.index')->with('success', "Ref_Position Office $position->position_name deleted.");
    }
}
