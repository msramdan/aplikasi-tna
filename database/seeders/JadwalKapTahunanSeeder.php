<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class JadwalKapTahunanSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $startDate = $now->copy()->startOfMonth()->addMonth();
        $endDate = $startDate->copy()->addMonth()->subDay();

        DB::table('jadwal_kap_tahunan')->insert([
            'tahun' => $now->year,
            'tanggal_mulai' => date('Y-m-d'),
            'tanggal_selesai' => $endDate->format('Y-m-d'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
