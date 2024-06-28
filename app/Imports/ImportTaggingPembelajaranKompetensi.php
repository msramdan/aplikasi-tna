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

class ImportTaggingPembelajaranKompetensi implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;
    public function collection(Collection $collection)
    {
        Validator::make($collection->toArray(), [
            '*.nama_pembelajaran' => 'required',
            '*.nama_kompetensi' => 'required',
        ])->validate();


        foreach ($collection as $row) {
            $insert = DB::table('tagging_pembelajaran_kompetensi')->insert([
                'topik_id' => Topik::where('nama_topik', $row['nama_pembelajaran'])->first()->id,
                'kompetensi_id' => Kompetensi::where('nama_kompetensi', $row['nama_kompetensi'])->first()->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
