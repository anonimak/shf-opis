<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\D_Po_Approver;
use Illuminate\Http\Request;

class ApiPoController extends Controller
{

    public function updateApprover(Request $request, $id_memo)
    {
        $memoapprover = D_Po_Approver::where('id_memo', $id_memo)->get();
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
                $itemapprover = D_Po_Approver::where('id_memo', $id_memo)->where('id_employee', $value['id_employee'])->first();
                $item = [
                    'id_memo' => $value['id_memo'],
                    'id_employee'   =>  $value['id_employee'],
                    'idx' => $key + 1,
                    'type_approver' => $value['type_approver']
                ];
                if ($itemapprover) {
                    $itemapprover->update($item);
                } else {
                    D_Po_Approver::create($item);
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
        $approvers = D_Po_Approver::where('id_memo', $id)->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                return $position_now->with(['position' => function ($position) {
                    return $position->with('department');
                }])->with('branch');
            }]);
        }])->orderBy('idx', 'asc')->get();

        return response()->json($approvers);
    }

    // public function proposePo($id)
    // {
    //     $memo = Memo::where('id', $id)->with('approvers')->first();

    //     $approvers_po = $memo->approvers->map(function ($approver) use ($id) {
    //         return [
    //             'id_memo' => $id,
    //             'id_employee' => $approver->id_employee,
    //             'idx' => $approver->idx,
    //             'status' => $approver->status,
    //             'type_approver' => $approver->type_approver
    //         ];
    //     });

    //     D_Po_Approver::insert($approvers_po->toArray());

    //     // cek apakah ada approver
    //     if (D_Po_Approver::where('id_memo', $id)->count() <= 0) {
    //         return Redirect::route('user.memo.statusmemo.index')->with('error', "Memo $memo->doc_no does not have approver.");
    //     }

    //     $check_history = D_Memo_History::where('id_memo', $id)->get();
    //     if ($check_history->count() > 0) {
    //         $doc_no = $memo->doc_no;
    //     }

    //     // update status menjadi submit
    //     Memo::where('id', $id)->update([
    //         'status_po'   => 'submit',
    //     ]);

    //     D_Po_Approver::where('id_memo', $id)->update([
    //         'status'   => 'submit'
    //     ]);

    //     // insert to history where first time submit
    //     D_Memo_History::create([
    //         'title' => 'PO Proposed',
    //         'id_memo'   => $id,
    //         'type'  => 'info',
    //         'content' => "PO successful submitted with document no $doc_no"
    //     ]);

    //     $firstApprover = D_Po_Approver::where('id_memo', $id)->where('status', 'submit')->orderBy('idx', 'asc')->first();
    //     // insert to history frist approval
    //     D_Memo_History::create([
    //         'title'     => "Process Approving {$firstApprover->idx}",
    //         'id_memo'   => $id,
    //         'type'      => 'info',
    //         'content'   => "On process approving by approver {$firstApprover->idx}"
    //     ]);
    //     $mailApprover = $firstApprover->employee->email;
    //     // kirim email ke approver pertama
    //     $details = [
    //         'subject' => $memo->title,
    //         'doc_no'  => $memo->doc_no,
    //         'url'     => route('user.memo.approval.po.detail', $id)
    //     ];

    //     Mail::to($mailApprover)->send(new \App\Mail\ApprovalPOMail($details));
    //     // kirim email ke tiap acknowlegde

    //     return Redirect::route('user.memo.statuspo.index')->with('success', "Successfull submit PO.");
    // }
}
