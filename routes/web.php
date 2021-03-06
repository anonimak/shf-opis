<?php

use Illuminate\Http\Request;
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
    // terminate employee
    Route::put('/{id}/terminate', '\App\Http\Controllers\Admin\EmployeeController@terminateEmployee')->prefix('/employee')->name('employee.terminate');
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
    Route::resource('/maintenance', 'Super\MaintenanceController');
    Route::resource('/memo_management', 'Super\MemoManagement');
    // Route::resource('/ref_template_memo', 'Super\RefTemplateMemo');
    Route::prefix('/ref_template_memo')->name('ref_template_memo.')->group(function () {
        Route::get('/{id_type_memo}', 'Super\RefTemplateMemo@index')->name('index');
        Route::post('/{id_type_memo}', 'Super\RefTemplateMemo@storeTemplateCost')->name('store_template_cost');
        Route::put('/{id_type_memo}', 'Super\RefTemplateMemo@updateTemplateCost')->name('update_template_cost');
        Route::delete('/{template_memo}', 'Super\RefTemplateMemo@destroyTemplateCost')->name('destroy_template_cost');
    });

    Route::put('/{id_type_memo}/update-status', 'Super\RefTypeMemo@updateStatus')->name('update_status');

    // manual action
    Route::prefix('/action')->name('action.')->group(function () {
        // send email to after approver
        Route::get('/email-after-approve-memo/{id_memo}', 'Super\ManualAction@sendEmailAfterApproveMemo')->name('email_after_approve_memo');
    });

    Route::prefix('/api')->name('api.')->group(function () {
        Route::prefix('/employee')->name('employee.')->group(function () {
            Route::get('/position', 'User\ApiMemoController@getPositionNow')->name('positions');
        });
        Route::prefix('/memo')->name('memo.')->group(function () {
            Route::get('{id}/ref-type-memo', 'User\ApiMemoController@getTypeMemoByIdMemo')->name('type_memo');
        });
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
            Route::post('/{memo}/auto-save', 'User\MemoController@itemAutoSave')->name('itemAutoSave');
            Route::post('/{memo}/auto-save-cost', 'User\MemoController@itemAutoSaveCost')->name('itemAutoSaveCost');
            Route::post('/{memo}/acknowledge/{type}', 'User\MemoController@updateAcknowledge')->name('updateacknowledge');
            Route::delete('/{memo}/acknowledge/{id_employee}/{type}', 'User\MemoController@deleteAcknowledge')->name('deleteacknowledge');
            Route::get('/{memo}/preview', 'User\MemoController@previewMemo')->name('preview');
            Route::get('/{memo}/preview-payment', 'User\MemoController@previewPayment')->name('previewpayment');
        });

        Route::prefix('/status-memo')->name('statusmemo.')->group(function () {
            Route::get('/', 'User\MemoController@index')->name('index');
            Route::get('/{memo}/form-payment', 'User\MemoController@formPayment')->name('formpayment');
            // Route::put('/{id}/addpayment','User\MemoController@paymentStore')->name('storepayment');
            Route::delete('/{id}/payment', 'User\MemoController@deletePayment')->name('deletepayment');
            Route::put('/{id}/payment/{idpayment}/update', 'User\MemoController@updatePayment')->name('updatepayment');
            Route::put('/{memo}/proposepayment', 'User\MemoController@proposePayment')->name('proposepayment');
            Route::put('/{memo}/proposepo', 'User\MemoController@proposePo')->name('proposepo');
            Route::get('/{memo}/preview', 'User\MemoController@webpreviewMemo')->name('webpreview');
            Route::get('/{memo}/preview-pdf', 'User\MemoController@previewMemo')->name('preview');
            Route::get('/{memo}/senddraft', 'User\MemoController@senddraft')->name('senddraft');
        });

        Route::prefix('/status-memo-takeover-branch')->name('statustakeovermemobranch.')->group(function () {
            Route::get('/', 'User\MemoController@indexTakeoverBranch')->name('index');
            Route::delete('/{id}/payment', 'User\MemoController@deletePayment')->name('deletepayment');
            Route::get('/{memo}/form-payment', 'User\MemoController@formPayment')->name('formpayment');
            Route::put('/{id}/payment/{idpayment}/update', 'User\MemoController@updatePayment')->name('updatepayment');
            Route::get('/{memo}/preview', 'User\MemoController@webpreviewMemoTakeover')->name('webpreview');
            Route::get('/{memo}/preview-pfd', 'User\MemoController@previewMemo')->name('preview');
            Route::put('/{memo}/proposepayment', 'User\MemoController@proposePayment')->name('proposepayment');
            Route::get('/{memo}/senddraft', 'User\MemoController@senddraft')->name('senddraft');
        });

        Route::prefix('/confirm-payment')->name('confirmpayment.')->group(function () {
            Route::get('/', 'User\ConfirmPaymentController@index')->name('index');
            Route::get('/{memo}/preview', 'User\ConfirmPaymentController@detailPayment')->name('webpreview');
            Route::get('/{memo}/preview-pdf', 'User\ConfirmPaymentController@previewPDF')->name('preview');
            Route::put('/{memo}/confirm-payment/{id}', 'User\ConfirmPaymentController@confirmingPayment')->name('confirming');
        });

        Route::prefix('/status-payment')->name('statuspayment.')->group(function () {
            Route::get('/', 'User\MemoController@indexPayment')->name('index');
            Route::get('/{memo}/form-payment', 'User\MemoController@formPayment')->name('formpayment');
            Route::get('/{memo}/preview', 'User\MemoController@webpreviewPayment')->name('webpreview');
            Route::get('/{memo}/preview-pdf', 'User\MemoController@previewPayment')->name('preview');
            Route::get('/{memo}/send-draft-payment', 'User\MemoController@sendDraftPayment')->name('senddraft');
        });

        Route::prefix('/status-payment-takeover-branch')->name('statustakeoverpaymentbranch.')->group(function () {
            Route::get('/', 'User\MemoController@indexPaymentTakeoverBranch')->name('index');
            Route::get('/{memo}/form-payment', 'User\MemoController@formPayment')->name('formpayment');
            Route::get('/{memo}/preview', 'User\MemoController@webpreviewPaymentTakeoverBranch')->name('webpreview');
            Route::get('/{memo}/preview-pdf', 'User\MemoController@previewPaymentTakeoverBranch')->name('preview');
            // Route::get('/{memo}/preview-memo-pdf', 'User\MemoController@previewMemo')->name('previewmemo');
        });

        Route::prefix('/status-po')->name('statuspo.')->group(function () {
            Route::get('/', 'User\MemoController@indexPo')->name('index');
            Route::get('/{memo}/preview', 'User\MemoController@webpreviewPo')->name('webpreview');
            Route::get('/{memo}/preview-pdf', 'User\MemoController@previewPo')->name('preview');
        });


        Route::prefix('/approval')->name('approval.')->group(function () {
            Route::prefix('/memo')->name('memo.')->group(function () {
                Route::get('/', 'User\ApprovalController@index')->name('index');
                Route::get('/{memo}', 'User\ApprovalController@detail')->name('detail');
                Route::put('/{memo}', 'User\ApprovalController@approving')->name('approving');
                Route::get('/{memo}/preview', 'User\MemoController@previewMemo')->name('preview');
            });

            Route::prefix('/payment')->name('payment.')->group(function () {
                Route::get('/', 'User\ApprovalController@indexApprovalPayment')->name('index');
                Route::get('/{memo}', 'User\ApprovalController@detailPayment')->name('detail');
                Route::get('/{memo}/preview-pdf', 'User\MemoController@previewMemo')->name('previewpdfapproval');
                Route::put('/{memo}', 'User\ApprovalController@approvingPayment')->name('approving');
                Route::get('/{memo}/preview', 'User\MemoController@previewPayment')->name('preview');
            });

            Route::prefix('/po')->name('po.')->group(function () {
                Route::get('/', 'User\ApprovalController@indexApprovalPo')->name('index');
                Route::get('/{memo}', 'User\ApprovalController@detailPo')->name('detail');
                Route::put('/{memo}', 'User\ApprovalController@approvingPo')->name('approving');
                Route::get('/{memo}/preview', 'User\MemoController@previewPo')->name('preview');
            });
        });
    });

    // setting route
    Route::prefix('/setting')->name('setting.')->group(function () {
        Route::prefix('/change-password')->name('changepassword.')->group(function () {
            Route::get('/', 'User\SettingController@indexChangePassword')->name('index');
            Route::put('/', 'User\SettingController@ChangePassword')->name('update');
        });
    });

    Route::get('/test', 'User\MemoController@test')->name('test');

    // api
    Route::prefix('/api')->name('api.')->group(function () {
        Route::prefix('/memo')->name('memo.')->group(function () {
            Route::get('/{memo}/approvers', 'User\ApiMemoController@getApproversByIdMemo')->name('approvers');
        });
        Route::prefix('/po')->name('po.')->group(function () {
            Route::get('/{id_memo}/approvers', 'User\ApiPoController@getApproversByIdMemo')->name('approvers');
            Route::post('/{id_memo}/approvers-po', 'User\ApiPoController@updateApprover')->name('updateapprover');
        });
        Route::prefix('/payment')->name('payment.')->group(function () {
            Route::get('/{id_memo}/approvers', 'User\ApiPaymentController@getApproversByIdMemo')->name('approvers');
            Route::get('/{id_memo}/data', 'User\ApiPaymentController@getPaymentsByIdMemo')->name('datapayments');
            Route::put('/{id}/addpayment', 'User\ApiPaymentController@paymentStore')->name('storepayment');
            Route::post('/{id_memo}/approvers-payment', 'User\ApiPaymentController@updateApprover')->name('updateapprover');
        });

        Route::prefix('/invoice')->name('invoice.')->group(function () {
            Route::get('/{id_memo}/invoice', 'User\ApiMemoController@getInvoicesByIdMemo')->name('datainvoices');
            Route::post('/data-invoice', 'User\ApiMemoController@addItemInvoice')->name('additeminvoice');
            Route::post('{id_memo}/data-invoice', 'User\ApiMemoController@addInvoice')->name('addinvoice');
            Route::put('/update-item-invoice/{id_invoice}', 'User\ApiMemoController@updateItemInvoice')->name('updateiteminvoice');
            Route::put('/update-data-invoice/{id_invoice}', 'User\ApiMemoController@updateInvoice')->name('updateinvoice');
            Route::delete('/delete-item-invoice/{id_item}', 'User\ApiMemoController@deleteItemInvoice')->name('deleteiteminvoice');
            Route::delete('/delete-data-invoice/{id_invoice}', 'User\ApiMemoController@deleteDataInvoice')->name('deletedatainvoice');
        });
        Route::prefix('/employee')->name('employee.')->group(function () {
            Route::get('/position', 'User\ApiMemoController@getPositionNow')->name('positions');
        });



        // notification
        Route::prefix('/notification')->name('notification.')->group(function () {
            Route::get('/read/{id_notification}', 'User\ApiNotificationController@markAsRead')->name('read');
        });
    });
});

Route::get('/', 'HomeController@index');

// route check PO & Memo
Route::get('/check-memo/{doc_no?}', 'CheckMemoController@checkMemo');
Route::get('/check-po/{po_no?}', 'CheckMemoController@checkPO');
Route::get('/check-memo-payment/{doc_no?}', 'CheckMemoController@checkMemoPayment');

Route::get('/linkstorage', 'User\DashboardController@linkstorage');

Route::prefix('/forget-password')->name('forget-password.')->group(function () {
    Route::get('/', 'Auth\CustomForgotPasswordController@getEmail')->name('request');
    Route::post('/', 'Auth\CustomForgotPasswordController@postEmail')->name('email');
    Route::get('/reset-password/{token}', 'Auth\CustomResetPasswordController@getPassword')->name('reset');
    Route::post('/reset-password', 'Auth\CustomResetPasswordController@updatePassword')->name('update');
});

// Logout
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
