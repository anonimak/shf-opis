<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();
// authentication routes
Auth::routes();

/*
|
| admin routes
|
|
*/
Route::middleware('auth', 'is_admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', 'Admin\DashboardController@index')
        ->name('dashboard');

    Route::resource('/branch', '\App\Http\Controllers\Admin\BranchController');
});

Route::get('/', 'HomeController@index');

// Logout
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
