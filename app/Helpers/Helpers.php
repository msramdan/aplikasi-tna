<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
