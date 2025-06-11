<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuperAdmin\EmployeeController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\PMOperationsController;
use App\Http\Controllers\SuperAdmin\SuperAdminAttendanceController;
use App\Http\Controllers\MarketingClientController;
use App\Http\Controllers\SuperAdmin\ProjectController;


Route::get('/', function () {
   return redirect()->route('login');
});

//Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

//Redirect based on roles
Route::get('/superadmin/dashboard', fn() => view('superadmin.superdash'))->name('superadmin.dashboard');
Route::get('/layouts/admin', fn() => view('layouts.admin'))->name('layouts.admin');
Route::get('/developer/dashboard', fn() => view('dashboards.developer'))->name('developer.dashboard');


//profile for employee
Route::get('/layouts/admin', [ProfileController::class, 'dashboard'])->name('layouts.admin');
Route::get('/admin/profiles/create', [ProfileController::class, 'create'])->name('profile.create');
Route::post('/admin/profiles/store', [ProfileController::class, 'store'])->name('profile.store');
Route::get('/admin/profile', [ProfileController::class, 'index'])->name('profiles.index');
Route::get('/admin/profiles', [ProfileController::class, 'index'])->name('profile.index');

Route::get('/admin/profiles/{id}', [ProfileController::class, 'show'])->name('profile.show');

//Add employee
Route::get('/superadmin/employee/create', [EmployeeController::class, 'create'])->name('superadmin.employee.create');
Route::post('/superadmin/employee/store', [EmployeeController::class, 'store'])->name('employee.store');

//View employee list/ Delete/Edit
Route::get('/superadmin/employee', [EmployeeController::class, 'index'])->name('superadmin.employee.index');
Route::get('/superadmin/employee/{id}', [EmployeeController::class, 'show'])->name('superadmin.employee.show');
Route::get('/superadmin/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('superadmin.employee.edit');
Route::put('/superadmin/employee/{id}', [EmployeeController::class, 'update'])->name('superadmin.employee.update');
Route::delete('/superadmin/employee/{id}', [EmployeeController::class, 'destroy'])->name('superadmin.employee.destroy');

//Mark Attendance employee- Admin
Route::get('/admin/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/admin/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

//View attendance filtered by date and month
Route::get('/admin/attendance/sheet', [AttendanceController::class, 'showSheet'])->name('attendance.sheet');

// Admin Dashboard Operations
    Route::get('/admin/operations/logbook', [PMOperationsController::class, 'showLogForm'])->name('admin.operations.logbook');
    Route::post('/admin/operations/logbook', [PMOperationsController::class, 'storeLog'])->name('admin.operations.logbook');

    Route::get('/admin/operations/assign_task', [PMOperationsController::class, 'showAssignForm'])->name('admin.operations.assign_task');
    Route::post('/admin/operations/assign_task', [PMOperationsController::class, 'assignTask'])->name('admin.operations.assign_task');

//Summary and charts of Attendance - Super admin
Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/attendance', [SuperAdminAttendanceController::class, 'index'])->name('employee.attendance.index');
    Route::get('/attendance/download', [SuperAdminAttendanceController::class, 'downloadPdf'])->name('employee.attendance.pdf');
});

//Digital Marketing Manager
Route::prefix('marketing')->group(function () {
    Route::get('/dashboard', function () {
        return view('marketing.dashboard');
    });


    Route::get('/clients', [MarketingClientController::class, 'index'])->name('marketing.clients.index');
    // Show create form
    Route::get('/clients/create', [MarketingClientController::class, 'create'])->name('marketing.clients.create');

    // Store new client
    Route::post('/clients', [MarketingClientController::class, 'store'])->name('marketing.clients.store');

    // Show edit form
    Route::get('/clients/{client}/edit', [MarketingClientController::class, 'edit'])->name('marketing.clients.edit');

    // Update client
    Route::put('/clients/{client}', [MarketingClientController::class, 'update'])->name('marketing.clients.update');

   // Delete (already added earlier)
    Route::delete('/clients/{client}', [MarketingClientController::class, 'destroy'])->name('marketing.clients.destroy');

    Route::get('/clients/status/{type}', [MarketingClientController::class, 'status'])->name('marketing.clients.status');


    Route::get('/clients/reminders', [MarketingClientController::class, 'reminders'])->name('marketing.clients.reminders');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

});

Route::prefix('superadmin/project')->name('superadmin.project.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/create', [ProjectController::class, 'create'])->name('create');
    Route::post('/store', [ProjectController::class, 'store'])->name('store');

    // Financials
    Route::get('/{project}/financials/create', [ProjectController::class, 'createFinancials'])->name('financials.create');
    Route::post('/financials/store', [ProjectController::class, 'storeFinancials'])->name('financials.store');
    
    //View transactions
    Route::get('/transactions', [ProjectController::class, 'transactions'])->name('transactions');
    Route::get('/transactions/download-pdf', [ProjectController::class, 'downloadPdf'])->name('transactions.downloadPdf');

    Route::get('/financials/{account}/edit', [ProjectController::class, 'editFinancials'])->name('financials.edit');
    Route::put('/financials/{account}', [ProjectController::class, 'updateFinancials'])->name('financials.update');
    Route::delete('/financials/{account}', [ProjectController::class, 'destroyFinancials'])->name('financials.destroy');

});

