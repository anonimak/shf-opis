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
    // Route::resource('/ref_template_memo', 'Super\RefTemplateMemo');
    Route::prefix('/ref_template_memo')->name('ref_template_memo.')->group(function () {
        Route::get('/{id_type_memo}', 'Super\RefTemplateMemo@index')->name('index');
        Route::post('/{id_type_memo}', 'Super\RefTemplateMemo@storeTemplateCost')->name('store_template_cost');
        Route::put('/{id_type_memo}', 'Super\RefTemplateMemo@updateTemplateCost')->name('update_template_cost');
        Route::delete('/{template_memo}', 'Super\RefTemplateMemo@destroyTemplateCost')->name('destroy_template_cost');
    });
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
            Route::post('/{memo}', 'User\MemoController@draftUpdate')->name('update');
            Route::delete('/{memo}', 'User\MemoController@destroy')->name('destroy');
            Route::put('/{memo}/propose', 'User\MemoController@propose')->name('propose');
            Route::post('/{memo}/attachment', 'User\MemoController@fileUploadAttach')->name('attachment');
            Route::delete('/{memo}/attachment', 'User\MemoController@destroyAttach')->name('attachmentremove');
            Route::post('/{memo}/approver', 'User\MemoController@updateApprover')->name('updateapprover');
            Route::post('/{memo}/acknowledge', 'User\MemoController@updateAcknowledge')->name('updateacknowledge');
            Route::get('/{memo}/preview', 'User\MemoController@previewMemo')->name('preview');
        });

        Route::prefix('/status-memo')->name('statusmemo.')->group(function () {
            Route::get('/', 'User\MemoController@index')->name('index');
            //Route::post('/{id}','User\MemoController@paymentStore')->name('storepayment');
            //Route::post('/{memo}/approverpayment', 'User\MemoController@updateApproverPayment')->name('updateapproverpayment');
            //Route::post('/{memo}/acknowledgepayment', 'User\MemoController@updateAcknowledgePayment')->name('updateacknowledgePayment');
            Route::put('/{memo}/proposepayment', 'User\MemoController@proposePayment')->name('proposepayment');
            Route::get('/{memo}/preview', 'User\MemoController@webpreviewMemo')->name('webpreview');
            Route::get('/{memo}/senddraft', 'User\MemoController@senddraft')->name('senddraft');
        });

        Route::prefix('/status-payment')->name('statuspayment.')->group(function () {
            Route::get('/', 'User\MemoController@indexPayment')->name('index');
            Route::get('/{memo}/preview', 'User\MemoController@webpreviewPayment')->name('webpreview');
        });


        Route::prefix('/approval')->name('approval.')->group(function () {
            Route::get('/', 'User\ApprovalController@index')->name('index');
            Route::get('/{memo}', 'User\ApprovalController@detail')->name('detail');
            Route::put('/{memo}', 'User\ApprovalController@approving')->name('approving');
            Route::get('/{memo}/preview', 'User\MemoController@previewMemo')->name('preview');
        });

        Route::prefix('/approval-payment')->name('approvalpayment.')->group(function () {
            Route::get('/', 'User\ApprovalController@indexApprovalPayment')->name('index');
            Route::get('/{memo}', 'User\ApprovalController@detailPayment')->name('detail');
            Route::put('/{memo}', 'User\ApprovalController@approvingPayment')->name('approving');
            Route::get('/{memo}/preview', 'User\MemoController@previewPayment')->name('preview');
        });
    });

    Route::get('/test', 'User\MemoController@test')->name('test');
});

Route::get('/', 'HomeController@index');

Route::get('/linkstorage', 'User\DashboardController@linkstorage');

// Logout
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
