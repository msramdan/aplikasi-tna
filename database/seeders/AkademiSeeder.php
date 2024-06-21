<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AkademiSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            'Akuntansi Forensik dan Investigasi',
            'Kompetensi Umum',
            'Tata Kelola Korporasi',
            'Tata Kelola Pemerintahan Daerah dan Desa',
            'Tata Kelola Perekonomian dan Kemaritiman',
            'Tata Kelola Polhukam dan PMK',
            'Cross Kompetensi',
            'Cross Pengawasan',
        ];

        foreach ($datas as $nama) {
            DB::table('akademi')->insert([
                'nama_akademi' => $nama,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
