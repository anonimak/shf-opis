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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MemoController extends Controller
{
    public function index(Request $request)
    {

        return Inertia::render('User/Memo', [
            'perPage' => 10,
            'dataMemo' => Memo::getMemo(auth()->user()->id_employee,  $request->input('tab'), $request->input('search'))->paginate(10),
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
            '__destroy' => 'user.memo.destroy'
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
            '__store'  => 'user.memo.store',
            '__attachment'  => 'user.memo.attachment',
            '__updateApprover' => 'user.memo.draft.updateapprover',
            '__updateAcknowledge' => 'user.memo.draft.updateacknowledge',
            'dataPosition' => $positions,
            'dataMemo' => $memo,
            'dataTypeMemo'  => Ref_Type_Memo::where('id_department', $employeeInfo->employee->position_now->position->id_department)->orderBy('created_at', 'desc')->get(),
        ]);
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

    public function fileUploadAttach(Request $request, $id)
    {
        // $memo = Memo::getMemoDetail($id);

        foreach ($request->file('files') as $uploadedFile) {

            $filename = time() . '_' . $uploadedFile->getClientOriginalName();

            $path = $uploadedFile->store($filename, 'uploads');

            D_Memo_Attachment::create([
                'id_memo' => $id,
                'name' => $filename,
                'real_name' => $uploadedFile->getClientOriginalName()
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

    public function test()
    {
        dd(Ref_Type_Memo::with('ref_module_approver_detail')->get());
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
