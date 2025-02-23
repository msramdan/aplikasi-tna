<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Topik;
use App\Models\Kompetensi;
use Illuminate\Validation\ValidationException;

class ImportTaggingPembelajaranKompetensi implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    public function collection(Collection $collection)
    {
        Validator::make($collection->toArray(), [
            '*.nama_pembelajaran' => 'required',
            '*.nama_kompetensi' => 'required',
        ])->validate();

        $errors = [];
        $dataToInsert = [];

        foreach ($collection as $index => $row) {
            $baris = $index + 2; // Karena baris pertama adalah heading di Excel
            $topik = Topik::where('nama_topik', $row['nama_pembelajaran'])->first();
            $kompetensi = Kompetensi::where('nama_kompetensi', $row['nama_kompetensi'])->first();

            if (!$topik || !$kompetensi) {
                $errors[] = "Baris {$baris}: Topik atau Kompetensi tidak ditemukan.";
                continue;
            }

            // Cek apakah kombinasi sudah ada di database
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
