<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\D_Memo_Approver;
use App\Models\Employee_History;
use Illuminate\Http\Request;

class ApiMemoController extends Controller
{
    //

    public function getPositionNow()
    {
        $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname');
        }])->with('position')->get();

        return response()->json($positions);
    }

    public function getApproversByIdMemo($id)
    {
        $approvers = D_Memo_Approver::where('id_memo', $id)->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                return $position_now->with(['position' => function ($position) {
                    return $position->with('department');
                }])->with('branch');
            }]);
        }])->orderBy('idx', 'asc')->get();

        return response()->json($approvers);
    }
}
