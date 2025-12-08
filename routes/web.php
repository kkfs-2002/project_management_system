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
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SuperAdmin\PasswordAdminController;
use App\Http\Controllers\SuperAdmin\ExpenseController;
use App\Http\Controllers\SuperAdmin\SalaryController;
use App\Http\Controllers\SuperAdmin\DailyTaskController;
use App\Http\Controllers\SuperAdmin\KpiController;
use App\Http\Controllers\Developer\DeveloperController;
use App\Http\Controllers\SuperAdmin\WhatsAppController;
use App\Http\Controllers\Marketing\MarketingWhatsAppController;
use App\Http\Controllers\ProjectManager\ProjectManagerController;

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
// View employee page
Route::get('/superadmin/employee/view', [EmployeeController::class, 'view'])->name('superadmin.employee.view');

//View employee list/ Delete/Edit
Route::get('/superadmin/employee', [EmployeeController::class, 'index'])->name('superadmin.employee.index');
Route::get('/superadmin/employee/{id}', [EmployeeController::class, 'show'])->name('superadmin.employee.show');
Route::get('/superadmin/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('superadmin.employee.edit');
Route::put('/superadmin/employee/{id}', [EmployeeController::class, 'update'])->name('superadmin.employee.update');
Route::delete('/superadmin/employee/{id}', [EmployeeController::class, 'destroy'])->name('superadmin.employee.destroy');

//Mark Attendance employee- SuperAdmin
Route::get('/superadmin/attendance/developer', [AttendanceController::class, 'developer'])->name('attendance.developer');
Route::get('/superadmin/attendance/marketingmanager', [AttendanceController::class, 'marketingmanager'])->name('attendance.marketingmanager');
Route::get('/superadmin/attendance/projectmanager', [AttendanceController::class, 'projectmanager'])->name('attendance.projectmanager');
Route::get('/superadmin/attendance/export', [AttendanceController::class, 'export'])->name('superadmin.attendance.export');
// Attendance API routes
Route::get('/superadmin/attendance/{id}/details', [AttendanceController::class, 'getAttendanceDetails'])
    ->name('attendance.details');
    // Attendance actions routes
Route::post('/superadmin/attendance/{id}/checkout', [SuperAdminAttendanceController::class, 'markAsCheckedOut'])
    ->name('attendance.mark.checkout');
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




// ===============================
// DIGITAL MARKETING MANAGER ROUTES
// ===============================
Route::middleware('auth')->prefix('marketing')->name('marketing.')->group(function () {

    // --- DASHBOARD ---
    Route::get('/dashboard', [MarketingClientController::class, 'dashboard'])
        ->name('dashboard');
        // Marketing manager routes
Route::get('/marketing/salary', [MarketingClientController::class, 'salaryIndex'])
    ->name('marketing.salary.index');

// Project manager routes  
Route::get('/projectmanager/{id}/salary', [ProjectManagerController::class, 'salaryIndex'])
    ->name('projectmanager.salary.index');

    // --- ATTENDANCE ROUTES ---
    Route::post('/attendance/checkin', [AttendanceController::class, 'checkIn'])
        ->name('attendance.checkin');

    Route::post('/attendance/checkout', [AttendanceController::class, 'checkOut'])
        ->name('attendance.checkout');

    Route::get('/attendance/history', [AttendanceController::class, 'marketingHistory'])
        ->name('attendance.history');

    // --- CLIENT MANAGEMENT ROUTES ---
    Route::get('/clients', [MarketingClientController::class, 'index'])
        ->name('clients.index');

    Route::get('/clients/create', [MarketingClientController::class, 'create'])
        ->name('clients.create');

    Route::post('/clients', [MarketingClientController::class, 'store'])
        ->name('clients.store');

    Route::get('/clients/{client}/edit', [MarketingClientController::class, 'edit'])
        ->name('clients.edit');

    Route::put('/clients/{client}', [MarketingClientController::class, 'update'])
        ->name('clients.update');

    Route::delete('/clients/{client}', [MarketingClientController::class, 'destroy'])
        ->name('clients.destroy');

    Route::get('/clients/status/{type}', [MarketingClientController::class, 'status'])
        ->name('clients.status');

    Route::get('/clients/reminders', [MarketingClientController::class, 'reminders'])
        ->name('clients.reminders');

    Route::get('/clients/report', [MarketingClientController::class, 'report'])
        ->name('clients.report');

});


Route::prefix('superadmin/project')->name('superadmin.project.')->group(function () {
    // Existing routes
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/create', [ProjectController::class, 'create'])->name('create');
    Route::post('/store', [ProjectController::class, 'store'])->name('store');
    


// Project manager routes  
Route::get('/projectmanager/{id}/salary', [ProjectManagerController::class, 'salaryIndex'])
    ->name('projectmanager.salary.index');
    
    // Monthly Profit Routes (FIXED)
    Route::get('/monthly-profit', [ProjectController::class, 'monthlyProfit'])->name('monthly-profit');
    Route::get('/monthly-profit/download-pdf', [ProjectController::class, 'downloadMonthlyPdf'])->name('download-monthly-pdf');
    
    // Yearly Profit Routes (FIXED)
    Route::get('/yearly-profit', [ProjectController::class, 'yearlyProfit'])->name('yearly-profit');
    Route::get('/yearly-profit/download-pdf', [ProjectController::class, 'downloadYearlyPdf'])->name('download-yearly-pdf');

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
Route::get('superadmin.tasks.add',   [TaskController::class, 'add'])->name('superadmin.tasks.add');

// Project Manager
Route::get('projectmanager.tasks.index/{pm}', [TaskController::class, 'projectManagerIndex'])->name('projectmanager.tasks.index');
Route::post('/projectmanager/tasks/{task}/forward', [TaskController::class, 'forwardToDeveloper'])->name('projectmanager.tasks.forward');
// Project Manager Routes
Route::middleware('auth')->prefix('projectmanager')->name('projectmanager.')->group(function () {
    
    // ===== ATTENDANCE ROUTES =====
    Route::post('/attendance/checkin', [AttendanceController::class, 'checkIn'])
        ->name('attendance.checkin');
    
    Route::post('/attendance/checkout', [AttendanceController::class, 'checkOut'])
        ->name('attendance.checkout');
    
    Route::get('/attendance/history', [AttendanceController::class, 'history'])
        ->name('attendance.history');

        
    
    // ===== TASK/PROJECT ROUTES =====
    // Consolidated tasks index (no {pm} for general; add below if needed)
    Route::get('/tasks', [TaskController::class, 'projectManagerIndex'])->name('tasks.index');
    
    // If {pm} param is still needed (e.g., for specific PM filtering), add this:
    Route::get('/tasks/index/{pm}', [TaskController::class, 'projectManagerIndex'])->name('tasks.index.pm');
    
    Route::get('/projects', [TaskController::class, 'projectList'])->name('projects');
    Route::get('/projects/{project}/tasks', [TaskController::class, 'tasksByProject'])->name('projects.tasks');
    Route::post('/tasks/{task}/forward', [TaskController::class, 'forwardToDeveloper'])->name('tasks.forward');
    
});
// Developer 
Route::get('developer.tasks.index/{dev}',    [TaskController::class, 'developerIndex'])->name('developer.tasks.index');
Route::post('developer.tasks/complete/{id}', [TaskController::class, 'complete'])->name('developer.tasks.complete');
Route::prefix('developer')->group(function() {
    Route::get('projects', [TaskController::class, 'developerProjectList'])->name('developer.projects.index');

    Route::get('projects/{project}/tasks', [TaskController::class, 'developerTasksByProject'])->name('developer.projects.tasks');

    Route::post('tasks/{task}/complete', [TaskController::class, 'markAsCompleted'])->name('developer.tasks.complete');
});
//Developer Dasboard 
Route::get('/developer/{id}/dashboard', [DeveloperController::class, 'dashboard'])->name('developer.dashboard');


   Route::get('/developer/salary-history', [DeveloperController::class, 'salaryHistory'])
        ->name('developer.salary.history');  


// Developer Routes
Route::middleware('auth')->prefix('developer')->name('developer.')->group(function () {
    
    // ===== DASHBOARD =====
    Route::get('/dashboard', [DeveloperController::class, 'dashboard'])->name('dashboard');

   
    // ===== ATTENDANCE ROUTES =====
    Route::post('/attendance/checkin', [AttendanceController::class, 'developerCheckIn'])
        ->name('attendance.checkin');
    
    Route::post('/attendance/checkout', [AttendanceController::class, 'developerCheckOut'])
        ->name('attendance.checkout');
    
    Route::get('/attendance/history', [AttendanceController::class, 'developerHistory'])
        ->name('attendance.history');



    Route::get('/attendance/marketingmanager', [AttendanceController::class, 'marketingmanager'])
        ->name('attendance.marketingmanager');
    
    Route::get('/attendance/{id}/details', [AttendanceController::class, 'getAttendanceDetails'])
        ->name('attendance.details');
    
   Route::get('/attendance/marketing/export', [AttendanceController::class, 'exportMarketingAttendance'])
    ->name('attendance.export.marketing');

    

    // ===== TASK ROUTES =====
    Route::get('/tasks', [TaskController::class, 'developerIndex'])->name('tasks.index');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    
    // ===== DAILY TASKS ROUTES =====
    Route::get('/daily-tasks', [DailyTaskController::class, 'index'])->name('daily-tasks.index');
    Route::get('/daily-tasks/{task}', [DailyTaskController::class, 'show'])->name('daily-tasks.show');
    
    // ===== LOGOUT =====
    Route::post('/logout', [DeveloperController::class, 'logout'])->name('logout');
});
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
      Route::get('/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
       Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('expenses/pdf', [ExpenseController::class, 'downloadPdf'])->name('expenses.pdf');
});

Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/salaries', [SalaryController::class, 'index'])->name('salary.index');
    Route::get('/salaries/create', [SalaryController::class, 'create'])->name('salary.create');
    Route::post('/salaries', [SalaryController::class, 'store'])->name('salary.store');
    Route::get('/salaries/{id}', [SalaryController::class, 'show'])->name('salary.show');
    
    // මේක ADD කරන්න ↓↓↓
    Route::delete('/salaries/{id}', [SalaryController::class, 'destroy'])->name('salary.destroy');
      Route::get('/salaries/{id}/edit', [SalaryController::class, 'edit'])->name('salary.edit');
    Route::put('/salaries/{id}', [SalaryController::class, 'update'])->name('salary.update');
    
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

//Project manager dashboard
Route::get('/projectmanager/{id}/dashboard', [ProjectManagerController::class, 'dashboard'])
    ->name('projectmanager.dashboard');
    

Route::post('/tasks/{id}/complete', [TaskController::class, 'markAsCompleted']);

Route::post('/marketing/clients/{client}/confirm', [MarketingClientController::class, 'confirm'])
     ->name('marketing.clients.confirm');
Route::post('/marketing/clients/{client}/cancel', [MarketingClientController::class, 'cancel'])
     ->name('marketing.clients.cancel');
Route::post('/marketing/clients/{client}/hide', [MarketingClientController::class, 'hide'])
     ->name('marketing.clients.hide');
Route::get('/marketing/clients/cancelled', [MarketingClientController::class, 'cancelled'])->name('marketing.clients.cancelled');

Route::get('/clients/summary', [MarketingClientController::class, 'summary'])->name('marketing.clients.summary');
Route::get('/clients/summary/pdf', [MarketingClientController::class, 'downloadSummaryPdf'])->name('marketing.clients.summary.pdf');
Route::get('/clients/pdf', [MarketingClientController::class, 'exportPdf'])->name('marketing.clients.index.pdf');

// ==================== DAILY TASKS ROUTES - SEPARATED BY ROLE ====================

// Super Admin Daily Tasks Routes
Route::prefix('superadmin/daily-tasks')->group(function () {
    Route::get('/', [DailyTaskController::class, 'index'])->name('superadmin.daily-tasks.index');
    Route::get('/create', [DailyTaskController::class, 'create'])->name('superadmin.daily-tasks.create');

    Route::post('/{task}/update-progress', [DailyTaskController::class, 'updateProgress'])->name('superadmin.daily-tasks.update-progress');
    Route::post('/{task}/verify', [DailyTaskController::class, 'verifyTask'])->name('superadmin.daily-tasks.verify');
    Route::delete('/{task}', [DailyTaskController::class, 'destroy'])->name('superadmin.daily-tasks.destroy');
    Route::get('/{dailyTask}', [DailyTaskController::class, 'show'])->name('superadmin.daily-tasks.show');
});

// Developer Daily Tasks Routes
Route::prefix('developer/daily-tasks')->group(function () {
    Route::get('/', [DailyTaskController::class, 'developerIndex'])->name('developer.daily-tasks.index');
    Route::get('/create', [DailyTaskController::class, 'developerCreate'])->name('developer.daily-tasks.create');
    Route::post('/', [DailyTaskController::class, 'developerStore'])->name('developer.daily-tasks.store');
    Route::post('/{task}/update-progress', [DailyTaskController::class, 'developerUpdateProgress'])->name('developer.daily-tasks.update-progress');
    Route::post('/{task}/verify', [DailyTaskController::class, 'developerverifyTask'])->name('developer.daily-tasks.verify');
    Route::delete('/{task}', [DailyTaskController::class, 'destroy'])->name('developer.daily-tasks.destroy');
    Route::get('/{dailyTask}', [DailyTaskController::class, 'developerShow'])->name('developer.daily-tasks.show');
});

// Project Manager Daily Tasks Routes
Route::prefix('projectmanager/daily-tasks')->group(function () {
    Route::get('/', [DailyTaskController::class, 'projectManagerIndex'])->name('projectmanager.daily-tasks.index');
    Route::get('/create', [DailyTaskController::class, 'projectManagerCreate'])->name('projectmanager.daily-tasks.create');
    Route::post('/', [DailyTaskController::class, 'projectManagerStore'])->name('projectmanager.daily-tasks.store');
    Route::post('/{task}/update-progress', [DailyTaskController::class, 'projectManagerUpdateProgress'])->name('projectmanager.daily-tasks.update-progress');
    Route::post('/{task}/verify', [DailyTaskController::class, 'projectManagerVerifyTask'])->name('projectmanager.daily-tasks.verify');
    Route::delete('/{task}', [DailyTaskController::class, 'projectManagerdestroy'])->name('projectmanager.daily-tasks.destroy');
    Route::get('/{dailyTask}', [DailyTaskController::class, 'projectManagerShow'])->name('projectmanager.daily-tasks.show');
});

// Marketing Daily Tasks Routes
Route::prefix('marketing/daily-tasks')->group(function () {
    Route::get('/', [DailyTaskController::class, 'marketingIndex'])->name('marketing.daily-tasks.index');
    Route::get('/create', [DailyTaskController::class, 'marketingCreate'])->name('marketing.daily-tasks.create');
    Route::post('/', [DailyTaskController::class, 'MarketingStore'])->name('marketing.daily-tasks.store');
    Route::post('/{task}/update-progress', [DailyTaskController::class, 'marketingUpdateProgress'])->name('marketing.daily-tasks.update-progress');
     Route::post('/{task}/verify', [DailyTaskController::class, 'marketingVerifyTask'])->name('marketing.daily-tasks.verify');
    Route::delete('/{task}', [DailyTaskController::class, 'marketingdestroy'])->name('marketing.daily-tasks.destroy');
    Route::get('/{dailyTask}', [DailyTaskController::class, 'marketingShow'])->name('marketing.daily-tasks.show');
});

// Common Employee routes (for all roles)
Route::get('/daily-tasks/my-tasks', [DailyTaskController::class, 'employeeTasks'])->name('employee.daily-tasks.index');

// ==================== KPI ROUTES - SEPARATED BY ROLE ====================

// Super Admin KPI Routes
Route::prefix('superadmin/kpi')->group(function () {
    Route::get('/', [KpiController::class, 'index'])->name('superadmin.kpi.index');
    Route::get('/create', [KpiController::class, 'create'])->name('superadmin.kpi.create');
    Route::post('/', [KpiController::class, 'store'])->name('superadmin.kpi.store');
    Route::post('/{kpi}/update-achievement', [KpiController::class, 'updateAchievement'])->name('superadmin.kpi.update-achievement');
    Route::delete('/{kpi}', [KpiController::class, 'destroy'])->name('superadmin.kpi.destroy');
});

// Developer KPI Routes
Route::prefix('developer/kpi')->group(function () {
    Route::get('/', [KpiController::class, 'developerIndex'])->name('developer.kpi.index');
    Route::get('/{kpi}', [KpiController::class, 'developerShow'])->name('developer.kpi.show');
    Route::post('/{kpi}/update-achievement', [KpiController::class, 'developerUpdateAchievement'])->name('developer.kpi.update-achievement');
});

// Project Manager KPI Routes
Route::prefix('projectmanager/kpi')->group(function () {
    Route::get('/', [KpiController::class, 'projectManagerIndex'])->name('projectmanager.kpi.index');
    Route::get('/create', [KpiController::class, 'projectManagerCreate'])->name('projectmanager.kpi.create');
    Route::post('/', [KpiController::class, 'projectManagerStore'])->name('projectmanager.kpi.store');
    Route::get('/{kpi}', [KpiController::class, 'projectManagerShow'])->name('projectmanager.kpi.show');
});

// Marketing KPI Routes
Route::prefix('marketing/kpi')->group(function () {
    Route::get('/', [KpiController::class, 'marketingIndex'])->name('marketing.kpi.index');
    Route::get('/{kpi}', [KpiController::class, 'marketingShow'])->name('marketing.kpi.show');
    Route::post('/{kpi}/update-achievement', [KpiController::class, 'marketingUpdateAchievement'])->name('marketing.kpi.update-achievement');
});
