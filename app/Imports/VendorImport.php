<?php

namespace App\Imports;

use App\Models\CategoryVendor;
use App\Models\Vendor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;

class VendorImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
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
                '*.code_vendor' => 'required|min:1|max:20|unique:vendors,code_vendor',
                '*.name_vendor' => 'required|min:1|max:200',
                '*.category_vendor' => 'required|exists:App\Models\CategoryVendor,name_category_vendors',
                '*.email' => 'required|min:1|max:100',
                '*.address' => 'required',
                '*.zip_kode' => 'required|min:1|max:5',
            ],
        )->validate();

        foreach ($collection as $row) {
            Vendor::create([
                'code_vendor' => $row['code_vendor'],
                'name_vendor' => $row['name_vendor'],
                'category_vendor_id' => CategoryVendor::where('name_category_vendors', $row['category_vendor'])->first()->id,
                'email' => $row['email'],
                'address' => $row['address'],
                'zip_kode' => $row['zip_kode'],
                'hospital_id' => Auth::user()->roles->first()->hospital_id,
            ]);
        }
    }
}
