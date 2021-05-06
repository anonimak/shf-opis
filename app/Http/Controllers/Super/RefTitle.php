<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Ref_Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RefTitle extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Super/Ref_Title', [
            'dataRefTitles' => Ref_Title::getRef_Titles($request->input('search'))->paginate(10),
            'perPage' => 10,
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'   => "Reference Title",
                    'active'  => true
                ]
            ),
            '__create'  => 'super.ref_title.create',
            '__edit'    => 'super.ref_title.edit',
            '__show'    => 'super.ref_title.show',
            '__destroy' => 'super.ref_title.destroy',
            '__index'   => 'super.ref_title.index'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return Inertia::render('Super/Ref_Title/create', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'   => "Reference Title",
                    'href'  => "super.ref_title.index"
                ],
                [
                    'title'   => "Create",
                    'active'  => true
                ]
            ),
            '_token' => csrf_token(),
            '__store'  => 'super.ref_title.store',
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
            'title'   => 'required|max:50'
        ]);
        $title = Ref_Title::create([
            'title_name'         => $request->input('title')
        ]);
        return Redirect::route('super.ref_title.index')->with('success', "Successfull Create new Reference Title $title->title_name");
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
        $title = Ref_Title::where('id', $id)->first();
        return Inertia::render('Super/Ref_Title/edit', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "super.dashboard"
                ],
                [
                    'title'     => "Reference Title",
                    'href'      => "super.ref_title.index"
                ],
                [
                    'title'     => $title->title_name,
                    'active'    => true
                ]
            ),
            'dataRef_Title'      => [
                'title'      => $title->title_name,
                'id'            => $title->id
            ],
            '_token'        => csrf_token(),
            '__create'      => 'super.ref_title.create',
            '__update'      => 'super.ref_title.update',
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
            'title'     => 'required|max:50'
        ]);

        Ref_Title::where('id', $id)->update([
            'title_name'   => $request->input('title')
        ]);
        return Redirect::route('super.ref_title.index')->with('success', "Successfull updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $title = Ref_Title::where('id', $id)->first();
        $title->delete();
        return Redirect::route('super.ref_title.index')->with('success', "Reference Title $title->title_name deleted.");
    }
}
