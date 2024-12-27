<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    UserController,
    ProfileController,
    RoleAndPermissionController,
    ActivityLogController,
    ApiController,
    BackupController,
    JadwalKapTahunanController,
    KalenderPembelajaranController,
    KompetensiController,
    KompetensiApiController,
    LocalizationController,
    PengajuanKapController,
    SyncInfoIDiklatController,
    ReportingController,
    SettingAppController,
    ConfigStepReview,
    LokasiController,
    NomenklaturPembelajaranController,
    PengumumanController,
    ReplyController,
    RumpunPembelajaranController,
    TaggingPembelajaranKompetensiController,
    TopikController,
    TaggingKompetensiIkController,
    TaggingKompetensiIkReverseController,
    TaggingPembelajaranKompetensiReverseController
};
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\ErrorController;
use App\Models\SettingApp;

Route::get('/not-found', [ErrorController::class, 'notFound'])->name('not-found');
Route::get('/un-authorized', [ErrorController::class, 'unAuthorized'])->name('un-authorized');
Route::post('/clear-session', function (Illuminate\Http\Request $request) {
    session()->forget($request->key);
    return response()->json(['success' => true]);
})->name('clear-session');
Route::post('/update-no-wa', [UserController::class, 'updateNoWa'])->name('update.no.wa');



Route::get('/maintenance', function () {
    return view('maintenance');
})->name('maintenance')->middleware('redirect.if.not.maintenance');

