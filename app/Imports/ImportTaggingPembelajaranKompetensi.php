<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\Importable;
use App\Models\Topik;
use App\Models\Kompetensi;

class ImportTaggingPembelajaranKompetensi implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    public function collection(Collection $collection)
    {
        // Siapkan label per baris
        $attributes = [];
        foreach ($collection as $index => $row) {
            $baris = $index + 2;
            $attributes["{$index}.nama_pembelajaran"] = "Nama Pembelajaran pada baris ke-{$baris}";
            $attributes["{$index}.nama_kompetensi"] = "Nama Kompetensi pada baris ke-{$baris}";
        }

        // Validasi input kosong
        Validator::make(
            $collection->toArray(),
            [
                '*.nama_pembelajaran' => 'required',
                '*.nama_kompetensi' => 'required',
            ],
            [
                '*.nama_pembelajaran.required' => ':attribute wajib diisi.',
                '*.nama_kompetensi.required' => ':attribute wajib diisi.',
            ],
            $attributes
        )->validate();

        $errors = [];
        $dataToInsert = [];

        foreach ($collection as $index => $row) {
            $baris = $index + 2;
            $namaTopik = ltrim($row['nama_pembelajaran']);
            $namaKompetensi = ltrim($row['nama_kompetensi']);

            $topik = Topik::where('nama_topik', $namaTopik)->first();
            $kompetensi = Kompetensi::where('nama_kompetensi', $namaKompetensi)->first();

            if (!$topik || !$kompetensi) {
                $errors[] = "Baris {$baris}: Topik atau Kompetensi tidak ditemukan.";
                continue;
            }

            $exists = DB::table('tagging_pembelajaran_kompetensi')
                ->where('topik_id', $topik->id)
                ->where('kompetensi_id', $kompetensi->id)
                ->exists();

            if ($exists) {
                $errors[] = "Baris {$baris}: Data sudah ada di database.";
                continue;
            }

            $dataToInsert[] = [
                'topik_id' => $topik->id,
                'kompetensi_id' => $kompetensi->id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages(['error' => $errors]);
        }

        if (!empty($dataToInsert)) {
            DB::table('tagging_pembelajaran_kompetensi')->insert($dataToInsert);
        }
    }
}
