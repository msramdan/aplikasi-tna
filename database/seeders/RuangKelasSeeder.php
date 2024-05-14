<?php

namespace Database\Seeders;
use App\Models\RuangKelas;
use Illuminate\Database\Seeder;
use Carbon\Carbon;



class RuangKelasSeeder extends Seeder
{
    public function run()
    {
        RuangKelas::insert([
            [
                'nama_kelas' => 'Kelas 1A',
                'lokasi_id' => 1,
                'kuota' => 30,
                'status_ruang_kelas' => 'Available',
                'keterangan' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
