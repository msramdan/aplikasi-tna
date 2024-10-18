<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;



class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalUser = DB::table('users')->count();

        $endpoint_pusdiklatwap = config('stara.endpoint_pusdiklatwap');
        $api_key_pusdiklatwap = config('stara.api_token_pusdiklatwap');
        $totalLokasi = callApiPusdiklatwas($endpoint_pusdiklatwap . '/diklatLocation', [
            'api_key' => $api_key_pusdiklatwap
        ]);

        if (is_array($totalLokasi)) {
            $countTotalLokasi = count($totalLokasi);
        } else {
            $countTotalLokasi = 0;
        }

        // Daftar status default yang ingin kamu tampilkan
        $defaultStatuses = ['Pending', 'Revision', 'Process', 'Approved', 'Rejected'];

        // Query data dari database
        $data = DB::table('pengajuan_kap')
            ->select('status_pengajuan', DB::raw('count(*) as total'))
            ->groupBy('status_pengajuan')
            ->get();

        // Buat array dengan status default dan nilai 0
        $statusData = array_fill_keys($defaultStatuses, 0);

        // Isi data dari query ke dalam array
        foreach ($data as $row) {
            $statusData[$row->status_pengajuan] = $row->total;
        }

        // Pisahkan labels dan data untuk digunakan di chart
        $labels = array_keys($statusData); // Mengambil semua status
        $totals = array_values($statusData); // Mengambil total data per status

        return view('dashboard', [
            'totalUser' => $totalUser,
            'totalLokasi' => $countTotalLokasi,
            'labels' => $labels,
            'totals' => $totals
        ]);
    }
}
