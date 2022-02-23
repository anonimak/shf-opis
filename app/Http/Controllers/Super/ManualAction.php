<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\D_Memo_Acknowledge;
use App\Models\Memo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class ManualAction extends Controller
{
    //

    public function sendEmailAfterApproveMemo($id)
    {

        $memo = Memo::where('id', $id)->with('proposeemployee')->first();

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
        return Redirect::route('super.dashboard')->with('success', "Successfull Send Email After Approve Manual, id memo $id.");
    }
}
