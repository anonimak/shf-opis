<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\D_Memo_Acknowledge;
use App\Models\D_Memo_Approver;
use App\Models\D_Memo_Attachment;
use App\Models\Employee_History;
use App\Models\Memo;
use App\Models\Ref_Position;
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
            'dataMemo' => Memo::getMemo(auth()->user()->id_employee,  $tab, $request->input('search'))->paginate(10),
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
                ]
            ),
            'tab' => ['submit', 'approve', 'reject'],
            'counttab' => [
                'submit' => Memo::getMemo(auth()->user()->id_employee, 'submit')->count(),
                'approve' => Memo::getMemo(auth()->user()->id_employee, 'approve')->count(),
                'reject' => Memo::getMemo(auth()->user()->id_employee, 'reject')->count(),
            ],
            '__create'  => 'user.memo.create',
            '__edit'    => 'user.memo.edit',
            '__show'    => 'user.memo.show',
            '__destroy' => 'user.memo.destroy',
            '__index'   => 'user.memo.index'
        ]);
    }

    public function draft(Request $request)
    {

        return Inertia::render('User/Memo/Draft', [
            'perPage' => 10,
            'dataMemo' => Memo::getMemo(auth()->user()->id_employee, "edit", $request->input('search'))->paginate(10),
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
                    'title'   => $memo->doc_no,
                    'active'  => true
                ]
            ),
            '_token' => csrf_token(),
            '__attachment'  => 'user.memo.draft.attachment',
            '__update' => 'user.memo.draft.update',
            '__updateApprover' => 'user.memo.draft.updateapprover',
            '__updateAcknowledge' => 'user.memo.draft.updateacknowledge',
            '__preview' => 'user.memo.draft.preview',
            'dataPosition' => $positions,
            'dataMemo' => $memo,
            'dataTypeMemo'  => Ref_Type_Memo::where('id_department', $employeeInfo->employee->position_now->position->id_department)->orderBy('created_at', 'desc')->get(),
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
        ]);
        $memo = Memo::where('id', $id)->first();
        return Redirect::route('user.memo.draft.edit', [$memo])->with('success', "Successfull updated.");
    }

    public function store(Request $request)
    {
        $employeeInfo = User::getUsersEmployeeInfo();
        $request->validate([
            'title'        => 'required',
            'typememo'     => 'required',
        ]);
        $memo = Memo::create([
            'title'                 => $request->input('title'),
            'id_employee'           => $employeeInfo->employee->id,
            'doc_no'                => $this->generateDocNo(),
            'id_type'               => $request->input('typememo'),
        ]);
        $detail_approver = Ref_Type_Memo::get_ref_module_approver_detail_by_id($memo);
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
        // update status menjadi submit
        $memo = Memo::where('id', $id)->update([
            'status'   => 'submit'
        ]);
        D_Memo_Approver::where('id_memo', $id)->update([
            'status'   => 'submit'
        ]);



        // kirim email ke approver pertama
        $details = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp'
        ];

        Mail::to('jonatan.teofilus@gmail.com')->send(new \App\Mail\ApprovalMemoMail($details));
        // kirim email ke tiap acknowlegde
        return Redirect::route('user.memo.index')->with('success', "Successfull submit memo.");
    }

    public function fileUploadAttach(Request $request, $id)
    {
        // $memo = Memo::getMemoDetail($id);
        // dd($request->all());
        foreach ($request->post('attach') as $uploadedFile) {
            $uploadedFile = json_decode($uploadedFile);
            var_dump($uploadedFile);
            die();
            $filename = time() . '_' . $uploadedFile->name;

            // $path = $uploadedFile->store($filename, 'uploads');
            Storage::put('uploads/memo/attach/' . $filename, $uploadedFile);
            D_Memo_Attachment::create([
                'id_memo' => $id,
                'name' => $filename,
                'real_name' => $uploadedFile->name
            ]);
        }

        return back()
            ->with('success', 'You have successfully upload file.');
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
                $itemapprover = D_Memo_Approver::where('id_employee', $value['id_employee'])->first();
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

        $data = [
            'memo' => $memo,
            'employeeInfo' => $employeeInfo,
            'positions' => $positions,
            'dataTypeMemo' => $dataTypeMemo
        ];
        $pdf = PDF::loadView('pdf/preview_memo', $data)->setOptions(['defaultFont' => 'open-sans']);
        $pdf->setPaper('A4', 'portrait');
        // download PDF file with download method
        // return $pdf->download('pdf_file.pdf');
        return $pdf->stream("dompdf_out.pdf", array("Attachment" => false));
    }


    public function test()
    {
        $details = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp'
        ];

        Mail::to('jonatan.teofilus@gmail.com')->send(new \App\Mail\ApprovalMemoMail($details));
    }

    private function generateDocNo()
    {
        $lastrow = Memo::orderBy('id', 'desc')->first();
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
