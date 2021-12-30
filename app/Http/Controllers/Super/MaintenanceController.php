<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Maintenance;
use Illuminate\Support\Facades\Redirect;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return Inertia::render('Super/Maintenance', [
            'dataMaintenance' => Maintenance::getMsgMaintenance()->paginate(10),
            'perPage' => 10,
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'   => "Maintenance",
                    'active'  => true
                ]
            ),
            'filters' => $request->all(),
            '__create'  => 'super.maintenance.create',
            '__edit'    => 'super.maintenance.edit',
            '__show'    => 'super.maintenance.show',
            '__destroy' => 'super.maintenance.destroy',
            '__index'   => 'super.maintenance.index'
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
        return Inertia::render('Super/Maintenance/create', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'   => "Maintenance",
                    'href'  => "super.maintenance.index"
                ],
                [
                    'title'   => "Create",
                    'active'  => true
                ]
            ),
            '_token' => csrf_token(),
            '__store'  => 'super.maintenance.store',
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
        //
        $request->validate([
            'msg'   => 'required',
            'status'    => 'required',
            'type'    => 'required',
        ]);
        Maintenance::create([
            'msg'   => $request->input('msg'),
            'status' => $request->input('status'),
            "type" => $request->input('type'),
        ]);

        return Redirect::route('super.maintenance.index')->with('success', "Successfull Create new Maintenance Message");
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
        $maintenance = Maintenance::where('id', $id)->first();
        return Inertia::render('Super/Maintenance/edit', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'     => "Maintenance",
                    'href'      => "super.maintenance.index"
                ],
                [
                    'title'     => "Maintenance Edit",
                    'active'    => true
                ]
            ),
            'dataMaintenance'      => [
                'msg'       => $maintenance->msg,
                'status'    => $maintenance->status,
                'type'      => $maintenance->type,
                'id'        => $maintenance->id
            ],
            '_token'        => csrf_token(),
            '__create'      => 'super.maintenance.create',
            '__update'      => 'super.maintenance.update',
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
        //
        $request->validate([
            'msg'     => 'required',
            'status'  => 'required',
            'type'    => 'required',
        ]);

        Maintenance::where('id', $id)->update([
            'msg'   => $request->input('msg'),
            'status'       => $request->input('status'),
            'type'       => $request->input('type')
        ]);
        return Redirect::route('super.maintenance.index')->with('success', "Successfull updated.");
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
        $maintenance = Maintenance::where('id', $id)->first();
        $maintenance->delete();
        return Redirect::route('super.maintenance.index')->with('success', "Maintenance Message deleted.");
    }
}
