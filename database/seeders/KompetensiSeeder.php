<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kompetensi;

class KompetensiSeeder extends Seeder
{
    public function run()
    {
        $kompetensis = Kompetensi::factory()->count(10)->create();

        $kompetensis->each(function ($kompetensi) {
            for ($level = 1; $level <= 5; $level++) {
                DB::table('kompetensi_detail')->insert([
                    'kompetensi_id' => $kompetensi->id,
                    'level' => $level,
                    'deskripsi_level' => "Deskripsi untuk level $level",
                    'indikator_perilaku' => "Indikator perilaku untuk level $level",
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
