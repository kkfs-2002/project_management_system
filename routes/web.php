<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuperAdmin\EmployeeController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\PMOperationsController;

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



