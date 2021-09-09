<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\D_Memo_History;
use App\Models\Memo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $dataMemo = Memo::where('status', '!=', 'edit')->where('id_employee', auth()->user()->id_employee)->orderBy('propose_at', 'DESC')->with(['history' => function ($history) {
            return $history->orderBy('id', 'DESC')->first();
        }])->with(['histories' => function ($history) {
            return $history->orderBy('id', 'DESC');
        }])->first();

        // Synchronously
        return Inertia::render('User/Dashboard', [
            'meta' => [
                'title' => 'tests',
                'foo' => 'bar'
            ],
            'dataMemo' => $dataMemo,
            '__create'  => 'user.memo.create',
            '__allmemo'  => 'user.memo.statusmemo.index',
        ]);
    }
}
