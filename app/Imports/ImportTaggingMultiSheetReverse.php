<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportTaggingMultiSheetReverse implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ImportTaggingPembelajaranKompetensi()
        ];
    }
}