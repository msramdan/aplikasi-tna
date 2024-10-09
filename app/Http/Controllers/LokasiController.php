<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

class LokasiController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:lokasi view')->only('index');
    }


    public function index()
    {

        if (request()->ajax()) {
            $endpoint_pusdiklatwap = config('stara.endpoint_pusdiklatwap');
            $api_key_pusdiklatwap = config('stara.api_token_pusdiklatwap');
            $diklatLocation_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/diklatLocation', [
                'api_key' => $api_key_pusdiklatwap
            ]);

            return Datatables::of($diklatLocation_data)
                ->addIndexColumn()
                ->addColumn('MaxKelas', function ($row) {
                    return $row['MaxKelas'] . ' Kelas';
                })
                ->toJson();
        }
        return view('lokasi.index');
    }
}
