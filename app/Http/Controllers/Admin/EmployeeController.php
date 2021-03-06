<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ImportEmployee;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Employee_History;
use App\Models\Ref_Position;
use App\Models\Ref_Title;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Admin/Employee', [
            'dataEmployees' => Employee::getEmployees($request->input('search'))->paginate(10),
            'perPage' => 10,
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "admin.dashboard"
                ],
                [
                    'title'   => "Employee",
                    'active'  => true
                ]
            ),
            '__create'  => 'admin.employee.create',
            '__edit'    => 'admin.employee.edit',
            '__show'    => 'admin.employee.show',
            '__destroy' => 'admin.employee.destroy',
            '__index'   => 'admin.employee.index',
            '__importexcel' => 'admin.employee.importexcel'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Employee/create', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "admin.dashboard"
                ],
                [
                    'title'   => "Employee",
                    'href'  => "admin.employee.index"
                ],
                [
                    'title'   => "Create",
                    'active'  => true
                ]
            ),
            'dataBranch' => Branch::select('id', 'branch_name')->get(),
            'dataTitle' => Ref_Title::select('id', 'title_name')->get(),
            '_token' => csrf_token(),
            '__store'  => 'admin.employee.store',
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
            'branch'         => 'required',
            'title'          => 'nullable',
            'firstname'         => 'required|max:30',
            'lastname'          => 'nullable|max:30',
            'gender'            => 'required',
            'nik'               => 'required|unique:App\Models\Employee,nik|max:10',
            'address'           => 'nullable|max:180',
            'address_two'       => 'nullable|max:180',
            'email'             => 'required|unique:App\Models\Employee,email|max:50',
            'email2'             => 'nullable|max:50',
            'mobile'            => 'nullable|max:25',
            'phone'             => 'nullable|max:25',
            'phone_two'         => 'nullable|max:25',
            'hired_at'          => 'nullable|date',
            'terminated_at'     => 'nullable|date'
        ]);
        $employee = Employee::create([
            'id_branch'         => $request->input('branch'),
            'id_title'         => $request->input('title'),
            'firstname'         => $request->input('firstname'),
            'lastname'          => $request->input('lastname'),
            'gender'            => $request->input('gender'),
            'nik'               => $request->input('nik'),
            'address'           => $request->input('address'),
            'address_two'       => $request->input('address_two'),
            'email'             => $request->input('email'),
            'email2'             => $request->input('email2'),
            'mobile'            => $request->input('mobile'),
            'phone'             => $request->input('phone'),
            'phone_two'         => $request->input('phone_two'),
            'hired_at'          => $request->input('hired_at'),
            'terminated_at'     => $request->input('terminated_at')
        ]);
        return Redirect::route('admin.employee.show', $employee->id)->with('success', "Successfull Create new Employee $employee->firstname $employee->lastname");
    }

    public function empStore(Request $request, $id)
    {
        $request->validate([
            'id_branch'         => 'required',
            'id_position'       => 'required',
            'year_started'      => 'required|date',
            'year_finished'      => 'nullable|date'
        ]);

        $new_year_finished = ($request->filled('year_finished')) ? Carbon::parse($request->input('year_finished'))->addHours(23)->addMinutes(59)->addSeconds(59) : null;

        Employee_History::create([
            'id_employee'       => $id,
            'id_branch'         => $request->input('id_branch'),
            'id_position'       => $request->input('id_position'),
            'year_started'      => $request->input('year_started'),
            'year_finished'     => $new_year_finished,
        ]);
        return Redirect::route('admin.employee.show', $id)->with('success', "Successfull Create new Employee History");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::where('id', $id)->with('title')->with('branch')->first();
        // dd(Employee_History::where('id_employee', $employee->id)->with('position')->with('branch')->get());
        return Inertia::render('Admin/Employee/show', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "admin.dashboard"
                ],
                [
                    'title'   => "Employee",
                    'href'  => "admin.employee.index"
                ],
                [
                    'title'   => $employee->nik,
                    'active'  => true
                ]
            ),
            'employee' => $employee,
            'employee_detail' => Employee_History::where('id_employee', $employee->id)->with('position')->with('branch')->get(),
            'dataBranch' => Branch::get(),
            'dataPosition' => Ref_Position::get(),
            '__edit'  => 'admin.employee.edit',
            '__destroy_history' => 'admin.employee.history.destroy'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return Inertia::render('Admin/Employee/edit', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "admin.dashboard"
                ],
                [
                    'title'   => "Employee",
                    'href'  => "admin.employee.index"
                ],
                [
                    'title'   => $employee->nik,
                    'href'  => "admin.employee.show",
                    'param' => $employee->id
                ],
                [
                    'title'   => "Edit",
                    'active'  => true
                ]
            ),
            'dataBranch' => Branch::select('id', 'branch_name')->get(),
            'dataTitle' => Ref_Title::select('id', 'title_name')->get(),
            'dataEmployee' => $employee,
            '_token' => csrf_token(),
            '__update'  => 'admin.employee.update',
            '__terminate'  => 'admin.employee.terminate',
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
            'id_branch'         => 'required',
            'id_title'          => 'nullable',
            'firstname'         => 'required|max:30',
            'lastname'          => 'nullable|max:30',
            'gender'            => 'required',
            'nik'               => "required|unique:App\Models\Employee,nik,$id|max:10",
            'address'           => 'nullable|max:180',
            'address_two'       => 'nullable|max:180',
            'email'             => "required|unique:App\Models\Employee,email,$id|max:50",
            'email2'             => "nullable|max:50",
            'mobile'            => 'nullable|max:25',
            'phone'             => 'nullable|max:25',
            'phone_two'         => 'nullable|max:25',
            'hired_at'          => 'nullable|date',
        ]);

        Employee::where('id', $id)->update([
            'id_branch'         => $request->input('id_branch'),
            'id_title'          => $request->input('id_title'),
            'firstname'         => $request->input('firstname'),
            'lastname'          => $request->input('lastname'),
            'gender'            => $request->input('gender'),
            'nik'               => $request->input('nik'),
            'address'           => $request->input('address'),
            'address_two'       => $request->input('address_two'),
            'email'             => $request->input('email'),
            'email2'             => $request->input('email2'),
            'mobile'            => $request->input('mobile'),
            'phone'             => $request->input('phone'),
            'phone_two'         => $request->input('phone_two'),
            'hired_at'          => $request->input('hired_at'),
        ]);
        return Redirect::route('admin.employee.show', $id)->with('success', "Successfull updated.");
    }

    public function empUpdate(Request $request, $id, $idhistory)
    {
        $request->validate([
            'id_branch'         => 'required',
            'id_position'       => 'required',
            'year_started'      => 'required|date',
            'year_finished'      => 'nullable|date'
        ]);

        $new_year_finished = ($request->filled('year_finished')) ? Carbon::parse($request->input('year_finished'))->addHours(23)->addMinutes(59)->addSeconds(59) : null;

        Employee_History::where('id', $idhistory)->update([
            'id_branch'         => $request->input('id_branch'),
            'id_position'       => $request->input('id_position'),
            'year_started'      => $request->input('year_started'),
            'year_finished'     => $new_year_finished
        ]);
        return Redirect::route('admin.employee.show', $id)->with('success', "Successfull updated history.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::where('id', $id)->first();
        $employee->delete();
        return Redirect::route('admin.employee.index')->with('success', "Employee $employee->firstname $employee->lastname deleted.");
    }

    public function empDestroy($id, $idhistory)
    {
        $empHistory = Employee_History::where('id', $idhistory)->first();
        $empHistory->delete();
        return Redirect::route('admin.employee.show', $id)->with('success', "Employee History deleted.");
    }

    // import excel
    public function importexcel(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        // import data
        Excel::import(new ImportEmployee, $request->file('file'));

        // alihkan halaman kembali
        return Redirect::route('admin.employee.index')->with('success', "Successfull Import Excel Employee");
    }

    // on terminate
    public function terminateEmployee(Request $request, $id)
    {
        // validasi
        $this->validate($request, [
            'terminated_at' => 'required'
        ]);
        // ubah tanggal terminate employee
        $employee = Employee::find($id);
        $employee->terminated_at = $request->input('terminated_at');
        $employee->save();

        // ubah posisi employee jadi terminate
        $new_year_finished = ($request->filled('terminated_at')) ? Carbon::parse($request->input('terminated_at'))->subDay()->addHours(23)->addMinutes(59)->addSeconds(59) : null;

        $test = Employee_History::where(function ($query) use ($id) {
            $query->where('id_employee', $id)
                ->where('year_started', '<', Carbon::now())
                ->where('year_finished', '>', Carbon::now());
        })
            ->orWhere(function ($query) use ($id) {
                $query->where('id_employee', $id)
                    ->where('year_started', '<', Carbon::now())
                    ->where('year_finished', null);
            })
            ->update([
                'year_finished'     => $new_year_finished
            ]);

        $nullBranch = Branch::where('branch_name', 'NULL')->first();
        $nullPosition = Ref_Position::where('position_name', 'TERMINATE')->first();
        Employee_History::create([
            'id_employee'       => $id,
            'id_branch'         => $nullBranch->id,
            'id_position'       => $nullPosition->id,
            'year_started'      => $request->input('terminated_at'),
            'year_finished'     => null,
        ]);
        return Redirect::route('admin.employee.show', $id)->with('success', "Successfull Terminated.");
    }
}
