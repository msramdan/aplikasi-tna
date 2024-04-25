<?php

namespace App\Imports;

use App\Models\Nomenklatur;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NomenklaturImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        Validator::make(
            $collection->toArray(),
            [
                '*.code_nomenklatur' => 'required|min:1|max:50',
                '*.name_nomenklatur' => 'required|string|min:1|max:255',
            ],
        )->validate();

        foreach ($collection as $row) {
            Nomenklatur::create([
                'code_nomenklatur' => $row['code_nomenklatur'],
                'name_nomenklatur' => $row['name_nomenklatur'],
            ]);
        }
    }
    public function chunkSize(): int
    {
        return 50;
    }
}
