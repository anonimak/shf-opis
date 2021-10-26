<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\D_Memo_Acknowledge;
use App\Models\D_Memo_Approver;
use App\Models\D_Memo_Attachment;
use App\Models\D_Memo_History;
use App\Models\Employee;
use App\Models\Employee_History;
use App\Models\Memo;
use App\Models\Ref_Template_Cost;
use App\Models\Ref_Type_Memo;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
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
        return Inertia::render('User/Memo', [
            'perPage' => 10,
            'dataMemo' => Memo::getMemo(auth()->user()->id_employee,  $tab, $request->input('search'))->with('latestHistory')->paginate(10),
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
            '__index'   => 'user.memo.statusmemo.index',
            '__webpreview'   => 'user.memo.statusmemo.webpreview',
            '__senddraft'   => 'user.memo.statusmemo.senddraft'
        ]);
    }

    public function draft(Request $request)
    {

        return Inertia::render('User/Memo/Draft', [
            'perPage' => 10,
            'dataMemo' => Memo::getMemo(auth()->user()->id_employee, "edit", $request->input('search'))->with('latestHistory')->paginate(10),
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
            'dataTypeMemo'  => Ref_Type_Memo::where('id_department', $employeeInfo->employee->position_now->position->id_department)->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function draftEdit($id)
    {
        $memo = Memo::getMemoDetail($id);
        $employeeInfo = User::getUsersEmployeeInfo();

        $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname');
        }])->with('position')->get();

        $attachments = D_Memo_Attachment::where('id_memo', $id)->get();

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
            '__attachment'  => 'user.memo.draft.attachment',
            '__removeAttachment'  => 'user.memo.draft.attachmentremove',
            '__update' => 'user.memo.draft.update',
            '__updateApprover' => 'user.memo.draft.updateapprover',
            '__updateAcknowledge' => 'user.memo.draft.updateacknowledge',
            '__preview' => 'user.memo.draft.preview',
            'dataPosition' => $positions,
            'dataMemo' => $memo,
            'dataAttachments' => $attachments,
            'headerCost' => $headerCost,
            'columnCost' => $columnCost,
            // 'dataTypeMemo'  => Ref_Type_Memo::where('id_department', $employeeInfo->employee->position_now->position->id_department)->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function draftUpdate(Request $request, $id)
    {

        Memo::where('id', $id)->update([
            'doc_no'   => $request->input('doc_no'),
            'background'        => $request->input('background'),
            'information'       => $request->input('information'),
            'conclusion'        => $request->input('conclusion'),
            'payment'           => $request->input('payment'),
            'cost'              => ($request->has('cost')) ? $request->input('cost') : null,
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

        $memo = Memo::create([
            'title'                 => $request->input('title'),
            'id_employee'           => $employeeInfo->employee->id,
            'id_type'               => $request->input('typememo'),
        ]);
        $branch = Branch::select('id')->where('is_head', true)->orWhere('id', $employeeBranch)->get();
        $detail_approver = Ref_Type_Memo::get_ref_module_approver_detail_by_id($memo, $branch);
        $dataDetailInsert = $detail_approver->ref_module_approver_detail->toArray();
        D_Memo_Approver::insert($dataDetailInsert);
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
        $memo = Memo::where('id', $id)->first();
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
            'propose_at' => Carbon::now()
        ]);

        D_Memo_Approver::where('id_memo', $id)->update([
            'status'   => 'submit'
        ]);

        // insert to history where first time submit
        D_Memo_History::create([
            'title' => 'Memo Proposed',
            'id_memo'   => $id,
            'type'  => 'info',
            'content' => "Memo successful submitted with document no $doc_no"
        ]);

        $firstApprover = D_Memo_Approver::where('id_memo', $id)->where('status', 'submit')->orderBy('idx', 'asc')->first();
        // insert to history frist approval
        D_Memo_History::create([
            'title'     => "Process Approving {$firstApprover->idx}",
            'id_memo'   => $id,
            'type'      => 'info',
            'content'   => "On process approving by approver {$firstApprover->idx}"
        ]);
        $mailApprover = $firstApprover->employee->email;
        // kirim email ke approver pertama
        $details = [
            'subject' => $memo->title,
            'doc_no'  => $memo->doc_no,
            'url'     => route('user.memo.approval.detail', $id)
        ];

        Mail::to($mailApprover)->send(new \App\Mail\ApprovalMemoMail($details));
        // kirim email ke tiap acknowlegde
        return Redirect::route('user.memo.index')->with('success', "Successfull submit memo.");
    }

    public function fileUploadAttach(Request $request, $id)
    {
        foreach ($request->file('files') as $file) {
            $filename = $file->store('public/uploads/memo/attach');
            D_Memo_Attachment::create([
                'id_memo' => $id,
                'name' => $file->hashName(),
                'real_name' => $file->getClientOriginalName()
            ]);
        }

        return Redirect::route('user.memo.draft.edit', $id)->with('success', "Successfull upload attachment.");
    }

    public function destroyAttach($id)
    {
        $attach = D_Memo_Attachment::where('id', $id)->first();
        $attach->delete();
        return
            Redirect::route('user.memo.draft.edit', $attach->id_memo)->with('success', "Atachment $attach->real_name deleted.");
    }

    public function updateAcknowledge(Request $request, $id)
    {
        $acknowledges = D_Memo_Acknowledge::where('id_memo', $id)->get();
        $updatedacknowledges = $request->input('acknowledge');
        // filter yang tidak ada pada updatedacknowledges
        $filteredacknowledges = $acknowledges->filter(function ($item, $key) use ($updatedacknowledges) {
            if (count($updatedacknowledges)) {
                $itemacknowledge = array_column($updatedacknowledges, 'id_employee');
                $key = in_array($item->id_employee, $itemacknowledge);
                if (!$key) {
                    return $item;
                }
            }
            return $item;
        });

        // delete filter yang tidak ada pada D_Memo_Acknowledge
        if (count($filteredacknowledges) > 0) {
            foreach ($filteredacknowledges as $itemfiltered) {
                $itemfiltered->delete();
            }
        }

        // update/insert pda D_Memo_Acknowledge
        if (count($updatedacknowledges) > 0) {
            foreach ($updatedacknowledges as $key => $value) {
                $itemacknowledge = D_Memo_Acknowledge::where('id_employee', $value['id_employee'])->first();
                $item = [
                    'id_memo' => $id,
                    'id_employee'   =>  $value['id_employee']
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
                    'idx' => $key + 1
                ];
                if ($itemapprover) {
                    $itemapprover->update($item);
                } else {
                    D_Memo_Approver::create($item);
                }
            }
        }

        return Redirect::back()->with('success', "Successfull updated approver.");
    }

    public function previewMemo(Request $request, $id)
    {
        $memo = Memo::getMemoDetail($id);
        $employeeInfo = User::getUsersEmployeeInfo();
        $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname');
        }])->with('position')->get();
        $dataTypeMemo = Ref_Type_Memo::where('id_department', $employeeInfo->employee->position_now->position->id_department)->orderBy('created_at', 'desc')->get();
        $attachments = D_Memo_Attachment::where('id_memo', $id)->get();
        // $sumtotal = 0;
        $memocost = (array) json_decode($memo->cost);
        // $memocost = array_map(function ($itemcost) use ($sumtotal) {
        //     $itemcost->Total = $itemcost->QTY * $itemcost->Price;
        //     $sumtotal += $itemcost->Total;
        //     return $itemcost;
        // }, $memocost);
        // foreach ($memocost as $itemcost) {
        //     $sumtotal += $itemcost->Total;
        // }
        // $ppn = $sumtotal * 10 / 100;
        // $grandtotal = $sumtotal - $ppn;

        $data = [
            'memo' => $memo,
            'employeeInfo' => $employeeInfo,
            'positions' => $positions,
            'dataTypeMemo' => $dataTypeMemo,
            'dataAttachments' => $attachments,
            'memocost' => $memocost,
            // 'sumtotal' => $sumtotal,
            // 'ppn' => $ppn,
            // 'grandtotal' => $grandtotal,
        ];
        $pdf = PDF::loadView('pdf/preview_memo', $data)->setOptions(['defaultFont' => 'open-sans']);
        $pdf->setPaper('A4', 'portrait');
        // download PDF file with download method
        // return $pdf->download('pdf_file.pdf');
        return $pdf->stream("dompdf_out.pdf", array("Attachment" => false));
    }

    public function webpreviewMemo(Request $request, $id)
    {
        $memo = Memo::getMemoDetail($id);
        $proposeEmployee = Employee::getWithPositionNowById($memo);
        $memocost = (array) json_decode($memo->cost);
        $attachments = D_Memo_Attachment::where('id_memo', $id)->get();
        $attachments = $attachments->map(function ($itemattach) {
            $itemattach->name = Storage::url('public/uploads/memo/attach/' . $itemattach->name);
            return $itemattach;
        });

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

        D_Memo_Approver::where('id_memo', $id)->update([
            'status'   => 'edit'
        ]);

        $memo = Memo::where('id', $id)->first();
        return Redirect::route('user.memo.draft.edit', [$memo])->with('success', "memo has sent to draft.");
    }


    public function test()
    {
        // $memo = D_Memo_History::where('id_memo', 6)->get();
        // if($memo->count() > 1);
        // $details = [
        //     'title' => 'Mail from ItSolutionStuff.com',
        //     'body' => 'This is for testing email using smtp'
        // ];

        // Mail::to('jonatan.teofilus@gmail.com')->send(new \App\Mail\ApprovalMemoMail($details));
    }

    private function generateDocNo()
    {
        $lastrow = Memo::whereNotNull('doc_no')->orderBy('id', 'desc')->first();
        if ($lastrow) {
            $lastdocno = $lastrow->doc_no;
            $arraylastdocno = explode('/', $lastdocno);
            $str = "SHF/" . (int) ($arraylastdocno[1] + 1) . "/" . Carbon::now()->format('m.y');
        } else {
            $str = "SHF/1/" . Carbon::now()->format('m.y');
        }
        return $str;
    }
}
