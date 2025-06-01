<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MLevelController;
use App\Http\Controllers\MUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MDirutController;
use App\Http\Controllers\MDosenController;
use App\Http\Controllers\MKajurController;
use App\Http\Controllers\MKaprodiController;
use App\Http\Controllers\MKjmController;
use App\Http\Controllers\MKoordinatorController;
use App\Http\Controllers\MKriteriaController;
use App\Http\Controllers\TPermissionKriteriaUserController;

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


// Routes untuk setiap criteria
Route::get('/criteria/1', function () {
    return view('criteria-landing.criteria1');
})->name('criteria.1');

Route::get('/criteria/2', function () {
    return view('criteria-landing.criteria2');
})->name('criteria.2');

Route::get('/criteria/3', function () {
    return view('criteria-landing.criteria3');
})->name('criteria.3');

Route::get('/criteria/4', function () {
    return view('criteria-landing.criteria4');
})->name('criteria.4');

Route::get('/criteria/5', function () {
    return view('criteria-landing.criteria5');
})->name('criteria.5');

Route::get('/criteria/6', function () {
    return view('criteria-landing.criteria6');
})->name('criteria.6');

Route::get('/criteria/7', function () {
    return view('criteria-landing.criteria7');
})->name('criteria.7');

Route::get('/criteria/8', function () {
    return view('criteria-landing.criteria8');
})->name('criteria.8');

Route::get('/criteria/9', function () {
    return view('criteria-landing.criteria9');
})->name('criteria.9');

Route::middleware(['auth'])->group(function () {

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // management-users
        Route::group(['prefix' => 'management-users', 'middleware' => ['auth']], function () {
        //level
        Route::resource('level', MLevelController::class);
        Route::post('level/list', [MLevelController::class, 'list'])->name('level.list');
        Route::get('level/{id}/delete', [MLevelController::class, 'confirm']);

        //user
        Route::resource('user', MUserController::class);
        Route::post('user/list', [MUserController::class, 'list'])->name('user.list');
        Route::get('user/{id}/delete', [MUserController::class, 'confirm']);
         //dosen
        Route::get('dosen/import', [MDosenController::class, 'importForm'])->name('dosen.import');
        Route::post('dosen/import', [MDosenController::class, 'import'])->name('dosen.import.post');
        Route::get('dosen/export', [MDosenController::class, 'export'])->name('dosen.export');
        Route::resource('dosen', MDosenController::class);
        Route::post('dosen/list', [MDosenController::class, 'list'])->name('dosen.list');
        Route::get('dosen/{id}/delete', [MDosenController::class, 'confirm']);

        //kaprodi
        Route::resource('kaprodi', MKaprodiController::class);
        Route::post('kaprodi/list/data', [MKaprodiController::class, 'list'])->name('kaprodi.list');
        Route::get('kaprodi/{id}/delete', [MKaprodiController::class, 'confirm']);

        //MKoordinator
        Route::resource('koordinator', MKoordinatorController::class);
        Route::post('koordinator/list/data', [MKoordinatorController::class, 'list'])->name('koordinator.list');
        Route::get('koordinator/{id}/delete', [MKoordinatorController::class, 'confirm']);

        //MKJM
        Route::resource('kjm', MKjmController::class);
        Route::post('kjm/list/data', [MKjmController::class, 'list'])->name('kjm.list');
        Route::get('kjm/{id}/delete', [MKjmController::class, 'confirm']);

        //direktur-utama
        Route::resource('direktur-utama', MDirutController::class);
        Route::post('direktur-utama/list/data', [MDirutController::class, 'list'])->name('direktur-utama.list');
        Route::get('direktur-utama/{id}/delete', [MDirutController::class, 'confirm']);

        //kajur
        Route::resource('ketua-jurusan', MKajurController::class);
        Route::post('ketua-jurusan/list/data', [MKajurController::class, 'list'])->name('kajur.list');
        Route::get('ketua-jurusan/{id}/delete', [MKajurController::class, 'confirm']);
    });


    Route::resource('kriteria', MKriteriaController::class);
    Route::post('kriteria/list/data', [MKriteriaController::class, 'list'])->name('kriteria.list');
    Route::get('kriteria/{id}/delete', [MKriteriaController::class, 'confirm']);

    //permission
    Route::get('permission-kriteria', [TPermissionKriteriaUserController::class, 'index'])->name('permission-kriteria.index');
    Route::post('permission-kriteria/list', [TPermissionKriteriaUserController::class, 'list'])->name('permission-kriteria.list');
    Route::get('permission-kriteria/give-permissions/{id}', [TPermissionKriteriaUserController::class, 'edit'])->name('permission-kriteria.edit');
    Route::put('/permission-kriteria/{id}', [TPermissionKriteriaUserController::class, 'update'])->name('permission-kriteria.update');

});
