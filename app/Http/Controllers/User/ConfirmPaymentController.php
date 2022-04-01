<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Memo;
use App\User;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\D_Memo_Attachment;
use App\Models\M_Data_Cost_Total;
use App\Models\D_Memo_History;
use App\Models\Employee_History;
use App\Models\Ref_Type_Memo;
use App\Models\Branch;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade as PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ConfirmPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tab = 'unpaid';
        if ($request->has('tab')) {
            $tab = $request->input('tab');
        }

        $dataBranch = Branch::where('branch_name','<>','NULL')->get();
        $memo = Memo::getAllMemoPayment(auth()->user()->id_employee, $tab, $request->input('search'), $request->input('checkedBranch'))->paginate(10);

        return Inertia::render('User/Confirm_Payment', [
            'perPage' => 10,
            'dataMemo' => $memo,
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Confirm Payments",
                    'active'  => true
                ]
            ),
            'tab' => ['unpaid', 'paid'],
            'counttab' => [
                'unpaid' => Memo::getAllMemoPayment(auth()->user()->id_employee, 'unpaid')->count(),
                'paid' => Memo::getAllMemoPayment(auth()->user()->id_employee, 'paid')->count(),
            ],
            'dataBranch' => $dataBranch,
            '__confirming'  => 'user.memo.confirmpayment.confirming',
            '__previewpdf'  => 'user.memo.confirmpayment.preview',
            '__detail'    => 'user.memo.confirmpayment.webpreview',
            '__index'    => 'user.memo.confirmpayment.index',
        ]);
    }

    public function detailPayment(Request $request, $id)
    {
        $memo = Memo::getPaymentDetailWithCurrentApprover($id, auth()->user()->id_employee);
        $proposeEmployee = ($memo->id_employee2) ? Employee::getWithPositionNowById($memo, true) : Employee::getWithPositionNowById($memo);
        $dataPayments = Memo::where('id', $id)->with('payments')->first();
        $memocost = (array) json_decode($memo->cost);
        $attachments = D_Memo_Attachment::where('id_memo', $id)->get();
        $attachments = $attachments->map(function ($itemattach) {
            $itemattach->name = Storage::url('public/uploads/memo/attach/' . $itemattach->name);
            return $itemattach;
        });
        $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();

        return Inertia::render('User/Confirm_Payment/preview', [
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "user.dashboard"
                ],
                [
                    'title'   => "Confirm Payments",
                    'href'  => "user.memo.confirmpayment.index"
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
            'attachments' => $attachments,
            '__confirming'  => 'user.memo.confirmpayment.confirming',
        ]);
    }

    public function previewPDF(Request $request, $id)
    {
        return generatePDFPayment($id);
    }

    public function confirmingPayment($id, $idConfirmedPayment)
    {
        $confirmer = Employee::where('id', $idConfirmedPayment)->first();
        //ddd($confirmer);
        $memo = Memo::where('id', $id)->with('proposeemployee')->first();
        $proposeEmployee = ($memo->id_employee2) ? Employee::getWithPositionNowById($memo, true) : $memo->proposeemployee;
        //ddd($proposeEmployee);
        Memo::where('id', $id)->update([
            'payment_at' => Carbon::now()
        ]);
        $contentHistory = [
            'title'     => "Memo Payment has been paid.",
            'id_memo'   => $memo->id,
            'type'      => 'success',
            'content'   => "Confirmed Payment by ({$confirmer->firstname} {$confirmer->lastname})"
        ];

        // insert to history when approved
        D_Memo_History::create($contentHistory);

        $detailspropose = [
            'subject' => "Memo Payment $memo->doc_no has been paid by {$confirmer->firstname}",
            'message' => "Memo Payment $memo->doc_no has been paid by {$confirmer->firstname} {$confirmer->lastname}"
        ];

        Mail::to($proposeEmployee->email)->send(new \App\Mail\NotifUserProposePaymentMail($detailspropose));


        return Redirect::route('user.memo.confirmpayment.index')->with('success', "Successfull Confirmed Payment");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
