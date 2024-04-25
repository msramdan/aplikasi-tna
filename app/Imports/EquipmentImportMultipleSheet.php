<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EquipmentImportMultipleSheet implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new EquipmentImport()
        ];
    }
}
