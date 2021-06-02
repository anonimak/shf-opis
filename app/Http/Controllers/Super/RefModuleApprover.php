<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Ref_Module_Approver as Ref_Approver;
use App\Models\Ref_Module_Approver_Detail as Ref_DetailApprover;
use App\Models\Ref_Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

use function PHPSTORM_META\map;

class RefModuleApprover extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Super/Ref_Approver', [
            'dataRefApproves' => Ref_Approver::getRef_Approver($request->input('search'))->paginate(10),
            'perPage' => 10,
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'   => "Reference Approver",
                    'active'  => true
                ]
            ),
            '__create'  => 'super.ref_approver.create',
            '__edit'    => 'super.ref_approver.edit',
            '__show'    => 'super.ref_approver.show',
            '__destroy' => 'super.ref_approver.destroy',
            '__index'   => 'super.ref_approver.index'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Super/Ref_Approver/create', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'   => "Reference Approver",
                    'href'  => "super.ref_approver.index"
                ],
                [
                    'title'   => "Create",
                    'active'  => true
                ]
            ),
            'dataPosition' => Ref_Position::select('id', 'position_name')->get(),
            '_token' => csrf_token(),
            '__store'  => 'super.ref_approver.store',
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
            'name'   => 'required|max:50'
        ]);
        $refapprover = Ref_Approver::create([
            'name' => $request->input('name')
        ]);
        if ($request->input('detailApprover')) {
            foreach ($request->input('detailApprover') as $key => $value) {
                Ref_DetailApprover::create([
                    'id_ref_module_approver' => $refapprover->id,
                    'id_ref_position'   =>  $value['id'],
                    'index' => $key + 1
                ]);
            }
        }
        return Redirect::route('super.ref_approver.index')->with('success', "Successfull Create new Reference Approver $refapprover->name");
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
        $refapprover = Ref_Approver::where('id', $id)->with(['detailApprover' => function ($query) {
            return $query->select('id_ref_module_approver', 'id_ref_position')->with(['position' => function ($q) {
                return $q->select('id', 'position_name');
            }])->orderBy('index', 'ASC');
        }])->first();
        return Inertia::render('Super/Ref_Approver/edit', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'     => "Reference Approver",
                    'href'      => "super.ref_approver.index"
                ],
                [
                    'title'     => $refapprover->name,
                    'active'    => true
                ]
            ),
            'dataRef_Approver'      => $refapprover,
            'dataPosition' => Ref_Position::select('id', 'position_name')->get(),
            '_token'        => csrf_token(),
            '__create'      => 'super.ref_approver.create',
            '__update'      => 'super.ref_approver.update',
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
            'name'     => 'required|max:50'
        ]);

        Ref_Approver::where('id', $id)->update([
            'name'   => $request->input('name')
        ]);

        $refapprover = Ref_DetailApprover::where('id_ref_module_approver', $id)->get();
        $updatedrefapprover = $request->input('detail_approver');
        // filter yang tidak ada pada updaterefapprover
        $filteredapprove = $refapprover->filter(function ($item, $key) use ($updatedrefapprover) {
            if (count($updatedrefapprover)) {
                $itemapprover = array_column($updatedrefapprover, 'id_ref_position');
                $key = in_array($item->id_ref_position, $itemapprover);
                if (!$key) {
                    return $item;
                }
            }
            return $item;
        });

        // delete filter yang tidak ada pada updaterefapprover
        if (count($filteredapprove) > 0) {
            foreach ($filteredapprove as $itemfiltered) {
                $itemfiltered->delete();
            }
        }

        // update/insert pda updaterefapprover
        if (count($updatedrefapprover) > 0) {
            foreach ($updatedrefapprover as $key => $value) {
                $itemapprover = Ref_DetailApprover::where('id_ref_position', $value['id_ref_position'])->first();
                $item = [
                    'id_ref_module_approver' => $value['id_ref_module_approver'],
                    'id_ref_position'   =>  $value['id_ref_position'],
                    'index' => $key + 1
                ];
                if ($itemapprover) {
                    $itemapprover->update($item);
                } else {
                    Ref_DetailApprover::create($item);
                }
            }
        }

        return Redirect::route('super.ref_approver.index')->with('success', "Successfull updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $refapprover = Ref_Approver::where('id', $id)->first();
        $refapprover->delete();
        return Redirect::route('super.ref_approver.index')->with('success', "Reference Approver $refapprover->name deleted.");
    }
}