Route::middleware(['auth', 'web', 'check.maintenance'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/localization/{language}', [LocalizationController::class, 'switch'])->name('localization.switch');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', ProfileController::class)->name('profile');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleAndPermissionController::class);
    Route::resource('setting-apps', SettingAppController::class);
    Route::resource('pengumuman', PengumumanController::class)->middleware('auth');
    Route::controller(ConfigStepReview::class)->group(function () {
        Route::get('/config-step-review', 'index')->name('config-step-review.index');
        Route::put('/submit-config-step-review', 'submitForm')->name('config-step-review.store');
    });
    Route::resource('kompetensi', KompetensiController::class);
    Route::controller(KompetensiController::class)->group(function () {
        Route::get('/detailKompetensi', 'detailKompetensi')->name('detailKompetensi');
        Route::get('/exportKompetensi', 'exportKompetensi')->name('exportKompetensi');
        Route::post('/importKompetensi', 'importKompetensi')->name('importKompetensi');
        Route::get('/download-format-kompetensi', 'formatImport')->name('download-format-kompetensi');
        Route::get('/getKompetensiById/{id}', 'getKompetensiById')->name('getKompetensiById');
    });
    Route::controller(KompetensiApiController::class)->group(function () {
        Route::get('/kompetensi-api', 'index')->name('kompetensi-api.index');
    });
    Route::controller(KalenderPembelajaranController::class)->group(function () {
        Route::get('/kalender-pembelajaran/{tahun}/{waktu_pelaksanaan}/{sumber_dana}/{topik}', 'index')->name('kalender-pembelajaran.index')->where('topik', '.*');
        Route::get('/events', 'getEvents')->name('getEvents');
        Route::get('/exportKalenderPembelajaran', 'exportKalenderPembelajaran')->name('exportKalenderPembelajaran');
    });
    Route::resource('topik', TopikController::class);
    Route::controller(TopikController::class)->group(function () {
        Route::get('/exportTopik', 'exportTopik')->name('exportTopik');
        Route::post('/importTopik', 'importTopik')->name('importTopik');
        Route::get('/download-format-topik', 'formatImport')->name('download-format-topik');
        Route::post('/usulanProgramPembelajaran', 'usulanProgramPembelajaran')->name('usulanProgramPembelajaran');
    });

    Route::resource('rumpun-pembelajaran', RumpunPembelajaranController::class);
    Route::controller(RumpunPembelajaranController::class)->group(function () {
        Route::get('/getRumpunPembelajaran', 'getRumpunPembelajaran')->name('getRumpunPembelajaran');
    });

    Route::controller(LokasiController::class)->group(function () {
        Route::get('/lokasi', 'index')->name('lokasi.index');
    });

    Route::resource('jadwal-kap-tahunan', JadwalKapTahunanController::class);
    $reverseTagging = SettingApp::findOrFail(1)->reverse_atur_tagging === 'Yes';
    if ($reverseTagging) {
        // Reverse routes
        Route::controller(TaggingPembelajaranKompetensiReverseController::class)->group(function () {
            Route::get('/tagging-kompetensi-pembelajaran', 'index')->name('tagging-kompetensi-pembelajaran.index');
            Route::get('/tagging-kompetensi-pembelajaran/{topik_id}', 'settingTagging')->name('tagging-kompetensi-pembelajaran.setting');
            Route::post('/tagging-kompetensi-pembelajaran/update/{id}', 'updateTagging')->name('tagging-kompetensi-pembelajaran.update');
            Route::delete('/tagging-kompetensi-pembelajaran/{id}', 'destroy')->name('tagging-kompetensi-pembelajaran.destroy');
            Route::get('/detailTaggingKompetensiPembelajaran', 'detailTaggingKompetensiPembelajaran')->name('detailTaggingKompetensiPembelajaran');
            Route::get('/exportTagKompetensiPembelajaran', 'exportTagKompetensiPembelajaran')->name('exportTagKompetensiPembelajaran');
            Route::get('/download-format-tagging-kompetensi-pembelajaran', 'formatImport')->name('download-format-tagging-kompetensi-pembelajaran');
            Route::post('/importTaggingKompetensiPembelajaran', 'importTaggingKompetensiPembelajaran')->name('importTaggingKompetensiPembelajaran');
        });
    } else {
        // Standard routes
        Route::controller(TaggingPembelajaranKompetensiController::class)->group(function () {
            Route::get('/tagging-pembelajaran-kompetensi', 'index')->name('tagging-pembelajaran-kompetensi.index');
            Route::get('/tagging-pembelajaran-kompetensi/{topik_id}', 'settingTagging')->name('tagging-pembelajaran-kompetensi.setting');
            Route::post('/tagging-pembelajaran-kompetensi/update/{id}', 'updateTagging')->name('tagging-pembelajaran-kompetensi.update');
            Route::delete('/tagging-pembelajaran-kompetensi/{id}', 'destroy')->name('tagging-pembelajaran-kompetensi.destroy');
            Route::get('/detailTaggingPembelajaranKompetensi', 'detailTaggingPembelajaranKompetensi')->name('detailTaggingPembelajaranKompetensi');
            Route::get('/exportTagPembelajaranKompetensi', 'exportTagPembelajaranKompetensi')->name('exportTagPembelajaranKompetensi');
            Route::get('/download-format-tagging-pembelejaran-kompotensi', 'formatImport')->name('download-format-tagging-pembelejaran-kompotensi');
            Route::post('/importTaggingPembelajaranKompetensi', 'importTaggingPembelajaranKompetensi')->name('importTaggingPembelajaranKompetensi');
        });
    }

    if ($reverseTagging) {
        // reverse
        Route::controller(TaggingKompetensiIkReverseController::class)->group(function () {
            Route::get('/tagging-ik-kompetensi/{type}', 'index')->name('tagging-ik-kompetensi');
            Route::get('/tagging-ik-kompetensi/{indikator_kinerja}/{type}', 'settingTagging')->name('tagging-ik-kompetensi.setting');
            Route::delete('/tagging-ik-kompetensi/{indikator_kinerja}/{type}', 'destroy')->name('tagging-ik-kompetensi.destroy');
            Route::post('/tagging-ik-kompetensi/update/{indikator_kinerja}/{type}', 'updateTagging')->name('tagging-ik-kompetensi.update');
            Route::get('/detailTaggingIkKompetensi', 'detailTaggingIkKompetensi')->name('detailTaggingIkKompetensi');
            Route::get('/export-tagging-ik-kompetensi/{type}', 'exportTagKompetensiIk')->name('export-tagging-ik-kompetensi');
            Route::get('/download-format-tagging-ik-kompetensi/{type}', 'formatImport')->name('download-format-tagging-ik-kompetensi');
            Route::post('/importTaggingIkKompetensi/{type}', 'importTaggingIkKompetensi')->name('importTaggingIkKompetensi');
        });
    } else {
        // Standard routes
        Route::controller(TaggingKompetensiIkController::class)->group(function () {
            Route::get('/tagging-kompetensi-ik/{type}', 'index')->name('tagging-kompetensi-ik');
            Route::get('/tagging-kompetensi-ik/{id}/{type}', 'settingTagging')->name('tagging-kompetensi-ik.setting');
            Route::delete('/tagging-kompetensi-ik/{id}/{type}', 'destroy')->name('tagging-kompetensi-ik.destroy');
            Route::post('/tagging-kompetensi-ik/update/{id}/{type}', 'updateTagging')->name('tagging-kompetensi-ik.update');
            Route::get('/detailTaggingKompetensiIk', 'detailTaggingKompetensiIk')->name('detailTaggingKompetensiIk');
            Route::get('/export-tagging-kompetensi-ik/{type}', 'exportTagKompetensiIk')->name('export-tagging-kompetensi-ik');
            Route::get('/download-format-tagging-kompetensi-ik/{type}', 'formatImport')->name('download-format-tagging-kompetensi-ik');
            Route::post('/importTaggingKompetensiIk/{type}', 'importTaggingKompetensiIk')->name('importTaggingKompetensiIk');
        });
    }
    Route::controller(ActivityLogController::class)->group(function () {
        Route::get('/activity-log', 'index')->name('activity-log.index');
    });
    Route::controller(PengajuanKapController::class)->group(function () {
        Route::get('/pengajuan-kap/{is_bpkp}/{frekuensi}', 'index')->name('pengajuan-kap.index');
        Route::get('/pengajuan-kap/create/{is_bpkp}/{frekuensi}', 'create')->name('pengajuan-kap.create');
        Route::get('/pengajuan-kap/{id}/{is_bpkp}/{frekuensi}/edit', 'edit')->name('pengajuan-kap.edit');
        Route::get('/pengajuan-kap/{id}/{is_bpkp}/{frekuensi}/duplikat', 'duplikat')->name('pengajuan-kap.duplikat');
        // Route untuk submit create
        Route::post('/pengajuan-kap/{is_bpkp}/{frekuensi}', 'store')->name('pengajuan-kap.store');
        // Route untuk submit edit
        Route::put('/pengajuan-kap/{id}/{is_bpkp}/{frekuensi}', 'update')->name('pengajuan-kap.update');
        // Route untuk delete
        Route::delete('/pengajuan-kap/{id}/{is_bpkp}/{frekuensi}', 'destroy')->name('pengajuan-kap.destroy');
        // Route untuk show
        Route::get('/pengajuan-kap/{id}/{is_bpkp}/{frekuensi}', 'show')->name('pengajuan-kap.show');
        Route::get('/pengajuan-kap-pdf/{id}/{is_bpkp}/{frekuensi}', 'cetak_pdf')->name('pengajuan-kap.pdf');
        Route::put('/pengajuan-kap/{id}/approve', 'approve')->name('pengajuan-kap.approve');
        Route::put('/pengajuan-kap/{id}/reject', 'reject')->name('pengajuan-kap.reject');
        Route::put('/pengajuan-kap/{id}/revisi', 'revisi')->name('pengajuan-kap.revisi');
        // for selected
        Route::post('/approve', 'approveSelected')->name('pengajuan-kap-selected.approve');
        Route::post('/reject', 'rejectSelected')->name('pengajuan-kap-selected.reject');
        Route::post('/skip', 'skipSelected')->name('pengajuan-kap-selected.skip');
        // for export data
        Route::get('/exportPengajuanKap', 'exportPengajuanKap')->name('exportPengajuanKap');
        Route::get('/check-pengajuan-kap/{qrCode}', 'check')->name('check-pengajuan-kap');
    });

    Route::get('/pengajuan-kap/fetch-prioritas', [PengajuanKapController::class, 'fetchPrioritas'])->name('pengajuan-kap.fetch-prioritas');
    Route::post('/pengajuan-kap/update-prioritas', [PengajuanKapController::class, 'updatePrioritas'])
        ->name('pengajuan-kap.update-prioritas');

    Route::post('/replies', [ReplyController::class, 'store'])->name('replies.store');
    Route::controller(SyncInfoIDiklatController::class)->group(function () {
        Route::get('/sync-info-diklat', 'index')->name('sync-info-diklat.index');
        Route::get('/sync-info-diklat-show/{id}', 'show')->name('sync-info-diklat.show');
        Route::get('/sync-info-diklat-pdf/{id}', 'cetak_pdf')->name('sync-info-diklat.pdf');
        Route::post('/sync-info-diklat-selected', 'syncSelected')->name('sync-info-diklat.syncSelected');
    });
    Route::resource('nomenklatur-pembelajaran', NomenklaturPembelajaranController::class);
    Route::controller(NomenklaturPembelajaranController::class)->group(function () {
        Route::patch('nomenklatur-pembelajaran/{id}/approve', 'approve')->name('nomenklatur-pembelajaran.approve');
        Route::patch('nomenklatur-pembelajaran/{id}/reject', 'reject')->name('nomenklatur-pembelajaran.reject');
    });

    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::get('/backup/download', [BackupController::class, 'downloadBackup'])->name('backup.download');
    Route::get('/get-indikator/{jenisProgram}', [ApiController::class, 'getIndikator'])->name('getIndikator');
    Route::get('/get-kompetensi-support-ik', [ApiController::class, 'getKompetensiSupportIK'])->name('getKompetensiSupportIK');
    Route::get('/get-topik-support-kompetensi', [ApiController::class, 'getTopikSupportKompetensi'])->name('getTopikSupportKompetensi');
    Route::get('/get-kompetensi-apip', [ApiController::class, 'getKompetensiApip'])->name('getKompetensiApip');
});

Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('verify-otp');
