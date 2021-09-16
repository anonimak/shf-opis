<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;
use App\Models\D_Memo_Approver;
use App\Models\D_Memo_Attachment;
use App\Models\D_Memo_History;
use App\Models\Employee;
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
                    'title'   => "Approval Memo",
                    'active'  => true
                ]
            ),
            '__approving'  => 'user.memo.approval.approving',
            '__previewpdf'  => 'user.memo.approval.preview',
            '__detail'    => 'user.memo.approval.detail',
            '__index'    => 'user.memo.approval.index',
        ]);
    }


    public function detail(Request $request, $id)
    {
        $memo = Memo::getMemoDetailWithCurrentApprover($id, auth()->user()->id_employee);
        $proposeEmployee = Employee::getWithPositionNowById($memo);
        $memocost = (array) json_decode($memo->cost);
        $attachments = D_Memo_Attachment::where('id_memo', $id)->get();

        return Inertia::render('User/Approval/preview', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Approval Memo",
                    'href'  => "user.memo.approval.index"
                ],
                [
                    'title'   => $memo->doc_no,
                    'active'  => true
                ]
            ),
            'dataMemo' => $memo,
            'proposeEmployee' => $proposeEmployee,
            'memocost' => $memocost,
            'attachments' => $attachments,
            '__approving'  => 'user.memo.approval.approving',
        ]);
    }

    public function approving(Request $request, $id)
    {
        $status_approver = $request->input('variant');
        $msg = ($request->input('message')) ? $request->input('message') : null;
        $message = ($msg ? "with message ($msg)" : "");
        $approver = D_Memo_Approver::where('id', $id)->first();

        $memo = Memo::where('id', $approver->id_memo)->with('proposeemployee')->first();
        D_Memo_Approver::where('id', $id)->update([
            'status'            => $status_approver,
            'msg'               => $msg
        ]);

        if ($status_approver == 'approve') {
            // insert to history when approved
            D_Memo_History::create([
                'title'     => "Approved lvl {$approver->idx}",
                'id_memo'   => $memo->id,
                'type'      => 'success',
                'content'   => "Approved by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}) $message"
            ]);
            $nextApprover = D_Memo_Approver::where('id_memo', $approver->id_memo)->where('status', 'submit')->with('employee')->orderBy('idx', 'asc')->first();

            if ($nextApprover) {
                // insert to history next approval
                D_Memo_History::create([
                    'title' => "Process Approving {$nextApprover->idx}",
                    'id_memo'   => $memo->id,
                    'type'  => 'info',
                    'content' => "On process approving by approver {$nextApprover->idx}"
                ]);
                // send email to next approver
                $mailApprover = $nextApprover->employee->email;
                // kirim email ke approver pertama
                $details = [
                    'subject' => $memo->title,
                    'doc_no'  => $memo->doc_no,
                    'url'     => route('user.memo.approval.detail', $memo->id)
                ];

                $detailspropose = [
                    'subject' => "Memo $memo->doc_no approved by {$nextApprover->employee->firstname}",
                    'message' => "Memo $memo->doc_no has approved by {$nextApprover->employee->firstname} {$nextApprover->employee->lastname}"
                ];

                Mail::to($mailApprover)->send(new \App\Mail\ApprovalMemoMail($details));
                Mail::to($memo->proposeemployee->email)->send(new \App\Mail\NotifUserProposeMail($detailspropose));
            } else {
                Memo::where('id', $approver->id_memo)->update(['status' => 'approve']);
                // insert to history when all approved by approver
                D_Memo_History::create([
                    'title'     => "Memo Approved",
                    'id_memo'   => $memo->id,
                    'type'      => 'success',
                    'content'   => "Memo {$memo->doc_no} has approved."
                ]);

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
            // insert to history when revisi by approver
            D_Memo_History::create([
                'title'     => "Memo Revisi",
                'id_memo'   => $memo->id,
                'type'      => 'warning',
                'content'   => "Memo {$memo->doc_no} has revisi by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}). $message"
            ]);

            $detailspropose = [
                'subject' => "Memo $memo->doc_no revisi",
                'message' => "Memo $memo->doc_no has revisi by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}). $message"
            ];
            // notif ke user propose
            Mail::to($memo->proposeemployee->email)->send(new \App\Mail\NotifUserProposeMail($detailspropose));
        }

        if ($status_approver == 'reject') {
            // notif ke user propose
            Memo::where('id', $approver->id_memo)->update(['status' => 'reject']);
            // insert to history when revisi by approver
            D_Memo_History::create([
                'title'     => "Memo Rejected",
                'id_memo'   => $memo->id,
                'type'      => 'danger',
                'content'   => "Memo {$memo->doc_no} has rejected by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}). $message"
            ]);

            $detailspropose = [
                'subject' => "Memo $memo->doc_no rejected",
                'message' => "Memo $memo->doc_no has rejected by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}). $message"
            ];
            // notif ke user propose
            Mail::to($memo->proposeemployee->email)->send(new \App\Mail\NotifUserProposeMail($detailspropose));
        }

        return Redirect::route('user.memo.approval.index')->with('success', "Successfull " . $request->input('variant'));
    }
}
