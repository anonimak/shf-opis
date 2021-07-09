<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
            ]
        ]);
    }
}
