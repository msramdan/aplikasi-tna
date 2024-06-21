<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class ImportKompetensi implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;
    public function collection(Collection $collection)
    {
        Validator::make($collection->toArray(), [
            '*.kelompok_besar' => 'required',
            '*.kategori' => 'required',
            '*.akademi' => 'required',
            '*.nama_kompetensi' => 'required',
            '*.deskripsi_kompetensi' => 'required',
            '*.level' => 'required',
            '*.deskripsi_level' => 'required',
            '*.indikator_perilaku' => 'required',
        ])->validate();

        foreach ($collection as $row) {
            // cek ada atw tidak di table kompetensi nama kompetensi
            $cekData = DB::table('kompetensi')
                ->where('nama_kompetensi', $row['nama_kompetensi'])
                ->first();
            // Jika nama kompetensi belum ada, sisipkan data baru
            if (!$cekData) {
                $kompetensiId = DB::table('kompetensi')->insertGetId([
                    'nama_kompetensi' => $row['nama_kompetensi'],
                    'deskripsi_kompetensi' => $row['deskripsi_kompetensi'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                // baru insert kompetensi_detail
                DB::table('kompetensi_detail')->insert([
                    'kompetensi_id' => $kompetensiId,
                    'level' => $row['level'],
                    'deskripsi_level' => $row['deskripsi_level'],
                    'indikator_perilaku' => $row['indikator_perilaku'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                // klo ada langsung insert kompetensi_detail
                DB::table('kompetensi_detail')->insert([
                    'kompetensi_id' => $cekData->id,
                    'level' => $row['level'],
                    'deskripsi_level' => $row['deskripsi_level'],
                    'indikator_perilaku' => $row['indikator_perilaku'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
