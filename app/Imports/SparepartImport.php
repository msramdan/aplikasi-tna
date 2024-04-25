<?php

namespace App\Imports;

use App\Models\Sparepart;
use App\Models\UnitItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;

class SparepartImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{

    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        Validator::make(
            $collection->toArray(),
            [
                '*.barcode' => 'required|min:1|max:200|unique:spareparts,barcode',
                '*.sparepart_name' => 'required|min:1|max:200',
                '*.merk' => 'required|min:1|max:200',
                '*.sparepart_type' => 'required|min:1|max:200',
                '*.unit_item' => 'required|exists:App\Models\UnitItem,unit_name',
                '*.estimated_price' => 'required|numeric',
                '*.opname' => 'required|numeric',
            ],
        )->validate();

        foreach ($collection as $row) {
            Sparepart::create([
                'barcode' => $row['barcode'],
                'sparepart_name' => $row['sparepart_name'],
                'merk' => $row['merk'],
                'sparepart_type' => $row['sparepart_type'],
                'unit_id' => UnitItem::where('unit_name', $row['unit_item'])->first()->id,
                'estimated_price' => $row['estimated_price'],
                'opname' => $row['opname'],
                'stock' => 0,
                'hospital_id' => Auth::user()->roles->first()->hospital_id,
            ]);
        }
    }
}
