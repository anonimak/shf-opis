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
    Route::resource('/department', '\App\Http\Controllers\Admin\DepartmentController');
    Route::resource('/employee', '\App\Http\Controllers\Admin\EmployeeController');
    // Employee History
    Route::prefix('/employee')->name('employee.history.')->group(function () {
        Route::post('/{id}/history', '\App\Http\Controllers\Admin\EmployeeController@empStore')->name('store');
        Route::put('/{id}/history/{idhistory}/update', '\App\Http\Controllers\Admin\EmployeeController@empUpdate')->name('update');
        Route::delete('/{id}/history/{idhistory}', '\App\Http\Controllers\Admin\EmployeeController@empDestroy')->name('destroy');
    });
    // Route importexcel
    Route::post('/employee/importexcel', '\App\Http\Controllers\Admin\EmployeeController@importexcel')->name('employee.importexcel');
});

/*
|
| super routes
|
|
*/
Route::middleware('auth', 'is_super')->prefix('superadmin')->name('super.')->group(function () {
    Route::get('/dashboard', 'Super\DashboardController@index')
        ->name('dashboard');
    Route::resource('/user', 'Super\UserManagement');
    Route::resource('/ref_position', 'Super\RefPosition');
    Route::resource('/ref_title', 'Super\RefTitle');
    Route::resource('/ref_approver', 'Super\RefModuleApprover');
    Route::resource('/ref_type_memo', 'Super\RefTypeMemo');
});

/*
|
| user routes
|
|
*/
Route::middleware('auth', 'is_user')->name('user.')->group(function () {
    Route::get('/dashboard', 'User\DashboardController@index')->name('dashboard');
    Route::prefix('/memo')->name('memo.')->group(function () {
        Route::get('/index', 'User\MemoController@index')->name('index');
        Route::get('/create', 'User\MemoController@create')->name('create');
        Route::post('/store', 'User\MemoController@store')->name('store');

        Route::prefix('/draft')->name('draft.')->group(function () {
            Route::get('/', 'User\MemoController@draft')->name('index');
            Route::get('/{memo}', 'User\MemoController@draftEdit')->name('edit');
        });
    });

    Route::get('/test', 'User\MemoController@test')->name('test');
});

Route::get('/', 'HomeController@index');

// Logout
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
