<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportTaggingIkMultiSheetReverse implements WithMultipleSheets
{
    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function sheets(): array
    {
        return [
            new ImportTaggingKompetensiIk($this->type)
        ];
    }
}
