<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KelompokBesarSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            'Cross',
            'Technical Enabler',
            'Technical Pengawasan',
        ];

        foreach ($datas as $nama) {
            DB::table('kelompok_besar')->insert([
                'nama_kelompok_besar' => $nama,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
