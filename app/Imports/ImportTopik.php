<?php

namespace App\Imports;

use App\Models\RumpunPembelajaran;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class ImportTopik implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;
    public function collection(Collection $collection)
    {
        Validator::make($collection->toArray(), [
            '*.rumpun_pembelajaran' => 'required',
            '*.program_pembelajaran' => 'required',
        ])->validate();
        // dd($collection);

        foreach ($collection as $row) {
            // dd($row['program_pembelajaran']);

            DB::table('topik')->insert([
                'rumpun_pembelajaran_id' => RumpunPembelajaran::where('rumpun_pembelajaran', $row['rumpun_pembelajaran'])->first()->id,
                'nama_topik' => $row['program_pembelajaran'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
