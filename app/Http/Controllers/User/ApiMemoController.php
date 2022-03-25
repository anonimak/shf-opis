<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\D_Memo_Approver;
use App\Models\Employee_History;
use App\Models\Ref_Type_Memo;
use App\Models\Memo;
use Illuminate\Http\Request;

class ApiMemoController extends Controller
{
    //

    public function getPositionNow()
    {
        $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname');
        }])->with(['position' => function ($p) {
            return $p->where('position_name', '<>', 'TERMINATE');
        }])->get();
        $positions = $positions->unique('id_employee')->whereNotNull('position')->values()->all();

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

    public function getTypeMemoByIdMemo($id)
    {
        $proposeEmployee = Memo::with(['proposeemployee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                return $position_now->with(['position' => function ($position) {
                    return $position->with('department');
                }])->with('branch');
            }]);
        }])
            ->where('id', $id)->first();

        $isHeadOffice =  $proposeEmployee->proposeemployee->position_now->branch->is_head;
        if (!$isHeadOffice) {
            $dataTypeMemo = Ref_Type_Memo::whereNull('id_department')->orWhere(function ($query) use ($proposeEmployee) {
                $query->where('id_department', $proposeEmployee->proposeemployee->position_now->position->id_department);
                $query->where('id_branch', $proposeEmployee->proposeemployee->position_now->branch->id);
            })
                ->orderBy('id_department', 'asc')->get();
        } else {
            $dataTypeMemo = Ref_Type_Memo::whereNull('id_department')
                ->orWhere(function ($query) use ($proposeEmployee) {
                    $query->where('id_department', $proposeEmployee->proposeemployee->position_now->position->id_department);
                })
                ->orderBy('id_department', 'asc')->get();
        }


        return response()->json($dataTypeMemo);
    }
}
