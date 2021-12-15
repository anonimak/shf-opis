<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckMemoController extends Controller
{
    public function checkMemo(Request $request, $base64memo = null)
    {
        $memo = Memo::where('doc_no', base64_decode($base64memo))->first();
        return Inertia::render('CheckMemo', [
            'dataMemo' => $memo
        ]);
    }

    public function checkPO(Request $request, $base64po = null)
    {
        $memo = Memo::where('po_no', base64_decode($base64po))->first();
        return Inertia::render('CheckMemo/PO', [
            'dataMemo' => $memo
        ]);
    }

    public function checkMemoPayment(Request $request, $base64memo = null)
    {
        $memo = Memo::where('doc_no', base64_decode($base64memo))->first();
        return Inertia::render('CheckMemo/Payment', [
            'dataMemo' => $memo
        ]);
    }
}
