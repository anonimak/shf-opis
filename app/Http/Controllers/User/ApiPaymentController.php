<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\D_Payment_Approver;
use App\Models\D_Memo_Payments;
use Illuminate\Http\Request;

class ApiPaymentController extends Controller
{
    //
    public function updateApprover(Request $request, $id_memo)
    {
        $memoapprover = D_Payment_Approver::where('id_memo', $id_memo)->get();
        $updatedapprover = $request->input('approver');
        // filter yang tidak ada pada updatedapprover
        $filteredapprove = $memoapprover->filter(function ($item, $key) use ($updatedapprover) {
            if (count($updatedapprover)) {
                $itemapprover = array_column($updatedapprover, 'id_employee');
                $key = in_array($item->id_employee, $itemapprover);
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
        if (count($updatedapprover) > 0) {
            foreach ($updatedapprover as $key => $value) {
                $itemapprover = D_Payment_Approver::where('id_memo', $id_memo)->where('id_employee', $value['id_employee'])->first();
                $item = [
                    'id_memo' => $value['id_memo'],
                    'id_employee'   =>  $value['id_employee'],
                    'idx' => $key + 1,
                    'type_approver' => $value['type_approver']
                ];
                if ($itemapprover) {
                    $itemapprover->update($item);
                } else {
                    D_Payment_Approver::create($item);
                }
            }
        }

        // return Redirect::back()->with('success', "Successfull updated approver.");
        return response()->json([
            'status' => 200,
            'message' => 'Successfull update approver.',
        ]);
    }

    public function getApproversByIdMemo($id)
    {
        $approvers = D_Payment_Approver::where('id_memo', $id)->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                return $position_now->with(['position' => function ($position) {
                    return $position->with('department');
                }])->with('branch');
            }]);
        }])->orderBy('idx', 'asc')->get();

        return response()->json($approvers);
    }

    public function getPaymentsByIdMemo($id)
    {
        $dataPayment = D_Memo_Payments::where('id_memo', $id)->get();

        return response()->json($dataPayment);
    }

    public function paymentStore(Request $request, $id) {

        $request->validate([
            'name'              => 'required',
            'bank_name'         => 'required',
            'bank_account'      => 'required',
            'amount'            => 'required',
            'remark'            => 'required',
            'address'           => 'required',
        ]);

        $memoPayment = D_Memo_Payments::create([
            'id_memo'           => $id,
            'name'              => $request->input('name'),
            'bank_name'         => $request->input('bank_name'),
            'bank_account'      => $request->input('bank_account'),
            'amount'            => $request->input('amount'),
            'remark'            => $request->input('remark'),
            'address'           => $request->input('address')
        ]);

        return response()->json([
            'id' => $memoPayment->id,
            'status' => 200,
            'message' => 'Successfull add data vendor',
        ]);
   }
}
