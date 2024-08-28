<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

function set_show($uri)
{
    if (is_array($uri)) {
        foreach ($uri as $u) {
            if (Route::is($u)) {
                return 'show';
            }
        }
    } else {
        if (Route::is($uri)) {
            return 'show';
        }
    }
}

if (!function_exists('set_active')) {
    function set_active($uri)
    {
        if (is_array($uri)) {
            foreach ($uri as $u) {
                if (Route::is($u)) {
                    return 'active';
                }
            }
        } else {
            if (Route::is($uri)) {
                return 'active';
            }
        }
    }
}
if (!function_exists('setting_web')) {
    function setting_web()
    {
        $setting = DB::table('setting_apps')->first();
        return $setting;
    }
}


function formatTanggalIndonesia($tanggal)
{
    // Ubah format ke dalam format tanggal PHP
    $tanggalPHP = date_create($tanggal);

    // Array nama bulan dalam bahasa Indonesia
    $namaBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    // Ambil tanggal, bulan, dan tahun
    $tanggal = date_format($tanggalPHP, 'd');
    $bulan = $namaBulan[date_format($tanggalPHP, 'n')];
    $tahun = date_format($tanggalPHP, 'Y');

    // Format hasilnya
    $tanggalIndonesia = $tanggal . ' ' . $bulan . ' ' . $tahun;

    return $tanggalIndonesia;
}

function reviewExistsForUser()
{
    $userId = Auth::id();
    return DB::table('config_step_review')
        ->where('user_review_id', $userId)
        ->exists();
}


function reviewExistsForUserWithRemark($remark)
{
    $userId = Auth::id();
    return DB::table('config_step_review')
        ->where('user_review_id', $userId)
        ->where('remark', $remark)
        ->exists();
}

function callApiPusdiklatwas($url, $params = [])
{
    $response = Http::get($url, $params);

    if ($response->failed()) {
        return ['error' => 'Tidak bisa mengakses API.'];
    }

    $data = $response->json();

    if (!isset($data['data'])) {
        return ['error' => 'Data dari API Pusdiklatmas tidak valid.'];
    }

    return $data['data'];
}

function syncData($pengajuanKap)
{
    $endpoint_pusdiklatwap = config('stara.endpoint_pusdiklatwap');
    $api_key_pusdiklatwap = config('stara.api_token_pusdiklatwap');
    $apiUrl = $endpoint_pusdiklatwap . '/kaldik/store?api_key=' . $api_key_pusdiklatwap;

    // Fetch data from waktu_pelaksanaan table
    $waktuPelaksanaan = DB::table('waktu_pelaksanaan')
        ->where('pengajuan_kap_id', $pengajuanKap->id)
        ->get();

    // Initialize payload
    $payload = [
        "kaldikID" => $pengajuanKap->kode_pembelajaran,
        "kaldikYear" => $pengajuanKap->tahun,
        "biayaID" => $pengajuanKap->biayaID,
        "diklatLocID" => $pengajuanKap->diklatLocID,
        "kelas" => $pengajuanKap->kelas,
        "metodeID" => $pengajuanKap->metodeID,
        "kaldikdesc" => $pengajuanKap->judul,
        "tempatName" => $pengajuanKap->detail_lokasi,
        "latsar_stat" => $pengajuanKap->latsar_stat,
        "id_jenis_diklat" => $pengajuanKap->diklatTypeID,
    ];

    // Determine date fields based on waktu_pelaksanaan records and metodeID
    if ($waktuPelaksanaan->count() == 1) {
        $record = $waktuPelaksanaan->first();
        if ($pengajuanKap->metodeID == '1') {
            $payload["tgl_mulai_tm"] = $record->tanggal_mulai;
            $payload["tgl_selesai_tm"] = $record->tanggal_selesai;
        } elseif ($pengajuanKap->metodeID == '4') {
            $payload["tgl_mulai_el"] = $record->tanggal_mulai;
            $payload["tgl_selesai_el"] = $record->tanggal_selesai;
        }
    } elseif ($waktuPelaksanaan->count() == 2) {
        $records = $waktuPelaksanaan->toArray();
        if ($pengajuanKap->metodeID == '2') {
            $payload["tgl_mulai_el"] = $records[0]->tanggal_mulai;
            $payload["tgl_selesai_el"] = $records[0]->tanggal_selesai;
            $payload["tgl_mulai_tm"] = $records[1]->tanggal_mulai;
            $payload["tgl_selesai_tm"] = $records[1]->tanggal_selesai;
        }
    }

    // Make the API request
    $response = Http::post($apiUrl, $payload);

    // Check the response status
    if ($response->ok()) {
        $responseBody = $response->json();
        return isset($responseBody['status']) && $responseBody['status'] === true;
    }

    return false;
}

function getPendingNomenklaturData()
{
    $pendingCount = DB::table('nomenklatur_pembelajaran')
        ->where('status', 'pending')
        ->count();

    $latestPending = DB::table('nomenklatur_pembelajaran')
        ->where('status', 'pending')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    return compact('pendingCount', 'latestPending');
}
