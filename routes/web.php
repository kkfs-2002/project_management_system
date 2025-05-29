<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
   return redirect()->route('login');
});

//Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');



//profile for employe
Route::get('/admin/dashboard', [ProfileController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/profile/create', [ProfileController::class, 'create'])->name('profile.create');
Route::post('/admin/profile/store', [ProfileController::class, 'store'])->name('profile.store');
Route::get('/admin/profile/view', [ProfileController::class, 'index'])->name('profile.index');
