<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        // Synchronously
        $dataBranch = Branch::getBranches()->count();
        $dataDepartment = Department::getDepartments()->count();
        $dataEmployee = Employee::getEmployees()->count();
        //ddd($dataBranch);
        return Inertia::render('Admin/Dashboard', [
            'meta' => [
                'title' => 'tests',
                'foo' => 'bar',
                'branches' => $dataBranch,
                'departments' => $dataDepartment,
                'employees' => $dataEmployee
            ],

        ]);
    }
}
