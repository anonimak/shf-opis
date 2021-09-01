<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;
use App\Models\D_Memo_Approver;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $memo = Memo::getMemoWithLastApproverRawQuery(auth()->user()->id_employee);
        // $memo = Memo::getMemoWithLastApprover(auth()->user()->id_employee,  "submit", $request->input('search'))->paginate(10);
        return Inertia::render('User/Approval', [
            'dataMemo' => $memo,
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Approval",
                    'active'  => true
                ],

                [
                    'title'   => "Memo",
                    'active'  => true
                ]
            ),
            '__approving'  => 'user.memo.approval.approving',
            '__detail'    => 'user.memo.approval.detail',
            '__index'    => 'user.memo.approval.index',
        ]);
    }

    public function detail($id)
    {
    }

    public function approving(Request $request, $id)
    {
        $status_approver = $request->input('variant');

        $approver = D_Memo_Approver::where('id', $id)->first();
        $memo = Memo::where('id', $approver->id_memo)->with('proposeemployee')->first();

        D_Memo_Approver::where('id', $id)->update([
            'status'            => $status_approver
        ]);

        if ($status_approver == 'approve') {
            $nextApprover = D_Memo_Approver::where('id_memo', $approver->id_memo)->where('status', 'submit')->orderBy('idx', 'asc')->first();

            if ($nextApprover) {
                // send email to next approver
                $mailApprover = $nextApprover->employee->email;
                // kirim email ke approver pertama
                $details = [
                    'subject' => $memo->title,
                    'doc_no'  => $memo->doc_no,
                    'url'     => url('')
                ];

                $detailspropose = [
                    'subject' => "Memo $memo->doc_no approved by {$nextApprover->employee->firstname}",
                    'message' => "Memo $memo->doc_no has approved by {$nextApprover->employee->firstname} {$nextApprover->employee->lastname}"
                ];

                Mail::to($mailApprover)->send(new \App\Mail\ApprovalMemoMail($details));
                Mail::to($memo->proposeemployee->email)->send(new \App\Mail\NotifUserProposeMail($detailspropose));
            } else {
                Memo::where('id', $approver->id_memo)->update(['status' => 'approve']);

                $detailspropose = [
                    'subject' => "Memo $memo->doc_no approved",
                    'message' => "Memo $memo->doc_no has approved"
                ];
                // notif ke user propose
                Mail::to($memo->proposeemployee->email)->send(new \App\Mail\NotifUserProposeMail($detailspropose));
            }
        }

        if ($status_approver == 'revisi') {
            // notif ke user propose
            Memo::where('id', $approver->id_memo)->update(['status' => 'revisi']);

            $detailspropose = [
                'subject' => "Memo $memo->doc_no revisi",
                'message' => "Memo $memo->doc_no has revisi"
            ];
            // notif ke user propose
            Mail::to($memo->proposeemployee->email)->send(new \App\Mail\NotifUserProposeMail($detailspropose));
        }

        if ($status_approver == 'reject') {
            // notif ke user propose
            Memo::where('id', $approver->id_memo)->update(['status' => 'revisi']);

            $detailspropose = [
                'subject' => "Memo $memo->doc_no reject",
                'message' => "Memo $memo->doc_no has reject"
            ];
            // notif ke user propose
            Mail::to($memo->proposeemployee->email)->send(new \App\Mail\NotifUserProposeMail($detailspropose));
        }

        return Redirect::route('user.memo.approval.index')->with('success', "Successfull " . $request->input('variant'));
    }
}
