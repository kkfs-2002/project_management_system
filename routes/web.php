<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return redirect()->route('login');
});

<<<<<<< Updated upstream
use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/dashboard', function () {
    return 'Welcome to dashboard! You are logged in.';
})->middleware('auth');



// Protect dashboard with auth middleware
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
=======
//profile for employe
use App\Http\Controllers\ProfileController;

Route::get('/admin/dashboard', [ProfileController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/profile/create', [ProfileController::class, 'create'])->name('profile.create');
Route::post('/admin/profile/store', [ProfileController::class, 'store'])->name('profile.store');
Route::get('/admin/profile/view', [ProfileController::class, 'index'])->name('profile.index');
>>>>>>> Stashed changes
