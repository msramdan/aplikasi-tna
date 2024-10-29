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

class ImportTaggingPembelajaranKompetensiReverse implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;
    public function collection(Collection $collection)
    {
        Validator::make($collection->toArray(), [
            '*.nama_kompetensi' => 'required',
            '*.nama_pembelajaran' => 'required',
        ])->validate();

        foreach ($collection as $row) {
            DB::table('tagging_pembelajaran_kompetensi')->insert([
                'kompetensi_id' => Kompetensi::where('nama_kompetensi', $row['nama_kompetensi'])->first()->id,
                'topik_id' => Topik::where('nama_topik', $row['nama_pembelajaran'])->first()->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
