<?php

namespace App\Imports;

use App\Models\Kompetensi;
use App\Models\Topik;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ImportTaggingPembelajaranKompetensiReverse implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    public function collection(Collection $collection)
    {
        Validator::make($collection->toArray(), [
            '*.nama_kompetensi' => 'required',
            '*.nama_pembelajaran' => 'required',
        ])->validate();

        $errors = [];
        $dataToInsert = [];

        foreach ($collection as $index => $row) {
            $baris = $index + 2; // Menyesuaikan dengan nomor baris di Excel
            $kompetensi = Kompetensi::where('nama_kompetensi', $row['nama_kompetensi'])->first();
            $topik = Topik::where('nama_topik', $row['nama_pembelajaran'])->first();

            if (!$kompetensi || !$topik) {
                $errors[] = "Baris {$baris}: Kompetensi atau Topik tidak ditemukan.";
                continue;
            }

            // Cek apakah kombinasi sudah ada di database
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

        // Jika ada error, batalkan seluruh proses import
        if (!empty($errors)) {
            throw ValidationException::withMessages(['error' => $errors]);
        }

        // Insert batch jika tidak ada duplikasi
        if (!empty($dataToInsert)) {
            DB::table('tagging_pembelajaran_kompetensi')->insert($dataToInsert);
        }
    }
}
