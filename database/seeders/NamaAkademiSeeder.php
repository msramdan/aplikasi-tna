<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NamaAkademiSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            'Akademi Akuntansi Forensik dan Investigasi',
            'Akademi Kompetensi Umum',
            'Akademi Tata Kelola Korporasi',
            'Akademi Tata Kelola Pemerintahan Daerah dan Desa',
            'Akademi Tata Kelola Perekonomian dan Kemaritiman',
            'Akademi Tata Kelola Polhukam dan PMK',
            'Cross Kompetensi',
            'Cross Pengawasan',
        ];

        foreach ($datas as $nama) {
            DB::table('nama_akademi')->insert([
                'nama_akademi' => $nama,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
