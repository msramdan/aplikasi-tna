<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    UserController,
    ProfileController,
    RoleAndPermissionController,
    ActivityLogController,
    AsramaController,
    JadwalKapTahunanController,
    KalenderPembelajaranController,
    KompetensiController,
    KotaController,
    LocalizationController,
    LokasiController,
    ReportingController,
    RuangKelasController,
    SettingAppController,
    TaggingPembelajaranKompetensiController,
    TopikController
};
use App\Http\Controllers\Auth\OtpController;

Route::get('/localization/{language}', [LocalizationController::class, 'switch'])->name('localization.switch');
Route::get('/dashboard', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', ProfileController::class)->name('profile');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleAndPermissionController::class);
    Route::resource('setting-apps', SettingAppController::class);

    Route::resource('kompetensi', KompetensiController::class);
    Route::controller(KompetensiController::class)->group(function () {
        Route::get('/detailKompetensi', 'detailKompetensi')->name('detailKompetensi');
        Route::get('/exportKompetensi', 'exportKompetensi')->name('exportKompetensi');
        Route::post('/importKompetensi', 'importKompetensi')->name('importKompetensi');
    });

    Route::resource('kalender-pembelajaran', KalenderPembelajaranController::class);
    Route::resource('reporting', ReportingController::class);
    Route::resource('kota', KotaController::class);
    Route::resource('lokasi', LokasiController::class);
    Route::resource('ruang-kelas', RuangKelasController::class);
    Route::resource('asrama', AsramaController::class);

    Route::resource('topik', TopikController::class);
    Route::controller(TopikController::class)->group(function () {
        Route::get('/exportTopik', 'exportTopik')->name('exportTopik');
        Route::post('/importTopik', 'importTopik')->name('importTopik');
    });

    Route::resource('jadwal-kap-tahunan', JadwalKapTahunanController::class);
    Route::controller(TaggingPembelajaranKompetensiController::class)->group(function () {
        Route::get('/tagging-pembelajaran-kompetensi', 'index')->name('tagging-pembelajaran-kompetensi.index');
        Route::get('/tagging-pembelajaran-kompetensi/{topik_id}', 'settingTagging')->name('tagging-pembelajaran-kompetensi.setting');
        Route::post('/tagging-pembelajaran-kompetensi/update/{id}', 'updateTagging')->name('tagging-pembelajaran-kompetensi.update');
        Route::delete('/tagging-pembelajaran-kompetensi/{id}', 'destroy')->name('tagging-pembelajaran-kompetensi.destroy');
        Route::get('/detailTaggingPembelajaranKompetensi', 'detailTaggingPembelajaranKompetensi')->name('detailTaggingPembelajaranKompetensi');
    });
    Route::controller(ActivityLogController::class)->group(function () {
        Route::get('/activity-log', 'index')->name('activity-log.index');
    });
    Route::controller(ActivityLogController::class)->group(function () {
        Route::get('/activity-log', 'index')->name('activity-log.index');
    });
});

Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('verify-otp');
