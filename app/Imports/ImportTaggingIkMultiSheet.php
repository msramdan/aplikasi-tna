<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportTaggingIkMultiSheet implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ImportTaggingPembelajaranKompetensi()
        ];
    }
}
