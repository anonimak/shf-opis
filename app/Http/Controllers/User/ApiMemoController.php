<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\D_Memo_Approver;
use App\Models\D_Memo_Invoices;
use App\Models\D_Item_Invoice;
use App\Models\Employee_History;
use Illuminate\Http\Request;

class ApiMemoController extends Controller
{
    //

    public function getPositionNow()
    {
        $positions = Employee_History::position_now()->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname');
        }])->with('position')->get();

        return response()->json($positions);
    }

    public function getApproversByIdMemo($id)
    {
        $approvers = D_Memo_Approver::where('id_memo', $id)->with(['employee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                return $position_now->with(['position' => function ($position) {
                    return $position->with('department');
                }])->with('branch');
            }]);
        }])->orderBy('idx', 'asc')->get();

        return response()->json($approvers);
    }

    public function getInvoicesByIdMemo($id)
    {
        $dataInvoices = D_Memo_Invoices::where('id_memo', $id)->with(['item_invoices' => function ($item) {
            return $item->orderBy('created_at', 'asc');
        }])->orderBy('created_at', 'asc')->get();

        return response()->json($dataInvoices);
    }

    public function addItemInvoice(Request $request)
    {
        $itemInvoice = D_Item_Invoice::create([
            'id_invoice'            => $request->input('id_invoice'),
            'description'           => $request->input('description'),
            'description2'          => $request->input('description2'),
            'price'                 => $request->input('price'),
            'qty'                   => $request->input('qty'),
            'type'                  => $request->input('type'),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Successfull add data item invoice',
        ]);
    }

    public function updateItemInvoice(Request $request, $id)
    {
        $itemInvoice = D_Item_Invoice::where('id', $id)->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Successfull update data item invoice',
        ]);
    }

    public function updateInvoice(Request $request, $id)
    {
        $dataInvoice = D_Memo_Invoices::where('id', $id)->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Successfull update data invoice',
        ]);
    }

    public function deleteItemInvoice($id)
    {
        $itemInvoice = D_Item_Invoice::where('id', $id)->first();
        $itemInvoice->delete();

        return response()->json([
            'status' => 200,
            'message' => "Successfull delete item invoice."
        ]);
    }

    public function deleteDataInvoice($id)
    {
        $dataInvoice = D_Memo_Invoices::where('id', $id)->first();
        $dataInvoice->delete();

        $itemInvoices = D_Item_Invoice::where('id_invoice', $id)->delete();

        return response()->json([
            'status' => 200,
            'message' => "Successfull delete invoice."
        ]);
    }

    public function addInvoice($id)
    {
        $dataInvoice = D_Memo_Invoices::create([
            'no_invoice' => '',
            'id_memo' => $id,
            'ppn' => false,
            'npwp' => false,
            'grossup' => false,
            'pph' => 'none',
            'others' => '[]',
        ]);

        // $dataInvoices = D_Memo_Invoices::where('id',$id)->orderBy('created_at', 'asc')->get();

        return response()->json([
            'dataInvoice' => $dataInvoice,
            'status' => 200,
            'message' => 'Successfull add data invoice',
        ]);
    }
}
