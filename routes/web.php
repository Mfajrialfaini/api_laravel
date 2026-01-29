<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// default → login
Route::get('/', function () {
    return redirect()->route('login');
});

/* =====================
| AUTH
===================== */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* =====================
| DASHBOARD
===================== */
Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
        return view('home');
    })->name('home');
});
