<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\D_Memo_Approver;
use App\Models\D_Memo_Attachment;
use App\Models\Memo;
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

    public function fileUploadPost(Request $request, $id)
    {
        $memo = Memo::getMemoDetail($id);

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
