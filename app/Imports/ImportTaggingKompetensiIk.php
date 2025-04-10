<?php

namespace App\Imports;

use App\Models\Kompetensi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportTaggingKompetensiIk implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function collection(Collection $collection)
    {
        // Custom label untuk validasi
        $attributes = [];
        foreach ($collection as $index => $row) {
            $baris = $index + 2;
            $attributes["{$index}.nama_kompetensi"] = "Nama Kompetensi pada baris ke-{$baris}";
            $attributes["{$index}.indikator_kinerja"] = "Indikator Kinerja pada baris ke-{$baris}";
        }

        // Validasi field kosong
        Validator::make(
            $collection->toArray(),
            [
                '*.nama_kompetensi' => 'required',
                '*.indikator_kinerja' => 'required',
            ],
            [
                '*.nama_kompetensi.required' => ':attribute wajib diisi.',
                '*.indikator_kinerja.required' => ':attribute wajib diisi.',
            ],
            $attributes
        )->validate();

        $errors = [];
        $dataToInsert = [];

        foreach ($collection as $index => $row) {
            $baris = $index + 2;

            $namaKompetensi = ltrim($row['nama_kompetensi']);
            $indikatorKinerja = ltrim($row['indikator_kinerja']);

            $kompetensi = Kompetensi::where('nama_kompetensi', $namaKompetensi)->first();

            if (!$kompetensi) {
                $errors[] = "Baris {$baris}: Nama kompetensi '{$namaKompetensi}' tidak ditemukan di database.";
                continue;
            }

            $exists = DB::table('tagging_kompetensi_ik')
                ->where('kompetensi_id', $kompetensi->id)
                ->where('indikator_kinerja', $indikatorKinerja)
                ->where('type', $this->type)
                ->exists();

            if ($exists) {
                $errors[] = "Baris {$baris}: Data sudah ada di database.";
                continue;
            }

            $dataToInsert[] = [
                'kompetensi_id' => $kompetensi->id,
                'indikator_kinerja' => $indikatorKinerja,
                'type' => $this->type,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Gagalkan seluruh proses jika ada error
        if (!empty($errors)) {
            throw ValidationException::withMessages(['error' => $errors]);
        }

        // Insert jika semua data valid
        if (!empty($dataToInsert)) {
            DB::table('tagging_kompetensi_ik')->insert($dataToInsert);
        }
    }
}
