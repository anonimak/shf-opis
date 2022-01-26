<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\D_Memo_Acknowledge;
use App\Models\Memo;
use App\Models\M_Data_Cost_Total;
use Illuminate\Http\Request;
use App\Models\D_Memo_Approver;
use App\Models\D_Payment_Approver;
use App\Models\D_Memo_Attachment;
use App\Models\D_Memo_History;
use App\Models\D_Po_Approver;
use App\Models\Employee;
use App\Models\Employee_History;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {

        $tab = 'submit';
        if ($request->has('tab')) {
            $tab = $request->input('tab');
        }
        // $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
        //     return $employee->select('id', 'firstname', 'lastname');
        // }])->with('position')->get();
        $memo = Memo::getMemoWithLastApprover(auth()->user()->id_employee,  $tab,  $request->input('search'))->paginate(10);
        //ddd($memo->get());
        return Inertia::render('User/Approval', [
            'perPage' => 10,
            // 'dataMemo' => $memo,
            'dataMemoTabList' => $memo,
            'filters' => $request->all(),
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
            'tab' => ['submit', 'approve', 'reject', 'revisi'],
            'counttab' => [
                'submit' => Memo::getMemoWithLastApprover(auth()->user()->id_employee, 'submit')->count(),
                'approve' => Memo::getMemoWithLastApprover(auth()->user()->id_employee, 'approve')->count(),
                'reject' => Memo::getMemoWithLastApprover(auth()->user()->id_employee, 'reject')->count(),
                'revisi' => Memo::getMemoWithLastApprover(auth()->user()->id_employee, 'revisi')->count(),
            ],
            //'dataPosition' => $positions,
            '__approving'  => 'user.memo.approval.memo.approving',
            '__previewpdf'  => 'user.memo.approval.memo.preview',
            '__detail'    => 'user.memo.approval.memo.detail',
            '__index'    => 'user.memo.approval.memo.index',
        ]);
    }

    public function indexApprovalPayment(Request $request)
    {
        $tab = 'submit';
        if ($request->has('tab')) {
            $tab = $request->input('tab');
        }
        $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname');
        }])->with('position')->get();
        //$memo = Memo::getMemoPaymentWithLastApproverRawQuery(auth()->user()->id_employee);
        // $memo = Memo::getMemoWithLastApprover(auth()->user()->id_employee,  "submit", $request->input('search'))->paginate(10);
        return Inertia::render('User/Approval_Payment', [
            'dataMemoTabList' => Memo::getMemoPaymentWithLastApprover(auth()->user()->id_employee, $tab,  $request->input('search'))->paginate(10),
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Approval Payment",
                    'active'  => true
                ]
            ),
            'perPage' => 10,
            'tab' => ['submit', 'approve', 'reject', 'revisi'],
            'counttab' => [
                'submit' => Memo::getMemoPaymentWithLastApprover(auth()->user()->id_employee, 'submit')->count(),
                'approve' => Memo::getMemoPaymentWithLastApprover(auth()->user()->id_employee, 'approve')->count(),
                'reject' => Memo::getMemoPaymentWithLastApprover(auth()->user()->id_employee, 'reject')->count(),
                'revisi' => Memo::getMemoPaymentWithLastApprover(auth()->user()->id_employee, 'revisi')->count(),
            ],
            'dataPosition' => $positions,
            '__approving'  => 'user.memo.approval.payment.approving',
            '__previewpdf'  => 'user.memo.approval.payment.preview',
            '__detail'    => 'user.memo.approval.payment.detail',
            '__index'    => 'user.memo.approval.payment.index',
        ]);
    }

    public function indexApprovalPo(Request $request)
    {
        $tab = 'submit';
        if ($request->has('tab')) {
            $tab = $request->input('tab');
        }
        $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname');
        }])->with('position')->get();
        //$memo = Memo::getMemoPoWithLastApproverRawQuery(auth()->user()->id_employee);
        // $memo = Memo::getMemoWithLastApprover(auth()->user()->id_employee,  "submit", $request->input('search'))->paginate(10);
        return Inertia::render('User/Approval_PO', [
            'dataMemoTabList' => Memo::getMemoPoWithLastApprover(auth()->user()->id_employee, $tab, $request->input('search'))->paginate(10),
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Approval PO",
                    'active'  => true
                ]
            ),
            'perPage' => 10,
            'tab' => ['submit', 'approve', 'reject', 'revisi'],
            'counttab' => [
                'submit' => Memo::getMemoPoWithLastApprover(auth()->user()->id_employee, 'submit')->count(),
                'approve' => Memo::getMemoPoWithLastApprover(auth()->user()->id_employee, 'approve')->count(),
                'reject' => Memo::getMemoPoWithLastApprover(auth()->user()->id_employee, 'reject')->count(),
                'revisi' => Memo::getMemoPoWithLastApprover(auth()->user()->id_employee, 'revisi')->count(),
            ],
            'dataPosition' => $positions,
            '__approving'  => 'user.memo.approval.po.approving',
            '__previewpdf'  => 'user.memo.approval.po.preview',
            '__detail'    => 'user.memo.approval.po.detail',
            '__index'    => 'user.memo.approval.po.index',
        ]);
    }

    public function detail(Request $request, $id)
    {
        $memo = Memo::getMemoDetailWithCurrentApprover($id, auth()->user()->id_employee);
        $proposeEmployee = Employee::getWithPositionNowById($memo);
        $memocost = (array) json_decode($memo->cost);
        $attachments = D_Memo_Attachment::where('id_memo', $id)->get();
        $attachments = $attachments->map(function ($itemattach) {
            $itemattach->name = Storage::url('public/uploads/memo/attach/' . $itemattach->name);
            return $itemattach;
        });
        $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();

        return Inertia::render('User/Approval/preview', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Approval Memo",
                    'href'  => "user.memo.approval.memo.index"
                ],
                [
                    'title'   => $memo->doc_no,
                    'active'  => true
                ]
            ),
            'dataMemo' => $memo,
            'dataTotalCost' => $dataTotalCost,
            'proposeEmployee' => $proposeEmployee,
            'memocost' => $memocost,
            'attachments' => $attachments,
            '__approving'  => 'user.memo.approval.memo.approving',
        ]);
    }

    public function detailPayment(Request $request, $id)
    {
        $memo = Memo::getPaymentDetailWithCurrentApprover($id, auth()->user()->id_employee);
        $proposeEmployee = Employee::getWithPositionNowById($memo);
        $dataPayments = Memo::where('id', $id)->with('payments')->first();
        $memocost = (array) json_decode($memo->cost);
        $attachments = D_Memo_Attachment::where('id_memo', $id)->get();
        $attachments = $attachments->map(function ($itemattach) {
            $itemattach->name = Storage::url('public/uploads/memo/attach/' . $itemattach->name);
            return $itemattach;
        });
        $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();

        return Inertia::render('User/Approval_Payment/preview', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Approval Payment",
                    'href'  => "user.memo.approval.payment.index"
                ],
                [
                    'title'   => $memo->doc_no,
                    'active'  => true
                ]
            ),
            'dataMemo' => $memo,
            'dataTotalCost' => $dataTotalCost,
            'dataPayments' => $dataPayments->payments,
            '__previewpdfapproval' => 'user.memo.approval.payment.previewpdfapproval',
            'proposeEmployee' => $proposeEmployee,
            'memocost' => $memocost,
            'attachments' => $attachments,
            '__approving'  => 'user.memo.approval.payment.approving',
        ]);
    }

    public function detailPo(Request $request, $id)
    {
        $memo = Memo::getPoDetailWithCurrentApprover($id, auth()->user()->id_employee);
        $proposeEmployee = Employee::getWithPositionNowById($memo);
        $memocost = (array) json_decode($memo->cost);
        $attachments = D_Memo_Attachment::where('id_memo', $id)->get();
        $attachments = $attachments->map(function ($itemattach) {
            $itemattach->name = Storage::url('public/uploads/memo/attach/' . $itemattach->name);
            return $itemattach;
        });
        $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();

        return Inertia::render('User/Approval_PO/preview', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Approval PO",
                    'href'  => "user.memo.approval.po.index"
                ],
                [
                    'title'   => $memo->po_no,
                    'active'  => true
                ]
            ),
            'dataMemo' => $memo,
            'dataTotalCost' => $dataTotalCost,
            'proposeEmployee' => $proposeEmployee,
            'memocost' => $memocost,
            'attachments' => $attachments,
            '__approving'  => 'user.memo.approval.po.approving',
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
            // if type_approver is approver
            if ($approver->type_approver == 'approver') {
                $contentHistory = [
                    'title'     => "Approved lvl {$approver->idx}",
                    'id_memo'   => $memo->id,
                    'type'      => 'success',
                    'content'   => "Approved by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}) $message"
                ];
            } else {
                $contentHistory = [
                    'title'     => "Reviewed by Acknowledge {$approver->idx}",
                    'id_memo'   => $memo->id,
                    'type'      => 'success',
                    'content'   => "Reviewed by Acknowledge {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}) $message"
                ];
            }
            // insert to history when approved
            D_Memo_History::create($contentHistory);

            $nextApprover = D_Memo_Approver::where('id_memo', $approver->id_memo)->where('status', 'submit')->with('employee')->orderBy('idx', 'asc')->first();

            if ($nextApprover) {
                // insert to history next approval
                $title_history = ($nextApprover->type_approver == 'approver') ? "Process Approving " : "Process Reviewing ";
                $title_history .=  $nextApprover->idx;
                $content_history = ($nextApprover->type_approver == 'approver') ? "On process approving by approver " : "On process reviewing by acknowledge ";
                $content_history .= "{$nextApprover->idx} ({$nextApprover->employee->firstname} {$nextApprover->employee->lastname})";

                D_Memo_History::create([
                    'title' => $title_history,
                    'id_memo'   => $memo->id,
                    'type'  => 'info',
                    'content' => $content_history
                ]);
                // send email to next approver
                $mailApprover = $nextApprover->employee->email;
                // kirim email ke approver pertama
                $details = [
                    'subject' => $memo->title,
                    'doc_no'  => $memo->doc_no,
                    'url'     => route('user.memo.approval.memo.detail', $memo->id),
                    'type_approver' => $nextApprover->type_approver
                ];

                if ($approver->type_approver == 'approver') {
                    $detailspropose = [
                        'subject' => "Memo $memo->title - $memo->doc_no approved by {$approver->employee->firstname}",
                        'message' => "Memo $memo->title - $memo->doc_no has approved by {$approver->employee->firstname} {$approver->employee->lastname}"
                    ];
                } else {
                    $detailspropose = [
                        'subject' => "Memo $memo->title - $memo->doc_no reviewed by {$approver->employee->firstname}",
                        'message' => "Memo $memo->title - $memo->doc_no has reviewed by {$approver->employee->firstname} {$approver->employee->lastname}"
                    ];
                }

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

                if ($approver->type_approver == 'approver') {
                    $detailspropose = [
                        'subject' => "Memo $memo->title - $memo->doc_no approved",
                        'message' => "Memo $memo->title - $memo->doc_no has approved"
                    ];
                } else {
                    $detailspropose = [
                        'subject' => "Memo $memo->title - $memo->doc_no reviewed",
                        'message' => "Memo $memo->title - $memo->doc_no has reviewed"
                    ];
                }

                $contentAcknowledge = [
                    'title'   => "Memo $memo->doc_no",
                    'subject' => "Memo $memo->title - $memo->doc_no",
                    'msg' => "Memo $memo->title - $memo->doc_no has approved. For detail information about memo $memo->title, you can see file attach bellow."
                ];

                // kirim email ke setiap CC
                $acknowledges = D_Memo_Acknowledge::with('employee')->where('id_memo', $memo->id)->where('type', 'memo')->get();
                $pdfMemo = generatePDFMemo($memo->id, false);
                $pdfName = Str::kebab($memo->title) . '-' . Carbon::now()->timestamp . '.pdf';
                $mailApprovers = $acknowledges->pluck('employee')->pluck('email')->filter()->toArray();
                $mailApprovers2 = $acknowledges->pluck('employee')->pluck('email2')->filter()->toArray();

                $resultMail = array_merge($mailApprovers, $mailApprovers2);

                Mail::send('emails.notifUserAcknowledgeMail', $contentAcknowledge, function ($message) use ($resultMail, $contentAcknowledge, $pdfMemo, $pdfName) {
                    $message->to($resultMail)
                        ->subject($contentAcknowledge["subject"])
                        ->attachData($pdfMemo->output(), $pdfName);
                });

                // notif ke user propose
                Mail::to($memo->proposeemployee->email)->send(new \App\Mail\NotifUserProposeMail($detailspropose));
            }
        }

        if ($status_approver == 'revisi') {
            // notif ke user propose
            Memo::where('id', $approver->id_memo)->update(['status' => 'revisi']);
            // insert to history when revisi by approver
            D_Memo_History::create([
                'title'     => "Memo Revised",
                'id_memo'   => $memo->id,
                'type'      => 'warning',
                'content'   => "Memo {$memo->doc_no} has revised by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}). $message"
            ]);

            $detailspropose = [
                'subject' => "Memo $memo->title - $memo->doc_no revised",
                'message' => "Memo $memo->title - $memo->doc_no has revised by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}). $message"
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
                'subject' => "Memo $memo->title - $memo->doc_no rejected",
                'message' => "Memo $memo->title - $memo->doc_no has rejected by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}). $message"
            ];
            // notif ke user propose
            Mail::to($memo->proposeemployee->email)->send(new \App\Mail\NotifUserProposeMail($detailspropose));
        }

        return Redirect::route('user.memo.approval.memo.index')->with('success', "Successfull " . $request->input('variant'));
    }

    public function approvingPayment(Request $request, $id)
    {
        $status_approver = $request->input('variant');
        $msg = ($request->input('message')) ? $request->input('message') : null;
        $message = ($msg ? "with message ($msg)" : "");
        $approver = D_Payment_Approver::where('id', $id)->first();
        $memo = Memo::where('id', $approver->id_memo)->with('proposeemployee')->with('ref_table')->first();
        $id_confirmer_payment = $memo->ref_table->id_confirmed_payment_by;
        $confirmer_payment = Employee::where('id', $id_confirmer_payment)->first();
        //ddd($confirmer_payment->email);
        $proposeEmployee = ($memo->id_employee2) ? Employee::getWithPositionNowById($memo, true) : $memo->proposeemployee;
        // dd($proposeEmployee);
        D_Payment_Approver::where('id', $id)->update([
            'status'            => $status_approver,
            'msg'               => $msg
        ]);

        if ($status_approver == 'approve') {
            // if type_approver is approver
            if ($approver->type_approver == 'approver') {
                $contentHistory = [
                    'title'     => "Approved lvl {$approver->idx}",
                    'id_memo'   => $memo->id,
                    'type'      => 'success',
                    'content'   => "Approved by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}) $message"
                ];
            } else {
                $contentHistory = [
                    'title'     => "Reviewed by Acknowledge {$approver->idx}",
                    'id_memo'   => $memo->id,
                    'type'      => 'success',
                    'content'   => "Reviewed by Acknowledge {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}) $message"
                ];
            }
            // insert to history when approved
            D_Memo_History::create($contentHistory);

            $nextApprover = D_Payment_Approver::where('id_memo', $approver->id_memo)->where('status', 'submit')->with('employee')->orderBy('idx', 'asc')->first();

            if ($nextApprover) {
                // insert to history next approval
                $title_history = ($nextApprover->type_approver == 'approver') ? "Process Approving " : "Process Reviewing ";
                $title_history .=  $nextApprover->idx;
                $content_history = ($nextApprover->type_approver == 'approver') ? "On process approving by approver " : "On process reviewing by acknowledge ";
                $content_history .= "{$nextApprover->idx} ({$nextApprover->employee->firstname} {$nextApprover->employee->lastname})";

                D_Memo_History::create([
                    'title' => $title_history,
                    'id_memo'   => $memo->id,
                    'type'  => 'info',
                    'content' => $content_history
                ]);
                // send email to next approver
                $mailApprover = $nextApprover->employee->email;
                // kirim email ke approver pertama
                $details = [
                    'subject' => $memo->title,
                    'doc_no'  => $memo->doc_no,
                    'url'     => route('user.memo.approval.payment.detail', $memo->id),
                    'type_approver' => $nextApprover->type_approver
                ];

                if ($approver->type_approver == 'approver') {
                    $detailspropose = [
                        'subject' => "Memo Payment $memo->title - $memo->doc_no approved by {$approver->employee->firstname}",
                        'message' => "Memo Payment $memo->title - $memo->doc_no has approved by {$approver->employee->firstname} {$approver->employee->lastname}"
                    ];
                } else {
                    $detailspropose = [
                        'subject' => "Memo Payment $memo->title - $memo->doc_no reviewed by {$approver->employee->firstname}",
                        'message' => "Memo Payment $memo->title - $memo->doc_no has reviewed by {$approver->employee->firstname} {$approver->employee->lastname}"
                    ];
                }

                Mail::to($mailApprover)->send(new \App\Mail\ApprovalMemoMail($details));
                Mail::to($proposeEmployee->email)->send(new \App\Mail\NotifUserProposeMail($detailspropose));
            } else {
                Memo::where('id', $approver->id_memo)->update(['status_payment' => 'approve']);
                // insert to history when all approved by approver
                D_Memo_History::create([
                    'title'     => "Memo Payment Approved",
                    'id_memo'   => $memo->id,
                    'type'      => 'success',
                    'content'   => "Memo Payment {$memo->doc_no} has approved."
                ]);

                if ($approver->type_approver == 'approver') {
                    $detailspropose = [
                        'subject' => "Memo Payment $memo->title - $memo->doc_no approved",
                        'message' => "Memo Payment $memo->title - $memo->doc_no has approved"
                    ];
                } else {
                    $detailspropose = [
                        'subject' => "Memo Payment $memo->title - $memo->doc_no reviewed",
                        'message' => "Memo Payment $memo->title - $memo->doc_no has reviewed"
                    ];
                }

                $contentAcknowledge = [
                    'title'   => "Memo Payment $memo->doc_no",
                    'subject' => "Memo Payment $memo->title - $memo->doc_no",
                    'msg' => "Memo Payment $memo->title - $memo->doc_no has approved. For detail information about memo $memo->title, you can see file attach bellow."
                ];

                // kirim email ke setiap CC
                $acknowledges = D_Memo_Acknowledge::with('employee')->where('id_memo', $memo->id)->where('type', 'payment')->get();
                $pdfMemoPayment = generatePDFPayment($memo->id, false);
                $pdfName = Str::kebab($memo->title) . '-' . Carbon::now()->timestamp . '.pdf';
                $mailApprovers = $acknowledges->pluck('employee')->pluck('email')->filter()->toArray();
                $mailApprovers2 = $acknowledges->pluck('employee')->pluck('email2')->filter()->toArray();

                $resultMail = array_merge($mailApprovers, $mailApprovers2);

                Mail::send('emails.notifUserAcknowledgeMail', $contentAcknowledge, function ($message) use ($resultMail, $contentAcknowledge, $pdfMemoPayment, $pdfName) {
                    $message->to($resultMail)
                        ->subject($contentAcknowledge["subject"])
                        ->attachData($pdfMemoPayment->output(), $pdfName);
                });

                $details2 = [
                    'subject' => "Confirm Payment Memo $memo->title",
                    'doc_no' => $memo->doc_no,
                    'url' => route('user.memo.confirmpayment.webpreview', $memo->id)
                ];
                // notif ke user propose
                Mail::to($proposeEmployee->email)->send(new \App\Mail\NotifUserProposeMail($detailspropose));
                //notif ke confirmer payment
                Mail::to($confirmer_payment->email)->send(new \App\Mail\ConfirmPaymentMail($details2));
            }
        }

        if ($status_approver == 'revisi') {
            // notif ke user propose
            Memo::where('id', $approver->id_memo)->update(['status_payment' => 'revisi']);
            // insert to history when revisi by approver
            D_Memo_History::create([
                'title'     => "Memo Payment Revised",
                'id_memo'   => $memo->id,
                'type'      => 'warning',
                'content'   => "Memo Payment {$memo->doc_no} has revised by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}). $message"
            ]);

            $detailspropose = [
                'subject' => "Memo Payment $memo->title - $memo->doc_no revised",
                'message' => "Memo Payment $memo->title - $memo->doc_no has revised by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}). $message"
            ];
            // notif ke user propose
            Mail::to($proposeEmployee->email)->send(new \App\Mail\NotifUserProposeMail($detailspropose));
        }

        if ($status_approver == 'reject') {
            // notif ke user propose
            Memo::where('id', $approver->id_memo)->update(['status_payment' => 'reject']);
            // insert to history when revisi by approver
            D_Memo_History::create([
                'title'     => "Memo Payment Rejected",
                'id_memo'   => $memo->id,
                'type'      => 'danger',
                'content'   => "Memo Payment {$memo->doc_no} has rejected by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}). $message"
            ]);

            $detailspropose = [
                'subject' => "Memo Payment $memo->title - $memo->doc_no rejected",
                'message' => "Memo Payment $memo->title - $memo->doc_no has rejected by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}). $message"
            ];
            // notif ke user propose
            Mail::to($proposeEmployee->email)->send(new \App\Mail\NotifUserProposeMail($detailspropose));
        }

        return Redirect::route('user.memo.approval.payment.index')->with('success', "Successfull " . $request->input('variant'));
    }

    public function approvingPo(Request $request, $id)
    {
        $status_approver = $request->input('variant');
        $msg = ($request->input('message')) ? $request->input('message') : null;
        $message = ($msg ? "with message ($msg)" : "");
        $approver = D_Po_Approver::where('id', $id)->first();

        $memo = Memo::where('id', $approver->id_memo)->with('proposeemployee')->first();
        D_Po_Approver::where('id', $id)->update([
            'status'            => $status_approver,
            'msg'               => $msg
        ]);

        if ($status_approver == 'approve') {
            // if type_approver is approver
            if ($approver->type_approver == 'approver') {
                $contentHistory = [
                    'title'     => "Approved lvl {$approver->idx}",
                    'id_memo'   => $memo->id,
                    'type'      => 'success',
                    'content'   => "Approved by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}) $message"
                ];
            } else {
                $contentHistory = [
                    'title'     => "Reviewed by Acknowledge {$approver->idx}",
                    'id_memo'   => $memo->id,
                    'type'      => 'success',
                    'content'   => "Reviewed by Acknowledge {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}) $message"
                ];
            }
            // insert to history when approved
            D_Memo_History::create($contentHistory);

            $nextApprover = D_Po_Approver::where('id_memo', $approver->id_memo)->where('status', 'submit')->with('employee')->orderBy('idx', 'asc')->first();

            if ($nextApprover) {
                // insert to history next approval
                $title_history = ($nextApprover->type_approver == 'approver') ? "Process Approving " : "Process Reviewing ";
                $title_history .=  $nextApprover->idx;
                $content_history = ($nextApprover->type_approver == 'approver') ? "On process approving by approver " : "On process reviewing by acknowledge ";
                $content_history .= "{$nextApprover->idx} ({$nextApprover->employee->firstname} {$nextApprover->employee->lastname})";

                D_Memo_History::create([
                    'title' => $title_history,
                    'id_memo'   => $memo->id,
                    'type'  => 'info',
                    'content' => $content_history
                ]);
                // send email to next approver
                $mailApprover = $nextApprover->employee->email;
                // kirim email ke approver pertama
                $details = [
                    'subject' => $memo->title,
                    'doc_no'  => $memo->doc_no,
                    'url'     => route('user.memo.approval.po.detail', $memo->id)
                ];

                if ($approver->type_approver == 'approver') {
                    $detailspropose = [
                        'subject' => "PO $memo->title - $memo->doc_no approved by {$approver->employee->firstname}",
                        'message' => "PO $memo->title - $memo->doc_no has approved by {$approver->employee->firstname} {$approver->employee->lastname}"
                    ];
                } else {
                    $detailspropose = [
                        'subject' => "PO $memo->title - $memo->doc_no reviewed by {$approver->employee->firstname}",
                        'message' => "PO $memo->title - $memo->doc_no has reviewed by {$approver->employee->firstname} {$approver->employee->lastname}"
                    ];
                }

                Mail::to($mailApprover)->send(new \App\Mail\ApprovalPOMail($details));
                Mail::to($memo->proposeemployee->email)->send(new \App\Mail\NotifUserProposePOMail($detailspropose));
            } else {
                Memo::where('id', $approver->id_memo)->update(['status_po' => 'approve']);
                // insert to history when all approved by approver
                D_Memo_History::create([
                    'title'     => "PO Approved",
                    'id_memo'   => $memo->id,
                    'type'      => 'success',
                    'content'   => "PO {$memo->doc_no} has approved."
                ]);

                if ($approver->type_approver == 'approver') {
                    $detailspropose = [
                        'subject' => "PO $memo->title - $memo->doc_no approved",
                        'message' => "PO $memo->title - $memo->doc_no has approved"
                    ];
                } else {
                    $detailspropose = [
                        'subject' => "PO $memo->title - $memo->doc_no reviewed",
                        'message' => "PO $memo->title - $memo->doc_no has reviewed"
                    ];
                }
                // notif ke user propose
                Mail::to($memo->proposeemployee->email)->send(new \App\Mail\NotifUserProposePOMail($detailspropose));
            }
        }

        if ($status_approver == 'reject') {
            // notif ke user propose
            Memo::where('id', $approver->id_memo)->update(['status_po' => 'reject']);
            // insert to history when revisi by approver
            D_Memo_History::create([
                'title'     => "PO Rejected",
                'id_memo'   => $memo->id,
                'type'      => 'danger',
                'content'   => "PO {$memo->doc_no} has rejected by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}). $message"
            ]);

            $detailspropose = [
                'subject' => "PO $memo->title - $memo->doc_no rejected",
                'message' => "PO $memo->title - $memo->doc_no has rejected by approver lvl {$approver->idx} ({$approver->employee->firstname} {$approver->employee->lastname}). $message"
            ];
            // notif ke user propose
            Mail::to($memo->proposeemployee->email)->send(new \App\Mail\NotifUserProposePOMail($detailspropose));
        }

        return Redirect::route('user.memo.approval.po.index')->with('success', "Successfull " . $request->input('variant'));
    }
}
