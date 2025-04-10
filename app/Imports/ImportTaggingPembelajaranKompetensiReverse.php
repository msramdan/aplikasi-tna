<?php

namespace App\Imports;

use App\Models\Kompetensi;
use App\Models\Topik;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportTaggingPembelajaranKompetensiReverse implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    public function collection(Collection $collection)
    {
        // Siapkan label field per baris
        $attributes = [];
        foreach ($collection as $index => $row) {
            $baris = $index + 2;
            $attributes["{$index}.nama_kompetensi"] = "Nama Kompetensi pada baris ke-{$baris}";
            $attributes["{$index}.nama_pembelajaran"] = "Nama Pembelajaran pada baris ke-{$baris}";
        }

        // Validasi isian wajib
        Validator::make(
            $collection->toArray(),
            [
                '*.nama_kompetensi' => 'required',
                '*.nama_pembelajaran' => 'required',
            ],
            [
                '*.nama_kompetensi.required' => ':attribute wajib diisi.',
                '*.nama_pembelajaran.required' => ':attribute wajib diisi.',
            ],
            $attributes
        )->validate();

        $errors = [];
        $dataToInsert = [];

        foreach ($collection as $index => $row) {
            $baris = $index + 2;
            $namaKompetensi = ltrim($row['nama_kompetensi']);
            $namaTopik = ltrim($row['nama_pembelajaran']);

            $kompetensi = Kompetensi::where('nama_kompetensi', $namaKompetensi)->first();
            $topik = Topik::where('nama_topik', $namaTopik)->first();

            if (!$kompetensi || !$topik) {
                $errors[] = "Baris {$baris}: Kompetensi atau Topik tidak ditemukan.";
                continue;
            }

            $exists = DB::table('tagging_pembelajaran_kompetensi')
                ->where('kompetensi_id', $kompetensi->id)
                ->where('topik_id', $topik->id)
                ->exists();

            if ($exists) {
                $errors[] = "Baris {$baris}: Data sudah ada di database.";
                continue;
            }

            $dataToInsert[] = [
                'kompetensi_id' => $kompetensi->id,
                'topik_id' => $topik->id,
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
