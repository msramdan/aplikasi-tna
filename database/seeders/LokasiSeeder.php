<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use Illuminate\Database\Seeder;
use Carbon\Carbon;


class LokasiSeeder extends Seeder
{
    public function run()
    {
        Lokasi::insert([
            [
                'kota_id' => 1,
                'type' => 'Kampus',
                'nama_lokasi' => 'Kampus 1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kota_id' => 1,
                'type' => 'Kampus',
                'nama_lokasi' => 'Kampus 2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
