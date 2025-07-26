<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuperAdmin\EmployeeController;
use App\Http\Controllers\Admin\PMOperationsController;
use App\Http\Controllers\SuperAdmin\SuperAdminAttendanceController;
use App\Http\Controllers\MarketingClientController;
use App\Http\Controllers\SuperAdmin\ProjectController;
use App\Http\Controllers\SuperAdmin\ClientController;
use App\Http\Controllers\SuperAdmin\SuperDashController;
use Illuminate\Http\Request;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\SuperAdmin\AttendanceController;
use App\Http\Controllers\SuperAdmin\PasswordAdminController;
use App\Http\Controllers\SuperAdmin\ExpenseController;
use App\Http\Controllers\SuperAdmin\SalaryController;
use App\Http\Controllers\Developer\DeveloperController;



Route::get('/', function () {
    return redirect()->route('login');
});

//Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

//Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');



//Redirect based on roles
Route::get('/superadmin/dashboard', [SuperDashController::class, 'dashboard'])->name('superadmin.dashboard');
Route::get('/layouts/admin', fn() => view('layouts.admin'))->name('layouts.admin');
Route::get('/layouts/developer', fn() => view('layouts.developer'))->name('layouts.developer');
Route::get('/layouts/projectmanager', fn() => view('layouts.projectmanager'))->name('layouts.projectmanager');

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

