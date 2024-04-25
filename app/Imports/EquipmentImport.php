<?php

namespace App\Imports;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\EquipmentLocation;
use App\Models\Nomenklatur;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Auth;
use DateTime;
use Illuminate\Support\Facades\DB;

class EquipmentImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        Validator::make($collection->toArray(), [
            '*.barcode' => 'required|min:1|max:100|unique:equipment,barcode',
            '*.code_nomenklatur' => 'required|exists:App\Models\Nomenklatur,code_nomenklatur',
            '*.equipment_category' => 'required|exists:App\Models\EquipmentCategory,category_name',
            '*.manufacturer' => 'required|min:1|max:255',
            '*.type' => 'required|min:1|max:255',
            '*.serial_number' => 'required|min:1|max:255|unique:equipment,serial_number',
            '*.vendor' => 'required|exists:App\Models\Vendor,name_vendor',
            '*.condition' => 'required',
            '*.risk_level' => 'required',
            '*.code_location' => 'required',
            '*.financing_code' => 'required|min:1|max:255',
            '*.tanggal_pembelian' => 'required',
            '*.metode_penyusutan' => 'required|in:Garis Lurus,Saldo Menurun',
            '*.nilai_perolehan' => 'required|numeric',
            '*.nilai_residu' => 'required|numeric',
            '*.masa_manfaat' => 'required|numeric'
        ])->validate();
        foreach ($collection as $row) {
            if (is_numeric($row['tanggal_pembelian'])) {
                $tgl_beli = self::convertTglFromExcel($row['tanggal_pembelian']);
            } else {
                $tgl_beli = null;
            }
            $equipment = Equipment::create([
                'barcode' => $row['barcode'],
                'nomenklatur_id' => Nomenklatur::where('code_nomenklatur', $row['code_nomenklatur'])->first()->id,
                'equipment_category_id' => EquipmentCategory::where('category_name', $row['equipment_category'])->first()->id,
                'manufacturer' => $row['manufacturer'],
                'type' => $row['type'],
                'vendor_id' => Vendor::where('name_vendor', $row['vendor'])->first()->id,
                'condition' => $row['condition'],
                'risk_level' => $row['risk_level'],
                'equipment_location_id' => EquipmentLocation::where('code_location', $row['code_location'])->first()->id,
                'financing_code' => $row['financing_code'],
                'serial_number' => $row['serial_number'],
                'tgl_pembelian' =>  $tgl_beli ,
                'metode' => $row['metode_penyusutan'],
                'nilai_perolehan' => $row['nilai_perolehan'],
                'nilai_residu' => $row['nilai_residu'],
                'masa_manfaat' => $row['masa_manfaat'],
                'hospital_id' => Auth::user()->roles->first()->hospital_id,
            ]);
            $insertedId = $equipment->id;
            if ($equipment) {
                // save price resuction
                if ($row['metode_penyusutan'] == 'Garis Lurus') {
                    $tgl_awal = date('Y-m-d', strtotime('+0 month', strtotime($tgl_beli)));
                    $penambahan = '+' . $row['masa_manfaat'] . ' year';
                    $end_tgl = date('Y-m-d', strtotime($penambahan, strtotime($tgl_beli)));
                    $x = ($row['nilai_perolehan'] - $row['nilai_residu']) / $row['masa_manfaat'];
                    $i = 0;

                    while ($tgl_awal <= $end_tgl) {
                        $dataPenyusutan = [
                            'equipment_id' => $insertedId,
                            'periode' => $tgl_awal,
                            'month' => substr($tgl_awal, 0, 7),
                            'total_penyusutan' => round(($i / 12) * $x, 3),
                            'nilai_buku' => $row['nilai_perolehan'] - round(($i / 12) * $x, 3)
                        ];
                        DB::table('equipment_reduction_price')->insert(
                            $dataPenyusutan
                        );
                        $tgl_awal = date('Y-m-d', strtotime('+1 month', strtotime($tgl_awal)));
                        $i++;
                    }
                } else {
                    $tgl_awal = date('Y-m-d', strtotime('+0 month', strtotime($tgl_beli)));
                    $penambahan = '+' . $row['masa_manfaat'] . ' year';
                    $end_tgl = date('Y-m-d', strtotime($penambahan, strtotime($tgl_beli)));
                    $PersentasePenyusutan = (2 * (100 / $row['masa_manfaat'])) / 100; // 0.5
                    $awalPenyusutan = ($PersentasePenyusutan * $row['nilai_perolehan']) / 12;
                    $totalPenyusutan = 0;
                    $perolehan = $row['nilai_perolehan'];
                    $nilaiBukuSekarang = $perolehan;
                    $i = substr($tgl_awal, 5, 2) - 1;
                    while ($tgl_awal <= $end_tgl) {
                        $dataPenyusutan = [
                            'equipment_id' => $insertedId,
                            'periode' => $tgl_awal,
                            'month' => substr($tgl_awal, 0, 7),
                            'total_penyusutan' => round($totalPenyusutan, 3),
                            'nilai_buku' => round($nilaiBukuSekarang, 3)
                        ];
                        DB::table('equipment_reduction_price')->insert(
                            $dataPenyusutan
                        );

                        $tgl_awal = date('Y-m-d', strtotime('+1 month', strtotime($tgl_awal)));
                        $i++;
                        if ($i > 12) {
                            $awalPenyusutan = ($PersentasePenyusutan * $nilaiBukuSekarang) / 12;
                            $nilaiBukuSekarang = $nilaiBukuSekarang - $awalPenyusutan;
                            $totalPenyusutan = $totalPenyusutan + $awalPenyusutan;
                            $i = 1;
                        } else {
                            $totalPenyusutan = $totalPenyusutan + $awalPenyusutan;
                            $nilaiBukuSekarang = $perolehan - $totalPenyusutan;
                        }
                    }
                }
            }
        }
    }

    public static function convertTglFromExcel($num)
    {
        $excel_date = $num; //here is that value 41621 or 41631
        $unix_date = ($excel_date - 25569) * 86400;
        $excel_date = 25569 + ($unix_date / 86400);
        $unix_date = ($excel_date - 25569) * 86400;
        return gmdate("Y-m-d", $unix_date);
    }
}
