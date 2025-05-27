<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return redirect()->route('login');
});

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
