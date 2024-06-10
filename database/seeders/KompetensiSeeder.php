<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kompetensi;

class KompetensiSeeder extends Seeder
{
    public function run()
    {
        Kompetensi::factory()->count(200)->create();
    }
}
