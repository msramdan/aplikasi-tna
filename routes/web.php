<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    UserController,
    ProfileController,
    RoleAndPermissionController,
};
use App\Http\Controllers\LocalizationController;

//route switch bahasa
Route::get('/localization/{language}', [LocalizationController::class, 'switch'])->name('localization.switch');
Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', ProfileController::class)->name('profile');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleAndPermissionController::class);
    Route::resource('setting-apps', App\Http\Controllers\SettingAppController::class);
});
Route::get('/dashboard', function () {
    return redirect()->route('dashboard');
});

Route::resource('kompetensi', App\Http\Controllers\KompetensiController::class)->middleware('auth');
Route::controller(App\Http\Controllers\KompetensiController::class)->group(function () {
    Route::get('/detailKompetensi', 'detailKompetensi')->name('detailKompetensi');
    Route::get('/exportKompetensi', 'exportKompetensi')->name('exportKompetensi');
    Route::post('/importKompetensi', 'importKompetensi')->name('importKompetensi');
});

Route::resource('kalender-pembelajaran', App\Http\Controllers\KalenderPembelajaranController::class)->middleware('auth');
Route::resource('reporting', App\Http\Controllers\ReportingController::class)->middleware('auth');
Route::resource('kota', App\Http\Controllers\KotaController::class)->middleware('auth');
Route::resource('lokasi', App\Http\Controllers\LokasiController::class)->middleware('auth');
Route::resource('ruang-kelas', App\Http\Controllers\RuangKelasController::class)->middleware('auth');
