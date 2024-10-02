<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KompetensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kompetensi')->insert([
            [
                'kelompok_besar_id' => null, // Ubah sesuai ID kelompok_besar terkait
                'kategori_kompetensi_id' => null, // Ubah sesuai ID kategori_kompetensi terkait
                'akademi_id' => null, // Ubah sesuai ID akademi terkait
                'nama_kompetensi' => 'Standar Audit',
                'deskripsi_kompetensi' => null,
                'is_apip' => 'Yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelompok_besar_id' => null,
                'kategori_kompetensi_id' => null,
                'akademi_id' => null,
                'nama_kompetensi' => 'Tata Kelola Manajemen Risiko Pengendalian Intern',
                'deskripsi_kompetensi' => null,
                'is_apip' => 'Yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelompok_besar_id' => null,
                'kategori_kompetensi_id' => null,
                'akademi_id' => null,
                'nama_kompetensi' => 'Analisis Proses Bisnis',
                'deskripsi_kompetensi' => null,
                'is_apip' => 'Yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelompok_besar_id' => null,
                'kategori_kompetensi_id' => null,
                'akademi_id' => null,
                'nama_kompetensi' => 'Pelaksanaan Pengawasan Intern',
                'deskripsi_kompetensi' => null,
                'is_apip' => 'Yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelompok_besar_id' => null,
                'kategori_kompetensi_id' => null,
                'akademi_id' => null,
                'nama_kompetensi' => 'Pengembangan Metodologi Pengawasan',
                'deskripsi_kompetensi' => null,
                'is_apip' => 'Yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelompok_besar_id' => null,
                'kategori_kompetensi_id' => null,
                'akademi_id' => null,
                'nama_kompetensi' => 'Manajemen Pengawasan Intern',
                'deskripsi_kompetensi' => null,
                'is_apip' => 'Yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
