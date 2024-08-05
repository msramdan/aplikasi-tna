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
            '*.kompetensi_dasar' => 'required',
            '*.level' => 'required',
            '*.deskripsi_level' => 'required',
            '*.indikator_perilaku' => 'required',
        ])->validate();

        $kelompokBesar = DB::table('kelompok_besar')->pluck('id', 'nama_kelompok_besar')->toArray();
        $akademi = DB::table('akademi')->pluck('id', 'nama_akademi')->toArray();
        $kategoriKompetensi = DB::table('kategori_kompetensi')->pluck('id', 'nama_kategori_kompetensi')->toArray();

        foreach ($collection as $row) {
            $kelompokBesarId = $kelompokBesar[$row['kelompok_besar']] ?? null;
            $akademiId = $akademi[$row['akademi']] ?? null;
            $kategoriKompetensiId = $kategoriKompetensi[$row['kategori']] ?? null;
            // cek ada atw tidak di table kompetensi nama kompetensi
            $cekData = DB::table('kompetensi')
                ->where('nama_kompetensi', $row['nama_kompetensi'])
                ->first();
            // Jika nama kompetensi belum ada, sisipkan data baru
            if (!$cekData) {
                $kompetensiId = DB::table('kompetensi')->insertGetId([
                    'kelompok_besar_id' => $kelompokBesarId,
                    'kategori_kompetensi_id' => $kategoriKompetensiId,
                    'akademi_id' => $akademiId,
                    'nama_kompetensi' => $row['nama_kompetensi'],
                    'deskripsi_kompetensi' => $row['kompetensi_dasar'],
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
