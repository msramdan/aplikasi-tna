<?php

namespace App\FormatImport;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GenerateTopikMultiSheet implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
            0 => new GenerateTopikFormat(),
            1 => new ReferencesRumpunPembelajaran(),
        ];
    }
}
