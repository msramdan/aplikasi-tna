<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;

class EmployeeImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        Validator::make($collection->toArray(), [
            '*.name' => 'required|min:1|max:200',
            '*.nid_employee' => 'required|min:1|max:50',
            '*.employee_type' => 'required|exists:App\Models\EmployeeType,name_employee_type',
            '*.employee_status' => 'required|in:Aktif,Non Aktif',
            '*.department' => 'required|exists:App\Models\Department,name_department',
            '*.position' => 'required|exists:App\Models\Position,name_position',
            '*.email' => 'required|min:1|max:100',
            '*.phone' => 'required|min:1|max:15',
            '*.address' => 'required',
            '*.join_date' => 'required|date_format:d/m/Y',
            '*.zip_kode' => 'required|min:1|max:10',
        ])->validate();


        foreach ($collection as $row) {
            Employee::create([
                'name' => $row['name'],
                'nid_employee' => $row['nid_employee'],
                'employee_type_id' => EmployeeType::where('name_employee_type', $row['employee_type'])->first()->id,
                'employee_status' => $row['employee_status'] == 'Aktif' ? true : false,
                'departement_id' => Department::where('name_department', $row['department'])->first()->id,
                'position_id' => Position::where('name_position', $row['position'])->first()->id,
                'email' => $row['email'],
                'phone' => $row['phone'],
                'join_date' => Carbon::createFromFormat('d/m/Y', $row['join_date'])->format('Y-m-d'),
                'address' => $row['address'],
                'zip_kode' => $row['zip_kode'],
                'hospital_id' => Auth::user()->roles->first()->hospital_id,
            ]);
        }
    }
}
