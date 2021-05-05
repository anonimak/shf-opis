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
    Route::post('/employee/{id}/history', '\App\Http\Controllers\Admin\EmployeeController@empStore')->name('employee.history.store');
    Route::put('/employee/{id}/history/{idhistory}/update', '\App\Http\Controllers\Admin\EmployeeController@empUpdate')->name('employee.history.update');
    Route::delete('/employee/{id}/history/{idhistory}', '\App\Http\Controllers\Admin\EmployeeController@empDestroy')->name('employee.history.destroy');
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
});



Route::get('/', 'HomeController@index');

// Logout
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
