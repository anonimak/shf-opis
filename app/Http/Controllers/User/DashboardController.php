<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\D_Memo_Approver;
use App\Models\D_Memo_History;
use App\Models\Maintenance;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $dataMemo = Memo::where('status', '!=', 'edit')->where('id_employee', auth()->user()->id_employee)->orderBy('propose_at', 'DESC')->with('latestHistory')->with(['histories' => function ($history) {
            return $history->orderBy('id', 'DESC');
        }])->first();

        $dataMemoApproved = D_Memo_Approver::where('status', '!=', 'submit')->where('status','!=', 'edit')
            ->orderBy('updated_at', 'DESC')
            ->where('id_employee', auth()->user()->id_employee)
            ->with(['memo' => function ($memo) {
                return $memo->with('latestHistory')
                    ->with(['histories' => function ($history) {
                        return $history->orderBy('id', 'DESC');
                    }]);
            }])->first();

        // Synchronously
        return Inertia::render('User/Dashboard', [
            'meta' => [
                'title' => 'tests',
                'foo' => 'bar'
            ],
            'dataMemo' => $dataMemo,
            'dataMemoApproved' => $dataMemoApproved,
            'dataMaintenances' => Maintenance::getMsgMaintenanceShow(),
            '__create'  => 'user.memo.create',
            '__allmemo'  => 'user.memo.statusmemo.index',
            '__allmemoapproval' => 'user.memo.approval.memo.index'
        ]);
    }

    public function linkstorage()
    {
        Artisan::call('storage:link');
    }
}
