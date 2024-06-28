<?php

namespace App\Imports;

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
        dd('here');
        Validator::make($collection->toArray(), [
            '*.nama_topik' => 'required',
        ])->validate();
        foreach ($collection as $row) {
            DB::table('topik')->insert([
                'nama_topik' => $row['nama_topik'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
