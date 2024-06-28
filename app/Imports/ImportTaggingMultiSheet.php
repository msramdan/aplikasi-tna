<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportTaggingMultiSheet implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ImportTaggingPembelajaranKompetensi()
        ];
    }
}
