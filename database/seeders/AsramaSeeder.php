<?php

namespace Database\Seeders;

use App\Models\Asrama;
use Illuminate\Database\Seeder;
use Carbon\Carbon;


class AsramaSeeder extends Seeder
{
    public function run()
    {
        Asrama::insert([
            [
                'nama_asrama' => 'Asrama A',
                'lokasi_id' => 1,
                'kuota' => 30,
                'starus_asrama' => 'Available',
                'keterangan' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_asrama' => 'Asrama B',
                'lokasi_id' => 2,
                'kuota' => 30,
                'starus_asrama' => 'Available',
                'keterangan' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
