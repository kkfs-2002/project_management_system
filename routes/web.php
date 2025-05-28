<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
   return redirect()->route('login');
});


use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

use App\Http\Controllers\Auth\RegisterController;

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

use App\Http\Controllers\Auth\EmployeeController;

Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employee.create');
Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employee.store');


use App\Http\Controllers\Auth\SuperDashController;

Route::get('/superdash', [SuperDashController::class, 'index'])->name('superdash');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/dashboard', function () {
    return 'Welcome to dashboard! You are logged in.';
})->middleware('auth');



// Protect dashboard with auth middleware
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');


//profile for employe
Route::get('/admin/dashboard', [ProfileController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/profile/create', [ProfileController::class, 'create'])->name('profile.create');
Route::post('/admin/profile/store', [ProfileController::class, 'store'])->name('profile.store');
Route::get('/admin/profile/view', [ProfileController::class, 'index'])->name('profile.index');
