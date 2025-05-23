<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MLevelController;
use App\Http\Controllers\MUserController;
use App\Http\Controllers\DashboardController;
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
    return view('landing-page'); })->name('home');

Route::get('/login', [AuthController::class, 'viewLogin'])->name('login.view');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        //level
        Route::resource('level', MLevelController::class);
        Route::post('level/list', [MLevelController::class, 'list'])->name('level.list');
        Route::get('level/{id}/delete', [MLevelController::class, 'confirm']);

        //user
        Route::resource('user', MUserController::class);
        Route::post('user/list', [MUserController::class, 'list'])->name('user.list');
        Route::get('user/{id}/delete', [MUserController::class, 'confirm']);
