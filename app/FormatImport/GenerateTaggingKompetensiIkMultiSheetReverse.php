<?php

namespace App\FormatImport;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GenerateTaggingKompetensiIkMultiSheetReverse implements WithMultipleSheets
{
    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }


    public function sheets(): array
    {
        return [
            0 => new GenerateTaggingIkFormatReverse($this->type),
            1 => new ReferencesIK($this->type),
            2 => new ReferencesKompetensi(),
        ];
    }
}
