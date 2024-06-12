<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topik;

class TopikSeeder extends Seeder
{
    public function run()
    {
        Topik::factory()->count(10)->create();
    }
}
