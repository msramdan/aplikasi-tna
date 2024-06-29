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

class ImportTaggingKompetensiIk implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;
    public function collection(Collection $collection)
    {
        Validator::make($collection->toArray(), [
            '*.nama_kompetensi' => 'required',
            '*.indikator_kinerja' => 'required',
        ])->validate();

        foreach ($collection as $row) {
            DB::table('tagging_kompetensi_ik')->insert([
                'topik_id' => Kompetensi::where('nama_kompetensi', $row['nama_kompetensi'])->first()->id,
                'indikator_kinerja' => $row['indikator_kinerja'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
