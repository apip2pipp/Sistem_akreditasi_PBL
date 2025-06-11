<?php

use App\Http\Controllers\AkreditasiController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MDirutController;
use App\Http\Controllers\MDosenController;
use App\Http\Controllers\MKajurController;
use App\Http\Controllers\MKaprodiController;
use App\Http\Controllers\MKjmController;
use App\Http\Controllers\MKoordinatorController;
use App\Http\Controllers\MKriteriaController;
use App\Http\Controllers\MLevelController;
use App\Http\Controllers\MUserController;
use App\Http\Controllers\TPenelitianDosenController;
use App\Http\Controllers\TPenelitianDosenKoordinatorController;
use App\Http\Controllers\TPermissionKriteriaUserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('landing-page');})->name('home');

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
    });

    Route::resource('kriteria', MKriteriaController::class);
    Route::post('kriteria/list/data', [MKriteriaController::class, 'list'])->name('kriteria.list');
    Route::get('kriteria/{id}/delete', [MKriteriaController::class, 'confirm']);

    //permission
    Route::get('permission-kriteria', [TPermissionKriteriaUserController::class, 'index'])->name('permission-kriteria.index');
    Route::post('permission-kriteria/list', [TPermissionKriteriaUserController::class, 'list'])->name('permission-kriteria.list');
    Route::get('permission-kriteria/give-permissions/{id}', [TPermissionKriteriaUserController::class, 'edit'])->name('permission-kriteria.edit');
    Route::put('/permission-kriteria/{id}', [TPermissionKriteriaUserController::class, 'update'])->name('permission-kriteria.update');

    Route::prefix('akreditasi')->name('akreditasi.')->group(function () {
        // Halaman index berdasarkan slug kriteria
        Route::get('/{slug}', [AkreditasiController::class, 'index'])->name('index');

        // List data untuk DataTables (AJAX)
        Route::post('/list/{slug}', [AkreditasiController::class, 'list'])->name('list');

        // Simpan draft (POST)
        Route::post('/draft/{slug}', [AkreditasiController::class, 'draft'])->name('draft');

        // Update draft (PUT)
        Route::put('/draft/{id_akreditasi}', [AkreditasiController::class, 'updateDraft'])->name('updateDraft');

        // generate file update
        Route::post('/generate-pdf-update/{id_akreditasi}', [AkreditasiController::class, 'generatePdfUpdateAkreditasi'])->name('generate.pdf.update');

        // Show Draft
        Route::get('/show-draft/{id_akreditasi}', [AkreditasiController::class, 'showDraft'])->name('showDraft');

        // showDraft2
        Route::get('/show-draft2/{id_akreditasi}/show', [AkreditasiController::class, 'showDraft2'])->name('showDraft2');

        // Finalisasi status draft ke final (POST)
        Route::post('/final/{id_akreditasi}', [AkreditasiController::class, 'final'])->name('final');

        // view revisi
        Route::get('/revisi-draft/{id_akreditasi}', [AkreditasiController::class, 'RevisiDraft'])->name('revisiDraft');

        // Revisi draft (POST)
        Route::post('/revisi/{id_akreditasi}', [AkreditasiController::class, 'revisi'])->name('revisi');

        // editDraft
        Route::get('/edit-draft/{id_akreditasi}', [AkreditasiController::class, 'editDraft'])->name('editDraft');

        // Update status review oleh Kaprodi (POST)
        Route::post('/status/kaprodi/{id_akreditasi}', [AkreditasiController::class, 'updateStatusKaprodi'])->name('status.kaprodi');

        // Update status review oleh Kajur (POST)
        Route::post('/status/kajur/{id_akreditasi}', [AkreditasiController::class, 'updateStatusKajur'])->name('status.kajur');

        // Update status review oleh KJM (POST)
        Route::post('/status/kjm/{id_akreditasi}', [AkreditasiController::class, 'updateStatusKjm'])->name('status.kjm');

        // Update status review oleh Direktur Utama (POST)
        Route::post('/status/direktur_utama/{id_akreditasi}', [AkreditasiController::class, 'updateStatusDirekturUtama'])->name('status.direktur_utama');
    });

    Route::resource('penelitian-dosen', TPenelitianDosenController::class);
    Route::post('penelitian-dosen/list/data', [TPenelitianDosenController::class, 'list'])->name('penelitian-dosen.list');
    //statusPenelitian
    Route::put('penelitian-dosen/{id}/status', [TPenelitianDosenController::class, 'statusPenelitian'])->name('penelitian-dosen.status');
    Route::get('penelitian-dosen/{id}/delete', [TPenelitianDosenController::class, 'confirm']);

    Route::resource('penelitian-dosen-koordinator', TPenelitianDosenKoordinatorController::class);
    Route::post('penelitian-dosen-koordinator/list/data', [TPenelitianDosenKoordinatorController::class, 'list'])->name('penelitian-dosen-koordinator.list');
    Route::get('penelitian-dosen-koordinator/{id}/delete', [TPenelitianDosenKoordinatorController::class, 'confirm']);

});
