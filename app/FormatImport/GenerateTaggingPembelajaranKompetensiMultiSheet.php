<?php

namespace App\FormatImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GenerateTaggingPembelajaranKompetensiMultiSheet implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new GenerateTaggingFormat(),
            1 => new ReferencesPembelajaran(),
            2 => new ReferencesKompetensi()
        ];
    }
}
