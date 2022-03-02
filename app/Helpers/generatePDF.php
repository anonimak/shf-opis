<?php

use App\Models\D_Memo_Attachment;
use App\Models\D_Memo_Invoices;
use App\Models\D_Memo_Payments;
use App\Models\Employee_History;
use App\Models\M_Data_Cost_Total;
use App\Models\Memo;
use App\Models\Ref_Type_Memo;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Str;
use Carbon\Carbon;

function generatePDFMemo($id, $fromroute = 'true')
{
    // $memo = Memo::getMemoDetailDraftEdit($id);
    $dataMemo = Memo::where('id', $id)->first();
    if ($dataMemo->propose_at == null) {
        $memo = Memo::getMemoDetailDraftEdit($id);
    } else {
        $memo = Memo::getMemoDetail($id);
    }
    $employeeProposeInfo = Memo::getMemoDetailEmployeePropose($id);
    $employeeInfo = User::getUsersEmployeeInfo();
    $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
        return $employee->select('id', 'firstname', 'lastname');
    }])->with('position')->get();
    $dataTypeMemo = Ref_Type_Memo::where('id_department', $employeeInfo->employee->position_now->position->id_department)->orderBy('id', 'desc')->get();
    $attachments = D_Memo_Attachment::where('id_memo', $id)->where('type', 'memo')->get();
    $memocost = (array) json_decode($memo->cost);
    $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();
    // dd($memo);
    $data = [
        'memo' => $memo,
        'employeeInfo' => $employeeInfo,
        'employeeproposeinfo' => $employeeProposeInfo,
        'positions' => $positions,
        'dataTypeMemo' => $dataTypeMemo,
        'dataAttachments' => $attachments,
        'memocost' => $memocost,
        'dataTotalCost' => $dataTotalCost,
        'qrcode' => base64_encode(\QrCode::format('svg')->size(100)->errorCorrection('H')->generate(url('check-memo', base64_encode($memo->doc_no)))),
        'dataCostInvoice' => ($memo->is_cost_invoice) ? D_Memo_Invoices::where('id_memo', $id)->with(['item_invoices' => function ($item) {
            return $item->orderBy('created_at', 'asc');
        }])->orderBy('created_at', 'asc')->get() : null
    ];
    $pdf = PDF::loadView('pdf/preview_memo', $data)->setOptions(['defaultFont' => 'open-sans']);
    $pdf->setPaper('A4', $memo->orientation_paper);
    // download PDF file with download method
    // return $pdf->download('pdf_file.pdf');
    if ($fromroute) {

        $filename = Str::kebab($memo->title) . '-' . Carbon::now()->timestamp . '.pdf';
        return $pdf->stream($filename, array("Attachment" => false));
    }

    return $pdf;
}

