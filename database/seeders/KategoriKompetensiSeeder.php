<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KategoriKompetensiSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            'Akuntan Negara',
            'Cross Khusus',
            'Cross Pengawasan',
            'Cross Umum',
            'Hukum',
            'Investigasi',
            'Keuangan',
            'Keuangan Daerah',
            'Manajemen Kinerja, Organisasi dan Tata Kelola',
            'Pembinaan JFA',
            'Pendidikan & Pelatihan',
            'Penelitian & Pengembangan',
            'SDM',
            'Teknologi Informasi',
            'Umum',
        ];

        foreach ($datas as $nama) {
            DB::table('kategori_kompetensi')->insert([
                'nama_kategori_kompetensi' => $nama,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