//Mark Attendance employee- SuperAdmin
Route::get('/superadmin/attendance/index', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/superadmin/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

//View attendance filtered by date and month
Route::get('/admin/attendance/sheet', [AttendanceController::class, 'showSheet'])->name('attendance.sheet');

// Admin Dashboard Operations
Route::get('/admin/operations/logbook', [PMOperationsController::class, 'showLogForm'])->name('admin.operations.logbook');
Route::post('/admin/operations/logbook', [PMOperationsController::class, 'storeLog'])->name('admin.operations.logbook');

Route::get('/admin/operations/assign_task', [PMOperationsController::class, 'showAssignForm'])->name('admin.operations.assign_task');
Route::post('/admin/operations/assign_task', [PMOperationsController::class, 'assignTask'])->name('admin.operations.assign_task');

//Summary and charts of Attendance - Super admin
Route::prefix('superadmin/attendance')
      ->name('superadmin.attendance.')
      ->group(function () {

    //Employee–Month dashboard
    Route::get('/employee',
        [SuperAdminAttendanceController::class,'employeeMonth'])
        ->name('employee.month');

    //Single-employee PDF
    Route::get('/employee/pdf',
        [SuperAdminAttendanceController::class,'employeeMonthPdf'])
        ->name('employee.month.pdf');
});

//Digital Marketing Manager
Route::prefix('marketing')->group(function () {
    Route::get('/dashboard', function () {
        return view('marketing.dashboard');
    });


    Route::get('/marketing/dashboard', [MarketingClientController::class, 'dashboard'])->name('marketing.dashboard');



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
    //Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/clients/report', [MarketingClientController::class, 'report'])->name('marketing.clients.report');
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


//superadmin client details
Route::prefix('superadmin/marketing/clients')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('superadmin.clients.index');

    Route::post('/{client}/approve-permission', [ClientController::class, 'approvePermission'])->name('superadmin.clients.approve-permission');
    Route::post('/{client}/reject-permission', [ClientController::class, 'rejectPermission'])->name('superadmin.clients.reject-permission');
});

// routes/web.php
Route::get('superadmin/clients/create', [ClientController::class, 'create'])->name('superadmin.clients.create');
// routes/web.php
Route::post('superadmin/clients/store', [ClientController::class, 'store'])->name('superadmin.clients.store');



// Super Admin
Route::get('create',       [TaskController::class, 'create'])->name('tasks.create');
Route::post('store',       [TaskController::class, 'store'])->name('tasks.store');
Route::get('superadmin',   [TaskController::class, 'superadminIndex'])->name('tasks.superadmin');
Route::get('superadmin.tasks.index',   [TaskController::class, 'superadminIndex'])->name('superadmin.tasks.index');
Route::get('superadmin.tasks.create',   [TaskController::class, 'create'])->name('superadmin.tasks.create');

// Project Manager
Route::get('projectmanager.tasks.index/{pm}', [TaskController::class, 'projectManagerIndex'])->name('projectmanager.tasks.index');
Route::post('/projectmanager/tasks/{task}/forward', [TaskController::class, 'forwardToDeveloper'])->name('projectmanager.tasks.forward');
// Project Manager Task Routes
Route::prefix('projectmanager')->group(function () {
    Route::get('/projects', [TaskController::class, 'projectList'])->name('projectmanager.projects');
    Route::get('/projects/{project}/tasks', [TaskController::class, 'tasksByProject'])->name('projectmanager.projects.tasks');
    Route::post('/tasks/{task}/forward', [TaskController::class, 'forwardToDeveloper'])->name('projectmanager.tasks.forward');
});
 Route::get('/projectmanager/tasks', [TaskController::class, 'projectManagerIndex'])->name('projectmanager.tasks');

// Developer 
Route::get('developer.tasks.index/{dev}',    [TaskController::class, 'developerIndex'])->name('developer.tasks.index');
Route::post('developer.tasks/complete/{id}', [TaskController::class, 'complete'])->name('developer.tasks.complete');
Route::prefix('developer')->group(function() {
    Route::get('projects', [TaskController::class, 'developerProjectList'])->name('developer.projects.index');

    Route::get('projects/{project}/tasks', [TaskController::class, 'developerTasksByProject'])->name('developer.projects.tasks');

    Route::post('tasks/{task}/complete', [TaskController::class, 'markTaskCompleted'])->name('developer.tasks.complete');
});

//Task
Route::get('/superadmin/tasks', [TaskController::class, 'superadminIndex'])->name('superadmin.tasks');

/*PASSWORD MANAGEMENT (Super-Admin) */
Route::prefix('superadmin/password')
      ->name('superadmin.password.')
      ->group(function () {

    /*LIST – pick an employee to reset */
    Route::get('/reset',                 
        [PasswordAdminController::class,'listEmployees'])
        ->name('list');

    /*individual reset form & post */
    Route::get ('/reset/{profile}',  [PasswordAdminController::class,'editOther'])
         ->name('editOther');
    Route::post('/reset/{profile}', [PasswordAdminController::class,'updateOther'])
         ->name('updateOther');

    /*self-change routes */
    Route::get ('/change',  [PasswordAdminController::class,'editSelf'])->name('editSelf');
    Route::post('/change', [PasswordAdminController::class,'updateSelf'])->name('updateSelf');
});

                         
//add expenses in superadmin

Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
});

Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/salaries', [SalaryController::class, 'index'])->name('salary.index');
    Route::get('/salaries/create', [SalaryController::class, 'create'])->name('salary.create');
    Route::post('/salaries', [SalaryController::class, 'store'])->name('salary.store');
});

//Logout Developer
Route::post('/developer/logout', function (Request $request) {
    Auth::logout(); 
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('developer.logout');

//logout Project Manager
Route::post('/projectmanager/logout', function (Illuminate\Http\Request $request) {
    Auth::logout(); 
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('projectmanager.logout');


//Developer Dasboard 
Route::get('/developer/{id}/dashboard', [DeveloperController::class, 'dashboard'])->name('developer.dashboard');


Route::get('/developer/tasks', [TaskController::class, 'developerIndex'])->name('developer.tasks.index');
Route::post('/developer/tasks/{id}/complete', [TaskController::class, 'markAsCompleted'])->name('developer.tasks.complete');
Route::get('/developer/tasks', [TaskController::class, 'developerIndex'])->name('developer.tasks.index');
Route::post('/developer/tasks/{id}/complete', [TaskController::class, 'markAsCompleted'])->name('developer.tasks.complete');
