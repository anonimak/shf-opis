<?php

namespace App\Http\Controllers\User;

use App\Models\D_Memo_Payments;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\D_Memo_Invoices;
use App\Models\D_Memo_Acknowledge;
use App\Models\D_Memo_Approver;
use App\Models\D_Memo_Attachment;
use App\Models\D_Memo_History;
use App\Models\D_Payment_Approver;
use App\Models\D_Po_Approver;
use App\Models\Employee;
use App\Models\Employee_History;
use App\Models\M_Data_Cost_Total;
use App\Models\Memo;
use App\Models\Ref_Doc_No;
use App\Models\Ref_Template_Cost;
use App\Models\Ref_Type_Memo;
use App\Notifications\ApprovalNotification;
use App\User;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MemoController extends Controller
{
    public function index(Request $request)
    {
        $tab = 'submit';
        if ($request->has('tab')) {
            $tab = $request->input('tab');
        }

        $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname');
        }])->with(['position' => function ($p) {
            return $p->where('position_name', '<>', 'TERMINATE');
        }])->get();
        $positions = $positions->unique('id_employee')->whereNotNull('position')->values()->all();
        //ddd($positions);

        return Inertia::render('User/Memo', [
            'perPage' => 10,
            'dataMemo' => Memo::getMemo(auth()->user()->id_employee,  $tab, $request->input('search'))->with('latestHistory')->with('ref_table')->paginate(10),
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Memo",
                    'active'  => true
                ],
                [
                    'title'   => "Status Memo",
                    'active'  => true
                ]
            ),
            'tab' => ['submit', 'approve', 'reject', 'revisi'],
            'counttab' => [
                'submit' => Memo::getMemo(auth()->user()->id_employee, 'submit')->count(),
                'approve' => Memo::getMemo(auth()->user()->id_employee, 'approve')->count(),
                'reject' => Memo::getMemo(auth()->user()->id_employee, 'reject')->count(),
                'revisi' => Memo::getMemo(auth()->user()->id_employee, 'revisi')->count(),
            ],
            'dataPosition' => $positions,
            '__index'   => 'user.memo.statusmemo.index',
            '__webpreview'   => 'user.memo.statusmemo.webpreview',
            '__webpreviewpo'   => 'user.memo.statuspo.webpreview',
            '__webpreviewpayment'   => 'user.memo.statuspayment.webpreview',
            '__previewpdf'          => 'user.memo.statusmemo.preview',
            '__senddraft'   => 'user.memo.statusmemo.senddraft',
            '__formpayment' => 'user.memo.statusmemo.formpayment',
            '__proposepayment' => 'user.memo.statusmemo.proposepayment',
            '__proposepo' => 'user.memo.statusmemo.proposepo'
        ]);
    }

    public function indexTakeoverBranch(Request $request)
    {
        $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname');
        }])->with(['position' => function ($p) {
            return $p->where('position_name', '<>', 'TERMINATE');
        }])->get();
        $positions = $positions->unique('id_employee')->whereNotNull('position')->values()->all();
        //ddd($positions);

        return Inertia::render('User/Memo/index_Takeover_Branch', [
            'perPage' => 10,
            'dataMemo' => Memo::getMemoTakeoverBranch(auth()->user()->id_employee, $request->input('search'))->with('latestHistory')->with('ref_table')->paginate(10),
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Memo",
                    'active'  => true
                ],
                [
                    'title'   => "Status Memo Branch",
                    'active'  => true
                ]
            ),
            'dataPosition' => $positions,
            '__index'   => 'user.memo.statustakeovermemobranch.index',
            '__formpayment' => 'user.memo.statustakeovermemobranch.formpayment',
            '__proposepayment' => 'user.memo.statustakeovermemobranch.proposepayment',
            '__webpreview'   => 'user.memo.statustakeovermemobranch.webpreview',
            '__previewpdf'   => 'user.memo.statustakeovermemobranch.preview',
            '__webpreviewpayment'   => 'user.memo.statustakeoverpaymentbranch.webpreview',
        ]);
    }

    public function indexPayment(Request $request)
    {
        $tab = 'submit';
        if ($request->has('tab')) {
            $tab = $request->input('tab');
        }
        return Inertia::render('User/Status_Payment', [
            'perPage' => 10,
            'dataMemo' => Memo::getPayment(auth()->user()->id_employee,  $tab, $request->input('search'))->with('latestHistory')->with('ref_table')->paginate(10),
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Memo",
                    'active'  => true
                ],
                [
                    'title'   => "Status Payment",
                    'active'  => true
                ]
            ),
            'tab' => ['submit', 'approve', 'reject', 'revisi'],
            'counttab' => [
                'submit' => Memo::getPayment(auth()->user()->id_employee, 'submit')->count(),
                'approve' => Memo::getPayment(auth()->user()->id_employee, 'approve')->count(),
                'reject' => Memo::getPayment(auth()->user()->id_employee, 'reject')->count(),
                'revisi' => Memo::getPayment(auth()->user()->id_employee, 'revisi')->count(),
            ],
            '__index'   => 'user.memo.statuspayment.index',
            '__editpayment'   => 'user.memo.statuspayment.formpayment',
            '__senddraftpayment' => 'user.memo.statuspayment.senddraft',
            '__webpreview'   => 'user.memo.statuspayment.webpreview',
            '__previewpdf'   => 'user.memo.statuspayment.preview',
        ]);
    }

    public function indexPaymentTakeoverBranch(Request $request)
    {
        $tab = 'submit';
        if ($request->has('tab')) {
            $tab = $request->input('tab');
        }
        return Inertia::render('User/Status_Payment_Takeover_Branch', [
            'perPage' => 10,
            'dataMemo' => Memo::getPaymentTakeoverBranch(auth()->user()->id_employee,  $tab, $request->input('search'))->with('latestHistory')->with('ref_table')->paginate(10),
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Memo",
                    'active'  => true
                ],
                [
                    'title'   => "Status Payment Branch",
                    'active'  => true
                ]
            ),
            'tab' => ['submit', 'approve', 'reject', 'revisi'],
            'counttab' => [
                'submit' => Memo::getPaymentTakeoverBranch(auth()->user()->id_employee, 'submit')->count(),
                'approve' => Memo::getPaymentTakeoverBranch(auth()->user()->id_employee, 'approve')->count(),
                'reject' => Memo::getPaymentTakeoverBranch(auth()->user()->id_employee, 'reject')->count(),
                'revisi' => Memo::getPaymentTakeoverBranch(auth()->user()->id_employee, 'revisi')->count(),
            ],
            '__index'   => 'user.memo.statustakeoverpaymentbranch.index',
            '__webpreview'   => 'user.memo.statustakeoverpaymentbranch.webpreview',
            '__previewpdf'   => 'user.memo.statustakeoverpaymentbranch.preview',
            '__previewmemopdf'   => 'user.memo.statustakeoverpaymentbranch.previewmemo',
            '__editpayment'   => 'user.memo.statustakeoverpaymentbranch.formpayment',
        ]);
    }

    public function indexPo(Request $request)
    {
        $tab = 'submit';
        if ($request->has('tab')) {
            $tab = $request->input('tab');
        }
        return Inertia::render('User/Status_Po', [
            'perPage' => 10,
            'dataMemo' => Memo::getPo(auth()->user()->id_employee,  $tab, $request->input('search'))->with('latestHistory')->with('ref_table')->paginate(10),
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Memo",
                    'active'  => true
                ],
                [
                    'title'   => "Status PO",
                    'active'  => true
                ]
            ),
            'tab' => ['submit', 'approve', 'reject', 'revisi'],
            'counttab' => [
                'submit' => Memo::getPo(auth()->user()->id_employee, 'submit')->count(),
                'approve' => Memo::getPo(auth()->user()->id_employee, 'approve')->count(),
                'reject' => Memo::getPo(auth()->user()->id_employee, 'reject')->count(),
                'revisi' => Memo::getPo(auth()->user()->id_employee, 'revisi')->count(),
            ],
            '__index'   => 'user.memo.statuspo.index',
            '__webpreview'   => 'user.memo.statuspo.webpreview',
            '__previewpdf'   => 'user.memo.statuspo.preview',
        ]);
    }

    public function draft(Request $request)
    {

        return Inertia::render('User/Memo/Draft', [
            'perPage' => 10,
            'dataMemo' => Memo::getMemoDraft(auth()->user()->id_employee, "edit", $request->input('search'))->with('latestHistory')->with('ref_table')->with('check_terminate_approver')->paginate(10),
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Memo",
                    'active'  => true
                ],
                [
                    'title'   => "Draft",
                    'active'  => true
                ]
            ),
            '__create'  => 'user.memo.create',
            '__edit'    => 'user.memo.draft.edit',
            '__show'    => 'user.memo.show',
            '__destroy' => 'user.memo.draft.destroy',
            '__propose' => 'user.memo.draft.propose'
        ]);
    }

    public function create()
    {
        $employeeInfo = User::getUsersEmployeeInfo();
        $dataTypeMemo = Ref_Type_Memo::where('status', true)
            ->where('id_department', $employeeInfo->employee->position_now->position->id_department)
            ->where('id_branch', $employeeInfo->employee->position_now->branch->id)
            ->orWhere(function ($query) use ($employeeInfo) {
                $query->where('status', true);
                $query->whereNull('id_department');
                $query->where('id_branch', $employeeInfo->employee->position_now->branch->id);
            })->orWhere(function ($query) use ($employeeInfo) {
                $query->where('id_department', $employeeInfo->employee->position_now->position->id_department);
                $query->whereNull('id_branch');
                $query->where('status', true);
            })->orWhere(function ($query) {
                $query->whereNull('id_department');
                $query->whereNull('id_branch');
                $query->where('status', true);
            })->orderBy('id_department', 'asc')->get();
        // $isHeadOffice =  $employeeInfo->employee->position_now->branch->is_head;
        // if (!$isHeadOffice) {
        //     $dataTypeMemo = Ref_Type_Memo::where('status', true)->whereNull('id_department')->orWhere(function ($query) use ($employeeInfo) {
        //         $query->where('id_department', $employeeInfo->employee->position_now->position->id_department);
        //         $query->where('id_branch', $employeeInfo->employee->position_now->branch->id);
        //         $query->where('status', true);
        //     })
        //         ->orderBy('id_department', 'asc')->get();
        // } else {
        //     $dataTypeMemo = Ref_Type_Memo::where('status', true)->whereNull('id_department')
        //         ->orWhere(function ($query) use ($employeeInfo) {
        //             $query->where('id_department', $employeeInfo->employee->position_now->position->id_department);
        //             $query->where('status', true);
        //         })
        //         ->orderBy('id_department', 'asc')->get();
        // }
        return Inertia::render('User/Memo/create', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Memo",
                    'active'  => true
                ],
                [
                    'title'   => "New Memo",
                    'active'  => true
                ]
            ),
            '_token' => csrf_token(),
            '__store'  => 'user.memo.store',
            'dataTypeMemo'  => $dataTypeMemo,
        ]);
    }

    public function draftEdit($id)
    {
        $memoType = Memo::select('*')->where('id', '=', $id)->with('ref_table')->first();
        if ($memoType->ref_table->type == 'payment') {
            $formType = 'payment';
            $attachments = D_Memo_Attachment::where('id_memo', $id)->where('type', 'payment')->get();
        } else {
            $formType = 'memo';
            $attachments = D_Memo_Attachment::where('id_memo', $id)->where('type', 'memo')->get();
        }

        $memo = Memo::getMemoDetailDraftEdit($id, $formType);
        $employeeInfo = User::getUsersEmployeeInfo();
        $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname');
        }])->with(['position' => function ($p) {
            return $p->where('position_name', '<>', 'TERMINATE');
        }])->get();
        $positions = $positions->unique('id_employee')->whereNotNull('position')->values()->all();

        // $attachments = D_Memo_Attachment::where('id_memo', $id)->where('type', 'memo')->get();

        $attachments = $attachments->map(function ($itemattach) {
            $itemattach->name = Storage::url('public/uploads/memo/attach/' . $itemattach->name);
            return $itemattach;
        });

        $templateCost = Ref_Template_Cost::where('id_ref_type_memo', $memo->id_type)->get();

        $templateCost = $templateCost->makeHidden(['id_ref_type_memo', 'created_at', 'updated_at']);

        $headerCost = $templateCost->map(function ($item, $key) {
            return $item['col_name'];
        });

        $columnCost = $templateCost->transform(function ($value) {
            return [
                'data' => $value->col_name,
                'width' => $value->width
            ];
        });

        $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();

        return Inertia::render('User/Memo/Draft/form', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Memo",
                    'active'  => true
                ],
                [
                    'title'   => "Draft",
                    'href'    => "user.memo.draft.index"
                ],
                [
                    'title'   => $memo->title,
                    'active'  => true
                ]
            ),
            '_token' => csrf_token(),
            'formType' => $formType,
            '__attachment'  => 'user.memo.draft.attachment',
            '__removeAttachment'  => 'user.memo.draft.attachmentremove',
            '__update' => 'user.memo.draft.update',
            '__updateApprover' => 'user.memo.draft.updateapprover',
            '__autoSaveItem' => 'user.memo.draft.itemAutoSave',
            '__autoSaveItemCost' => 'user.memo.draft.itemAutoSaveCost',
            //'__addDataTotal' => 'user.api.memo.adddatatotalcost',
            '__updateAcknowledge' => 'user.memo.draft.updateacknowledge',
            '__deleteAcknowledge' => 'user.memo.draft.deleteacknowledge',
            '__preview' => 'user.memo.draft.preview',
            '__previewpayment' => 'user.memo.draft.previewpayment',
            'dataPosition' => $positions,
            'dataMemo' => $memo,
            'dataMemoType' => $memoType,
            'dataAttachments' => $attachments,
            'dataTotalCost' => $dataTotalCost,
            'headerCost' => $headerCost,
            'columnCost' => $columnCost,
            // 'dataTypeMemo'  => Ref_Type_Memo::where('id_department', $employeeInfo->employee->position_now->position->id_department)->orderBy('id', 'desc')->get(),
        ]);
    }

    public function itemAutoSave(Request $request, $id)
    {
        Memo::where('id', $id)->update([
            'background'        => $request->input('background'),
            'orientation_paper' => $request->input('orientation_paper'),
            'information'       => $request->input('information'),
            'conclusion'        => $request->input('conclusion'),
            'is_cost_invoice'        => $request->input('is_cost_invoice'),
            'cost'              => ($request->has('cost')) ? $request->input('cost') : null,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Successfull auto save.',
            'background' => $request->input('background'),
            'orientation_paper' => $request->input('orientation_paper'),
            'information'       => $request->input('information'),
            'conclusion'        => $request->input('conclusion'),
            'is_cost_invoice'        => $request->input('is_cost_invoice'),
            'cost'              => ($request->has('cost')) ? $request->input('cost') : null,
        ]);
    }

    public function itemAutoSaveCost(Request $request, $id)
    {
        M_Data_Cost_Total::where('id_memo', $id)->update([
            // 'id_memo' => $id,
            'sub_total' => $request->input('sub_total'),
            'pph' => $request->input('pph'),
            'ppn' => $request->input('ppn'),
            'grand_total' => $request->input('grand_total')
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Successfull auto save.',
            'sub_total' => $request->input('sub_total'),
            'pph' => $request->input('pph'),
            'ppn'       => $request->input('ppn'),
            'grand_total'        => $request->input('grand_total'),
        ]);
    }

    public function draftUpdate(Request $request, $id)
    {

        Memo::where('id', $id)->update([
            'doc_no'   => $request->input('doc_no'),
            'background'        => $request->input('background'),
            'orientation_paper' => $request->input('orientation_paper'),
            'is_cost_invoice'   => $request->input('is_cost_invoice'),
            'information'       => $request->input('information'),
            'conclusion'        => $request->input('conclusion'),
            'payment'           => $request->input('payment'),
            'cost'              => ($request->has('cost')) ? $request->input('cost') : null,
        ]);
        // form payment
        M_Data_Cost_Total::where('id_memo', $id)->update([
            // 'id_memo' => $id,
            'sub_total' => $request->input('sub_total'),
            'pph' => $request->input('pph'),
            'ppn' => $request->input('ppn'),
            'grand_total' => $request->input('grand_total')
        ]);
        return Redirect::route('user.memo.draft.index')->with('success', "Successfull updated.");
    }

    public function store(Request $request)
    {
        $employeeInfo = User::getUsersEmployeeInfo();
        $request->validate([
            'title'        => 'required',
            'typememo'     => 'required',
        ]);

        $employeeBranch = $employeeInfo->employee->position_now->branch->id;
        $typeMemo = Ref_Type_Memo::find($request->input('typememo'));

        if ($typeMemo->type == 'payment') {
            $type = true;
        } else {
            $type = false;
        }

        $memo = Memo::create([
            'title'                 => $request->input('title'),
            'id_employee'           => $employeeInfo->employee->id,
            'id_type'               => $request->input('typememo'),
            'id_employee2'          => $typeMemo->id_overtake_memo,
            'confirmed_payment_by' => $typeMemo->id_confirmed_payment_by,
            'payment'               => $type
        ]);

        M_Data_Cost_Total::create([
            'id_memo' => $memo->id,
            'sub_total' => 0,
            'pph' => 0,
            'ppn' => 0,
            'grand_total' => 0
        ]);

        $branch = Branch::select('id')->where('is_head', true)->orWhere('id', $employeeBranch)->get();
        $detail_approver = Ref_Type_Memo::get_ref_module_approver_detail_by_id($memo, $branch);
        $dataDetailInsert = $detail_approver->ref_module_approver_detail->toArray();

        if ($typeMemo->type != 'payment') {
            D_Memo_Approver::insert($dataDetailInsert);
        } else {
            D_Payment_Approver::insert($dataDetailInsert);
        }

        // // check with_po
        // if ($typeMemo->with_po) {
        //     D_Po_Approver::insert($dataDetailInsert);
        // }
        // // check with_payment
        // if ($typeMemo->with_payment) {
        //     D_Payment_Approver::insert($dataDetailInsert);
        //}

        return Redirect::route('user.memo.draft.edit', [$memo])->with('success', "Create new memo");
    }

    public function destroy($id)
    {
        $memo = Memo::where('id', $id)->first();
        $memo->delete();
        return Redirect::route('user.memo.draft.index')->with('success', "Memo with $memo->doc_no deleted.");
    }

    public function propose($id)
    {
        $memo = Memo::where('id', $id)->with('ref_table')->first();
        $employeeInfo = User::getUsersEmployeeInfo();
        $isRevised = ($memo->propose_payment_at || $memo->propose_at) ? true : false;
        // form payment
        if ($memo->ref_table->type == 'payment' || $memo->payment == true) {
            // cek apakah ada approver
            if (D_Payment_Approver::where('id_memo', $id)->count() <= 0) {
                return Redirect::route('user.memo.draft.index')->with('error', "Memo $memo->doc_no does not have approver.");
            }

            if (D_Memo_Payments::where('id_memo', $id)->count() <= 0) {
                return Redirect::route('user.memo.draft.index')->with('error', "Memo $memo->doc_no does not have data payment, please fill in the data payment");
            }

            $check_history = D_Memo_History::where('id_memo', $id)->get();
            if ($check_history->count() > 0) {
                $doc_no = $memo->doc_no;
            } else {
                $doc_no = $this->generateDocNo();
            }

            // update status payment menjadi submit
            Memo::where('id', $id)->update([
                'status_payment'   => 'submit',
                'doc_no'   => $doc_no,
                'po_no'   => $doc_no . '/' . $employeeInfo->employee
                    ->position_now
                    ->position->department
                    ->alias . '/PO',
                'propose_payment_at' => Carbon::now()
            ]);

            if ($isRevised) {
                D_Payment_Approver::where('id_memo', $id)->where('status', 'revisi')->update([
                    'status'   => 'submit'
                ]);
            } else {
                D_Payment_Approver::where('id_memo', $id)->update([
                    'status'   => 'submit'
                ]);
            }

            // insert to history where first time submit
            D_Memo_History::create([
                'title' => 'Memo Payment Proposed',
                'id_memo'   => $id,
                'type'  => 'info',
                'content' => "Memo Payment successful submitted with document no $doc_no"
            ]);

            $firstApprover = D_Payment_Approver::where('id_memo', $id)->where('status', 'submit')->with('employee')->orderBy('idx', 'asc')->first();
            if ($firstApprover->type_approver == 'acknowledge') {
                $type_approver = 'reviewer';
            } else {
                $type_approver = $firstApprover->type_approver;
            }
            // insert to history frist approval
            D_Memo_History::create([
                'title'     => "Process Approving {$firstApprover->idx}",
                'id_memo'   => $id,
                'type'      => 'info',
                'content'   => "On process approving by {$type_approver} {$firstApprover->idx} ({$firstApprover->employee->firstname} {$firstApprover->employee->lastname})"
            ]);
            $mailApprover = $firstApprover->employee->email;
            // kirim email ke approver pertama
            $details = [
                'subject' => $memo->title,
                'doc_no'  =>  $doc_no,
                'type_approver' => $firstApprover->type_approver,
                'url'     => route('user.memo.approval.payment.detail', $id)
            ];

            Mail::to($mailApprover)->send(new \App\Mail\ApprovalPaymentMail($details));
            // kirim email ke tiap acknowlegde

            if ($firstApprover->type_approver == 'approver') {
                $detailapprovers = [
                    'doc_no'   => $memo->doc_no,
                    'caption'  => $memo->title,
                    'type'     => "warning",
                    'subject' => "New submission memo $memo->title - $memo->doc_no. Click here for approve"
                ];
            } else {
                $detailapprovers = [
                    'doc_no'   => $memo->doc_no,
                    'caption'  => $memo->title,
                    'type'     => "warning",
                    'subject' => "New submission memo $memo->title - $memo->doc_no. Click here for review"
                ];
            }
            // notif app
            $firstApprover->employee->user->notify(new ApprovalNotification($detailapprovers, route('user.memo.approval.payment.detail', $memo->id)));

            if ($memo->id_employee2 == $employeeInfo->id_employee) {
                return Redirect::route('user.memo.statustakeoverpaymentbranch.index')->with('success', "Successfull submit memo payment branch.");
            } else {
                return Redirect::route('user.memo.statuspayment.index')->with('success', "Successfull submit memo payment.");
            }
        } else {
            // form approval
            // cek apakah ada approver
            if (D_Memo_Approver::where('id_memo', $id)->count() <= 0) {
                return Redirect::route('user.memo.draft.index')->with('error', "Memo $memo->doc_no does not have approver.");
            }

            $check_history = D_Memo_History::where('id_memo', $id)->get();
            if ($check_history->count() > 0) {
                $doc_no = $memo->doc_no;
            } else {
                $doc_no = $this->generateDocNo();
            }

            // update status menjadi submit
            Memo::where('id', $id)->update([
                'status'   => 'submit',
                'doc_no'   => $doc_no,
                'po_no'   => $doc_no . '/' . $employeeInfo->employee
                    ->position_now
                    ->position->department
                    ->alias . '/PO',
                'propose_at' => Carbon::now()
            ]);

            if ($isRevised) {
                D_Memo_Approver::where('id_memo', $id)->where('status', 'revisi')->update([
                    'status'   => 'submit'
                ]);
            } else {
                D_Memo_Approver::where('id_memo', $id)->update([
                    'status'   => 'submit'
                ]);
            }

            // insert to history where first time submit
            D_Memo_History::create([
                'title' => 'Memo Proposed',
                'id_memo'   => $id,
                'type'  => 'info',
                'content' => "Memo successful submitted with document no $doc_no"
            ]);

            $firstApprover = D_Memo_Approver::where('id_memo', $id)->where('status', 'submit')->with('employee')->orderBy('idx', 'asc')->first();
            if ($firstApprover->type_approver == 'acknowledge') {
                $type_approver = 'reviewer';
            } else {
                $type_approver = $firstApprover->type_approver;
            }
            // insert to history frist approval
            D_Memo_History::create([
                'title'     => "Process Approving {$firstApprover->idx}",
                'id_memo'   => $id,
                'type'      => 'info',
                'content'   => "On process approving by {$type_approver} {$firstApprover->idx} ({$firstApprover->employee->firstname} {$firstApprover->employee->lastname})"
            ]);
            $mailApprover = $firstApprover->employee->email;
            // kirim email ke approver pertama
            $details = [
                'subject' => $memo->title,
                'doc_no'  =>  $doc_no,
                'type_approver' => $firstApprover->type_approver,
                'url'     => route('user.memo.approval.memo.detail', $id)
            ];

            Mail::to($mailApprover)->send(new \App\Mail\ApprovalMemoMail($details));
            // kirim email ke tiap acknowlegde


            if ($firstApprover->type_approver == 'approver') {
                $detailapprovers = [
                    'doc_no'   => $memo->doc_no,
                    'caption'  => $memo->title,
                    'type'     => "warning",
                    'subject' => "New submission memo $memo->title - $memo->doc_no. Click here for approve"
                ];
            } else {
                $detailapprovers = [
                    'doc_no'   => $memo->doc_no,
                    'caption'  => $memo->title,
                    'type'     => "warning",
                    'subject' => "New submission memo $memo->title - $memo->doc_no. Click here for review"
                ];
            }
            // notif app
            $firstApprover->employee->user->notify(new ApprovalNotification($detailapprovers, route('user.memo.approval.memo.detail', $memo->id)));

            return Redirect::route('user.memo.index')->with('success', "Successfull submit memo.");
        }
    }

    public function formPayment($id)
    {
        $formType = 'payment';
        $memo = Memo::getMemoDetailDraftEdit($id, $formType);
        // $employeeInfo = User::getUsersEmployeeInfo();
        $memoType = Memo::select('*')->where('id', '=', $id)->with('ref_table')->first();
        $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname');
        }])->with(['position' => function ($p) {
            return $p->where('position_name', '<>', 'TERMINATE');
        }])->get();
        $positions = $positions->unique('id_employee')->whereNotNull('position')->values()->all();

        $attachments = D_Memo_Attachment::where('id_memo', $id)->where('type', 'payment')->get();

        $attachments = $attachments->map(function ($itemattach) {
            $itemattach->name = Storage::url('public/uploads/memo/attach/' . $itemattach->name);
            return $itemattach;
        });

        $templateCost = Ref_Template_Cost::where('id_ref_type_memo', $memo->id_type)->get();

        $templateCost = $templateCost->makeHidden(['id_ref_type_memo', 'created_at', 'updated_at']);

        $headerCost = $templateCost->map(function ($item, $key) {
            return $item['col_name'];
        });

        $columnCost = $templateCost->transform(function ($value) {
            return [
                'data' => $value->col_name,
                'width' => $value->width
            ];
        });
        $memocost = (array) json_decode($memo->cost);

        $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();

        return Inertia::render('User/Memo/form_payment', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Memo Payment",
                    'active'  => true
                ],
                [
                    'title'   => "Form Payment",
                    'active'  => true
                    // 'href'    => "user.memo.draft.index"
                ],
                [
                    'title'   => $memo->title,
                    'active'  => true
                ]
            ),
            '_token' => csrf_token(),
            'formType' => $formType,
            'memocost' => $memocost,
            '__attachment'  => 'user.memo.draft.attachment',
            '__removeAttachment'  => 'user.memo.draft.attachmentremove',
            //'__update' => 'user.memo.draft.update',
            '__updateAcknowledge' => 'user.memo.draft.updateacknowledge',
            '__deleteAcknowledge' => 'user.memo.draft.deleteacknowledge',
            '__autoSaveItemCost' => 'user.memo.draft.itemAutoSaveCost',
            //'__addDataTotal' => 'user.api.memo.adddatatotalcost',
            // '__updateAcknowledge' => 'user.memo.draft.updateacknowledge',
            //'__preview' => 'user.memo.draft.preview',
            'dataPosition' => $positions,
            'dataMemo' => $memo,
            'dataMemoType' => $memoType,
            'dataAttachments' => $attachments,
            'dataTotalCost' => $dataTotalCost,
            'headerCost' => $headerCost,
            'columnCost' => $columnCost,
            '__proposepayment' => 'user.memo.statusmemo.proposepayment',
            // 'dataTypeMemo'  => Ref_Type_Memo::where('id_department', $employeeInfo->employee->position_now->position->id_department)->orderBy('id', 'desc')->get(),
        ]);
    }

    public function proposePayment(Request $request, $id)
    {

        $memo = Memo::where('id', $id)->with('approvers')->first();
        $employeeInfo = User::getUsersEmployeeInfo();
        $isRevised = ($memo->propose_payment_at) ? true : false;
        // cek apakah ada approver
        if (D_Payment_Approver::where('id_memo', $id)->count() <= 0) {
            $memo_approver = D_Memo_Approver::where('id_memo', $id)->get();
            $memo_approver->makeHidden(['id', 'created_at', 'updated_at', 'msg', 'status']);
            D_Payment_Approver::insert($memo_approver->toArray());
        }
        $check_history = D_Memo_History::where('id_memo', $id)->get();
        if ($check_history->count() > 0) {
            $doc_no = $memo->doc_no;
        } else {
            $doc_no = $this->generateDocNo();
        }

        // update status menjadi submit
        Memo::where('id', $id)->update([
            'status_payment'   => 'submit',
            'propose_payment_at' => Carbon::now(),
            'is_cost_invoice' => $request->input('is_cost_invoice')
        ]);

        if ($isRevised) {
            D_Payment_Approver::where('id_memo', $id)->where('status', 'revisi')->update([
                'status'   => 'submit'
            ]);
        } else {
            D_Payment_Approver::where('id_memo', $id)->update([
                'status'   => 'submit'
            ]);
        }

        // insert to history where first time submit
        D_Memo_History::create([
            'title' => 'Memo Payment Proposed',
            'id_memo'   => $id,
            'type'  => 'info',
            'content' => "Memo Payment successful submitted with document no $doc_no"
        ]);
        M_Data_Cost_Total::where('id_memo', $id)->update([
            'id_memo' => $id,
            'sub_total' => $request->input('sub_total'),
            'pph' => $request->input('pph'),
            'ppn' => $request->input('ppn'),
            'grand_total' => $request->input('grand_total')
        ]);

        $firstApprover = D_Payment_Approver::where('id_memo', $id)->where('status', 'submit')->with('employee')->orderBy('idx', 'asc')->first();
        if ($firstApprover->type_approver == 'acknowledge') {
            $type_approver = 'reviewer';
        } else {
            $type_approver = $firstApprover->type_approver;
        }
        // insert to history frist approval
        D_Memo_History::create([
            'title'     => "Process Approving {$firstApprover->idx}",
            'id_memo'   => $id,
            'type'      => 'info',
            'content'   => "On process approving by {$type_approver} {$firstApprover->idx} ({$firstApprover->employee->firstname} {$firstApprover->employee->lastname})"
        ]);
        $mailApprover = $firstApprover->employee->email;
        // kirim email ke approver pertama
        $details = [
            'subject' => $memo->title,
            'doc_no'  => $memo->doc_no,
            'type_approver' => $firstApprover->type_approver,
            'url'     => route('user.memo.approval.payment.detail', $id)
        ];


        if ($firstApprover->type_approver == 'approver') {
            $detailapprovers = [
                'doc_no'   => $memo->doc_no,
                'caption'  => $memo->title,
                'type'     => "warning",
                'subject' => "New submission memo payment $memo->title - $memo->doc_no. Click here for approve"
            ];
        } else {
            $detailapprovers = [
                'doc_no'   => $memo->doc_no,
                'caption'  => $memo->title,
                'type'     => "warning",
                'subject' => "New submission memo payment $memo->title - $memo->doc_no. Click here for review"
            ];
        }
        // notif app
        $firstApprover->employee->user->notify(new ApprovalNotification($detailapprovers, route('user.memo.approval.payment.detail', $memo->id)));

        Mail::to($mailApprover)->send(new \App\Mail\ApprovalPaymentMail($details));
        // kirim email ke tiap acknowlegde
        if ($memo->id_employee2 == $employeeInfo->id_employee) {
            return Redirect::route('user.memo.statustakeoverpaymentbranch.index')->with('success', "Successfull submit memo payment branch.");
        } else {
            return Redirect::route('user.memo.statuspayment.index')->with('success', "Successfull submit memo payment.");
        }
    }

    // public function paymentStore(Request $request, $id) {
    //      $request->validate([
    //          'name'              => 'required',
    //          'bank_name'         => 'required',
    //          'bank_account'      => 'required',
    //          'amount'            => 'required',
    //          'remark'            => 'required',
    //      ]);
    //     //ddd($id);
    //      $memoPayment = D_Memo_Payments::create([
    //          'id_memo'           => $id,
    //          'name'              => $request->input('name'),
    //          'bank_name'         => $request->input('bank_name'),
    //          'bank_account'      => $request->input('bank_account'),
    //          'amount'            => $request->input('amount'),
    //          'remark'            => $request->input('remark'),
    //      ]);

    //     //  dd($memoPayment);

    //      //$dataPayment = D_Memo_Payments::where('id_memo', $id)->first();
    //     //  return Redirect::back()->with('success', "Successfull add data payment");
    //      return response()->json([
    //          'id' => $memoPayment->id
    //      ]);
    // }

    public function updatePayment(Request $request, $id, $idpayment)
    {
        $request->validate([
            'name'              => 'required',
            'bank_name'         => 'required',
            'bank_account'      => 'required',
            'amount'            => 'required',
            'remark'            => 'required',
            'address'           => 'required'
        ]);

        D_Memo_Payments::where('id', $idpayment)->update([
            'name'              => $request->input('name'),
            'bank_name'         => $request->input('bank_name'),
            'bank_account'      => $request->input('bank_account'),
            'amount'            => $request->input('amount'),
            'remark'            => $request->input('remark'),
            'address'           => $request->input('address')
        ]);
        return response()->json([
            'success' => true
        ]);
        //return Redirect::back()->with('success', "Successfull update data vendor");
    }

    public function deletePayment($id)
    {
        $dataPayment = D_Memo_Payments::where('id', $id)->first();
        $dataPayment->delete();

        // return Redirect::back()->with('success', "Successfull delete data payment");
        return response()->json([
            'success' => true
        ]);
    }

    public function proposePo(Request $request, $id)
    {
        $request->validate([
            'name'              => 'required',
            'address'           => 'required',
        ]);

        D_Memo_Payments::create([
            'id_memo'           => $id,
            'name'              => $request->input('name'),
            'address'           => $request->input('address')
        ]);

        $memo = Memo::where('id', $id)->with('approvers')->first();
        // cek apakah ada approver
        if (D_Po_Approver::where('id_memo', $id)->count() <= 0) {
            $memo_approver = D_Memo_Approver::where('id_memo', $id)->get();
            $memo_approver->makeHidden(['id', 'created_at', 'updated_at', 'msg', 'status']);
            D_Po_Approver::insert($memo_approver->toArray());
        }

        $check_history = D_Memo_History::where('id_memo', $id)->get();
        if ($check_history->count() > 0) {
            $doc_no = $memo->doc_no;
        }

        // update status menjadi submit
        Memo::where('id', $id)->update([
            'status_po'   => 'submit',
        ]);

        D_Po_Approver::where('id_memo', $id)->update([
            'status'   => 'submit'
        ]);

        // insert to history where first time submit
        D_Memo_History::create([
            'title' => 'PO Proposed',
            'id_memo'   => $id,
            'type'  => 'info',
            'content' => "PO successful submitted with document no $doc_no"
        ]);

        $firstApprover = D_Po_Approver::where('id_memo', $id)->where('status', 'submit')->with('employee')->orderBy('idx', 'asc')->first();
        // insert to history frist approval
        D_Memo_History::create([
            'title'     => "Process Approving {$firstApprover->idx}",
            'id_memo'   => $id,
            'type'      => 'info',
            'content'   => "On process approving by approver {$firstApprover->idx} ({$firstApprover->employee->firstname} {$firstApprover->employee->lastname})"
        ]);
        $mailApprover = $firstApprover->employee->email;
        // kirim email ke approver pertama
        $details = [
            'subject' => $memo->title,
            'doc_no'  => $memo->doc_no,
            'url'     => route('user.memo.approval.po.detail', $id)
        ];

        if ($firstApprover->type_approver == 'approver') {
            $detailapprovers = [
                'doc_no'   => $memo->doc_no,
                'caption'  => $memo->title,
                'type'     => "warning",
                'subject' => "New submission memo po $memo->title - $memo->doc_no. Click here for approve"
            ];
        } else {
            $detailapprovers = [
                'doc_no'   => $memo->doc_no,
                'caption'  => $memo->title,
                'type'     => "warning",
                'subject' => "New submission memo po $memo->title - $memo->doc_no. Click here for review"
            ];
        }
        // notif app
        $firstApprover->employee->user->notify(new ApprovalNotification($detailapprovers, route('user.memo.approval.po.detail', $memo->id)));


        Mail::to($mailApprover)->send(new \App\Mail\ApprovalPOMail($details));
        // kirim email ke tiap acknowlegde

        return Redirect::route('user.memo.statuspo.index')->with('success', "Successfull submit PO.");
        // return response()->json([
        //     'status' => 200,
        //     'message' => 'Successfull add data vendor',
        // ]);
    }

    public function fileUploadAttach(Request $request, $id)
    {
        foreach ($request->file('files') as $file) {
            // $filename = $file->store('public/uploads/memo/attach');
            $fileHash = str_replace('.' . $file->extension(), '', $file->hashName());
            $fileName = $fileHash . '.' . $file->getClientOriginalExtension();

            // $path = Storage::disk('public')->putFileAs('forms/files', $file, $fileName);
            Storage::putFileAs('public/uploads/memo/attach', $file, $fileName);

            D_Memo_Attachment::create([
                'id_memo' => $id,
                'name' => $fileName,
                'type' => ($request->input('type')) ? $request->input('type') : 'memo',
                'real_name' => $file->getClientOriginalName()
            ]);
        }

        return Redirect::back()->with('success', "Successfull upload attachment.");
    }

    public function destroyAttach($id)
    {
        $attach = D_Memo_Attachment::where('id', $id)->first();
        $attach->delete();
        return Redirect::back()->with('success', "Atachment $attach->real_name deleted.");
    }

    public function updateAcknowledge(Request $request, $id, $type)
    {
        $acknowledges = D_Memo_Acknowledge::where('id_memo', $id)->get();
        $updatedacknowledges = $request->input('acknowledge');

        // update/insert pda D_Memo_Acknowledge
        if (count($updatedacknowledges) > 0) {
            foreach ($updatedacknowledges as $key => $value) {
                $itemacknowledge = D_Memo_Acknowledge::where('id_memo', $id)
                    ->where('type', $type)
                    ->where('id_employee', $value['id_employee'])
                    ->first();
                $item = [
                    'id_memo' => $id,
                    'id_employee'   =>  $value['id_employee'],
                    'type' => $type
                ];
                if ($itemacknowledge) {
                    $itemacknowledge->update($item);
                } else {
                    D_Memo_Acknowledge::create($item);
                }
            }
        }

        return Redirect::back()->with('success', "Successfull updated acknowledge.");
    }

    public function deleteAcknowledge(Request $request, $id, $id_employee, $type)
    {
        $acknowledge = D_Memo_Acknowledge::where('id_memo', $id)->where('type', $type)->where('id_employee', $id_employee)->first();
        $acknowledge->delete();

        return Redirect::back()->with('success', "Successfull delete acknowledge.");
    }


    public function updateApprover(Request $request, $id)
    {
        $memoapprover = D_Memo_Approver::where('id_memo', $id)->get();
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
                $itemapprover = D_Memo_Approver::where('id_memo', $id)->where('id_employee', $value['id_employee'])->first();
                $item = [
                    'id_memo' => $value['id_memo'],
                    'id_employee'   =>  $value['id_employee'],
                    'idx' => $key + 1,
                    'type_approver' => $value['type_approver']
                ];
                if ($itemapprover) {
                    $itemapprover->update($item);
                } else {
                    D_Memo_Approver::create($item);
                }
            }
        }

        // return Redirect::back()->with('success', "Successfull updated approver.");
        return response()->json([
            'status' => 200,
            'message' => 'Successfull update approver.',
        ]);
    }

    public function previewMemo(Request $request, $id)
    {
        return generatePDFMemo($id);
    }

    public function previewPo(Request $request, $id)
    {
        return generatePDFPo($id);
    }

    public function previewPayment(Request $request, $id)
    {
        return generatePDFPayment($id);
    }

    public function previewPaymentTakeoverBranch(Request $request, $id)
    {
        return generatePDFTakeoverBranch($id);
    }

    public function webpreviewMemo(Request $request, $id)
    {
        $memo = Memo::getMemoDetail($id);
        $proposeEmployee = Employee::getWithPositionNowById($memo);
        $memocost = (array) json_decode($memo->cost);
        $attachments = D_Memo_Attachment::where('id_memo', $id)->where('type', 'memo')->get();
        $attachments = $attachments->map(function ($itemattach) {
            $itemattach->name = Storage::url('public/uploads/memo/attach/' . $itemattach->name);
            return $itemattach;
        });
        $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();

        return Inertia::render('User/Memo/preview', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Memo",
                    'active'  => true
                ],
                [
                    'title'   => "Status Memo",
                    'href'    => "user.memo.statusmemo.index"
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
            'attachments' => $attachments
        ]);
    }

    public function webpreviewMemoTakeover(Request $request, $id)
    {
        $memo = Memo::getMemoDetail($id);
        $proposeEmployee = Employee::getWithPositionNowById($memo);
        $memocost = (array) json_decode($memo->cost);
        $attachments = D_Memo_Attachment::where('id_memo', $id)->where('type', 'memo')->get();
        $attachments = $attachments->map(function ($itemattach) {
            $itemattach->name = Storage::url('public/uploads/memo/attach/' . $itemattach->name);
            return $itemattach;
        });
        $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();

        return Inertia::render('User/Memo/preview', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Memo",
                    'active'  => true
                ],
                [
                    'title'   => "Status Memo Branch",
                    'href'    => "user.memo.statustakeovermemobranch.index"
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
            'attachments' => $attachments
        ]);
    }

    public function webpreviewPayment(Request $request, $id)
    {
        $memo = Memo::getPaymentDetail($id);
        $dataPayments = Memo::where('id', $id)->with('payments')->first();
        $proposeEmployee = Employee::getWithPositionNowById($memo);
        $memocost = (array) json_decode($memo->cost);
        $attachments = D_Memo_Attachment::where('id_memo', $id)->get();
        $attachments = $attachments->map(function ($itemattach) {
            $itemattach->name = Storage::url('public/uploads/memo/attach/' . $itemattach->name);
            return $itemattach;
        });
        $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();

        return Inertia::render('User/Status_Payment/preview', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Memo",
                    'active'  => true
                ],
                [
                    'title'   => "Status Payment",
                    'href'    => "user.memo.statuspayment.index"
                ],
                [
                    'title'   => $memo->doc_no,
                    'active'  => true
                ]
            ),
            'dataMemo' => $memo,
            'dataTotalCost' => $dataTotalCost,
            'dataPayments' => $dataPayments->payments,
            'proposeEmployee' => $proposeEmployee,
            'memocost' => $memocost,
            'attachments' => $attachments
        ]);
    }

    public function webpreviewPaymentTakeoverBranch(Request $request, $id)
    {
        $memo = Memo::getPaymentDetail($id);
        $dataPayments = Memo::where('id', $id)->with('payments')->first();
        $proposeEmployee = Employee::getWithPositionNowById($memo, true);
        $memocost = (array) json_decode($memo->cost);
        $attachments = D_Memo_Attachment::where('id_memo', $id)->get();
        $attachments = $attachments->map(function ($itemattach) {
            $itemattach->name = Storage::url('public/uploads/memo/attach/' . $itemattach->name);
            return $itemattach;
        });
        $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();

        return Inertia::render('User/Status_Payment_Takeover_Branch/preview', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Memo",
                    'active'  => true
                ],
                [
                    'title'   => "Status Payment Branch",
                    'href'    => "user.memo.statustakeoverpaymentbranch.index"
                ],
                [
                    'title'   => $memo->doc_no,
                    'active'  => true
                ]
            ),
            'dataMemo' => $memo,
            'dataTotalCost' => $dataTotalCost,
            'dataPayments' => $dataPayments->payments,
            'proposeEmployee' => $proposeEmployee,
            'memocost' => $memocost,
            'attachments' => $attachments
        ]);
    }

    public function webpreviewPo(Request $request, $id)
    {
        $memo = Memo::getPoDetail($id);
        $proposeEmployee = Employee::getWithPositionNowById($memo);
        $memocost = (array) json_decode($memo->cost);
        $attachments = D_Memo_Attachment::where('id_memo', $id)->where('type', 'memo')->get();
        $attachments = $attachments->map(function ($itemattach) {
            $itemattach->name = Storage::url('public/uploads/memo/attach/' . $itemattach->name);
            return $itemattach;
        });
        $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();

        return Inertia::render('User/Status_Po/preview', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Memo",
                    'active'  => true
                ],
                [
                    'title'   => "Status Purchase Order",
                    'href'    => "user.memo.statuspo.index"
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
            'attachments' => $attachments
        ]);
    }

    public function senddraft(Request $request, $id)
    {
        Memo::where('id', $id)->update([
            'status'   => 'edit'
        ]);

        // D_Memo_Approver::where('id_memo', $id)->update([
        //     'status'   => 'edit'
        // ]);

        $memo = Memo::where('id', $id)->first();
        return Redirect::route('user.memo.draft.edit', [$memo])->with('success', "memo has sent to draft.");
    }

    public function sendDraftPayment(Request $request, $id)
    {
        Memo::where('id', $id)->update([
            'status_payment'   => 'edit'
        ]);

        // D_Payment_Approver::where('id_memo', $id)->update([
        //     'status'   => 'edit'
        // ]);

        $memo = Memo::where('id', $id)->first();
        return Redirect::route('user.memo.draft.edit', [$memo])->with('success', "memo has sent to draft.");
    }


    public function test()
    {
        // $this->generateDocNo();
        // $memo = D_Memo_History::where('id_memo', 6)->get();
        // if($memo->count() > 1);
        // $details = [
        //     'title' => 'Mail from ItSolutionStuff.com',
        //     'body' => 'This is for testing email using smtp'
        // ];

        // kirim email ke setiap CC
        $acknowledges = D_Memo_Acknowledge::with('employee')->where('id_memo', 41)->where('type', 'payment')->get();

        foreach ($acknowledges as $acknowledge) {
            dd($acknowledge->employee->email);
            $acknowledge->employee->email &&
                Mail::to($acknowledge->emloyee->email)->send(new \App\Mail\NotifUserProposeMail());
            //     Mail::to($acknowledge->emloyee->email)->send(new \App\Mail\NotifUserProposeMail());
        }

        // Mail::to('jonatan.teofilus@gmail.com')->send(new \App\Mail\ApprovalMemoMail($details));
    }

    private function generateDocNo()
    {
        $ref_doc_no = Ref_Doc_No::first();
        if ($ref_doc_no) {
            $lastdocno = $ref_doc_no->no;
            $arraylastdocno = explode('/', $lastdocno);
            $str = "SHF/" . (int) ($arraylastdocno[1] + 1) . "/" . Carbon::now()->format('m.y');
            $ref_doc_no->no = $str;
            $ref_doc_no->save();
        } else {
            $str = "SHF/1/" . Carbon::now()->format('m.y');
            $doc_no = Ref_Doc_No::create([
                'no' => $str
            ]);
        }
        return $str;
    }
}
