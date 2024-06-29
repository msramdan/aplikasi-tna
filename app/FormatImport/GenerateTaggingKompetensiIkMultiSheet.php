<?php

namespace App\FormatImport;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GenerateTaggingKompetensiIkMultiSheet implements WithMultipleSheets
{
    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }


    public function sheets(): array
    {
        return [
            0 => new GenerateTaggingIkFormat($this->type),
            1 => new ReferencesKompetensi(),
            2 => new ReferencesIK($this->type),
        ];
    }
}
