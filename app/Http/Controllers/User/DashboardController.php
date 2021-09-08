<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Synchronously
        return Inertia::render('User/Dashboard', [
            'meta' => [
                'title' => 'tests',
                'foo' => 'bar'
            ],
            'dataMemo' => Memo::where('status', '!=', 'edit')->orderBy('propose_at', 'DESC')->first(),
            '__create'  => 'user.memo.create',
            '__allmemo'  => 'user.memo.statusmemo.index',
        ]);
    }
}