function generatePDFPo($id, $fromroute = 'true')
{
    // $memo = Memo::getPoDetailApprovers($id);
    $memo = Memo::getPoDetail($id);
    $employeeProposeInfo = Memo::getMemoDetailEmployeePropose($id);
    $employeeInfo = User::getUsersEmployeeInfo();
    $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
        return $employee->select('id', 'firstname', 'lastname');
    }])->with('position')->get();
    $dataPayments = D_Memo_Payments::where('id_memo', $id)->first();
    $dataTypeMemo = Ref_Type_Memo::where('id_department', $employeeInfo->employee->position_now->position->id_department)->orderBy('id', 'desc')->get();
    $attachments = D_Memo_Attachment::where('id_memo', $id)->get();
    $memocost = (array) json_decode($memo->cost);
    //ddd($dataPayments->payments);
    $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();
    $data = [
        'memo' => $memo,
        'employeeInfo' => $employeeInfo,
        'employeeproposeinfo' => $employeeProposeInfo,
        'positions' => $positions,
        'dataTypeMemo' => $dataTypeMemo,
        'dataAttachments' => $attachments,
        'memocost' => $memocost,
        'dataPayments' => $dataPayments,
        'dataTotalCost' => $dataTotalCost,
        'qrcode' => base64_encode(\QrCode::format('svg')->size(60)->errorCorrection('H')->generate(url('check-po', base64_encode($memo->po_no)))),
        'dataCostInvoice' => ($memo->is_cost_invoice) ? D_Memo_Invoices::where('id_memo', $id)->with(['item_invoices' => function ($item) {
            return $item->orderBy('created_at', 'asc');
        }])->orderBy('created_at', 'asc')->get() : null
    ];
    $pdf = PDF::loadView('pdf/preview_po', $data)->setOptions(['defaultFont' => 'open-sans', 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
    $pdf->setPaper('A4', $memo->orientation_paper);
    // download PDF file with download method
    // return $pdf->download('pdf_file.pdf');
    if ($fromroute) {
        $filename = 'PO-' . Str::kebab($memo->title) . '-' . Carbon::now()->timestamp . '.pdf';
        return $pdf->stream($filename, array("Attachment" => false));
    }

    return $pdf;
}

function generatePDFPayment($id, $fromroute = 'true')
{
    // $memo = Memo::getPaymentDetailApprovers($id);
    $dataMemo = Memo::where('id', $id)->first();
    if ($dataMemo->propose_at == null) {
        $memo = Memo::getPaymentDetailApprovers($id);
    } else {
        $memo = Memo::getPaymentDetail($id);
    }
    $employeeInfo = User::getUsersEmployeeInfo();

    $employeeProposeInfo = ($memo->id_employee2) ? Memo::getMemoDetailEmployeePropose($id, true) : Memo::getMemoDetailEmployeePropose($id);
    if ($memo->id_employee2) {
        $employeeProposeInfo->proposeemployee = $employeeProposeInfo->proposeemployee2;
    }

    $dataPayments = Memo::where('id', $id)->with('payments')->first();
    $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
        return $employee->select('id', 'firstname', 'lastname');
    }])->with('position')->get();
    $dataTypeMemo = Ref_Type_Memo::where('id_department', $employeeInfo->employee->position_now->position->id_department)->orderBy('id', 'desc')->get();
    $attachments = D_Memo_Attachment::where('id_memo', $id)->get();

    $memocost = (array) json_decode($memo->cost);
    $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();
    $data = [
        'memo' => $memo,
        'employeeInfo' => $employeeInfo,
        'employeeproposeinfo' => $employeeProposeInfo,
        'positions' => $positions,
        'dataTypeMemo' => $dataTypeMemo,
        'dataAttachments' => $attachments,
        'memocost' => $memocost,
        'dataPayments' => $dataPayments->payments,
        'dataTotalCost' => $dataTotalCost,
        'qrcode' => base64_encode(\QrCode::format('svg')->size(100)->errorCorrection('H')->generate(url('check-memo-payment', base64_encode($memo->doc_no)))),
        'dataCostInvoice' => ($memo->is_cost_invoice) ? D_Memo_Invoices::where('id_memo', $id)->with(['item_invoices' => function ($item) {
            return $item->orderBy('created_at', 'asc');
        }])->orderBy('created_at', 'asc')->get() : null
    ];
    $pdf = PDF::loadView('pdf/preview_payment', $data)->setOptions(['defaultFont' => 'open-sans']);
    $pdf->setPaper('A4', $memo->orientation_paper);

    if ($fromroute) {
        $filename = 'Payment-' . Str::kebab($memo->title) . '-' . Carbon::now()->timestamp . '.pdf';
        return $pdf->stream($filename, array("Attachment" => false));
    }

    return $pdf;
}

function generatePDFTakeoverBranch($id, $fromroute = 'true')
{
    // $memo = Memo::getPaymentDetailApprovers($id);
    $memo = Memo::getPaymentDetail($id);
    $employeeInfo = User::getUsersEmployeeInfo();
    $employeeProposeInfo = Memo::getMemoDetailEmployeePropose($id, $isTakeoverBranch = true);
    $dataPayments = Memo::where('id', $id)->with('payments')->first();
    $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
        return $employee->select('id', 'firstname', 'lastname');
    }])->with('position')->get();
    $dataTypeMemo = Ref_Type_Memo::where('id_department', $employeeInfo->employee->position_now->position->id_department)->orderBy('id', 'desc')->get();
    $attachments = D_Memo_Attachment::where('id_memo', $id)->get();

    $memocost = (array) json_decode($memo->cost);
    $dataTotalCost = M_Data_Cost_Total::where('id_memo', $id)->first();
    $data = [
        'memo' => $memo,
        'employeeInfo' => $employeeInfo,
        'employeeproposeinfo' => $employeeProposeInfo,
        'positions' => $positions,
        'dataTypeMemo' => $dataTypeMemo,
        'dataAttachments' => $attachments,
        'memocost' => $memocost,
        'dataPayments' => $dataPayments->payments,
        'dataTotalCost' => $dataTotalCost,
        'qrcode' => base64_encode(\QrCode::format('svg')->size(100)->errorCorrection('H')->generate(url('check-memo-payment', base64_encode($memo->doc_no)))),
        'dataCostInvoice' => ($memo->is_cost_invoice) ? D_Memo_Invoices::where('id_memo', $id)->with(['item_invoices' => function ($item) {
            return $item->orderBy('created_at', 'asc');
        }])->orderBy('created_at', 'asc')->get() : null
    ];
    $pdf = PDF::loadView('pdf/preview_payment', $data)->setOptions(['defaultFont' => 'open-sans']);
    $pdf->setPaper('A4', $memo->orientation_paper);

    if ($fromroute) {
        $filename = 'Memo-Takeover-' . Str::kebab($memo->title) . '-' . Carbon::now()->timestamp . '.pdf';
        return $pdf->stream($filename, array("Attachment" => false));
    }

    return $pdf;
}
