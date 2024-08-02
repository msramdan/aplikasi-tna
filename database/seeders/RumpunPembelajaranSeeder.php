<?php

namespace Database\Seeders;

use App\Models\RumpunPembelajaran;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RumpunPembelajaranSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'Akuntabilitas Kinerja Instansi Pemerintah',
            'Analisis Data',
            'Barang Milik Negara/Daerah/Desa',
            'Hukum',
            'Kapabilitas APIP',
            'Kebijakan Publik',
            'Keinvestigasian',
            'Kerja Sama Pemerintah dengan Badan Usaha',
            'Keuangan Desa',
            'Keuangan Negara/Daerah',
            'Komunikasi',
            'Korporasi/BLU(D)',
            'Laporan Keuangan Pemerintah Pusat/Daerah',
            'Manajemen Pembelajaran',
            'Manajemen Risiko',
            'Manajerial',
            'Pendapatan Asli Daerah',
            'Penerimaan Negara',
            'Pengadaan Barang/Jasa Pemerintah',
            'Peningkatan Penggunaan Produksi Dalam Negeri (P3DN)',
            'Perencanaan dan Penganggaran',
            'Reformasi Birokrasi / Wilayah Bebas Korupsi (WBK) / Wilayah Birokrasi Bersih dan Melayani (WBBM)',
            'SDM',
            'Sistem Pengendalian Intern Pemerintah (SPIP)',
            'Sistematika Audit Intern (KKA, LHA, dll)',
            'Teknologi Informasi dan Komunikasi'
        ];
        $insertData = array_map(function ($item) {
            return [
                'rumpun_pembelajaran' => $item,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }, $data);

        RumpunPembelajaran::insert($insertData);
    }
}
