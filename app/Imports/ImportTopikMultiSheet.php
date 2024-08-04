<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportTopikMultiSheet implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ImportTopik()
        ];
    }
}
