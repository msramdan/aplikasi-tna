<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengumuman')->insert([
            'pengumuman' => 'Guys, yuk usulin pembelajaran buat tahun {placeholder_tahun}! Lengkapi Kerangka Acuan Pembelajaran (KAP) di aplikasi ini. Info lebih lanjut seperti manual book aplikasi Interna, VPN & panduan instalasinya, bahan paparan learning partner forum, dan wifi & password aula, titik kritis pengusulan pembelajaran, dan FAQ, cek link ini yaa https://bit.ly/LPF102024.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
