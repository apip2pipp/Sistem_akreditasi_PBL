<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MLevelController;
use App\Http\Controllers\MUserController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// routes/web.php
Route::get('/', function () {
    return view('landing-page'); // Pastikan file home.blade.php ada di resources/views
})->name('home'); // Ini memberikan nama 'home' pada route


Route::get('/login', [AuthController::class, 'viewLogin'])->name('login.view');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
