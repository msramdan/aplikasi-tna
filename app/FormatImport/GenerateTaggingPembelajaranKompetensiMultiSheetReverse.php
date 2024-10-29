<?php

namespace App\FormatImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GenerateTaggingPembelajaranKompetensiMultiSheetReverse implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new GenerateTaggingFormatReverse(),
            2 => new ReferencesKompetensi(),
            1 => new ReferencesPembelajaran()
        ];
    }
}
