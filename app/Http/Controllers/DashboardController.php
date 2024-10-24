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
        // Menghitung total user
        $totalUser = DB::table('users')->count();

        // Mengambil data lokasi dari API eksternal
        $endpoint_pusdiklatwap = config('stara.endpoint_pusdiklatwap');
        $api_key_pusdiklatwap = config('stara.api_token_pusdiklatwap');
        $totalLokasi = callApiPusdiklatwas($endpoint_pusdiklatwap . '/diklatLocation', [
            'api_key' => $api_key_pusdiklatwap
        ]);

        // Menghitung total lokasi
        $countTotalLokasi = is_array($totalLokasi) ? count($totalLokasi) : 0;

        // Mengambil tahun yang dipilih dari query string
        $tahunSelected = $request->query('tahun');
        if ($tahunSelected != null) {
            $tahun = $tahunSelected;
        } else {
            $jadwalKapTahunan = DB::table('jadwal_kap_tahunan')
                ->orderBy('id', 'desc')
                ->first();
            $tahun = $jadwalKapTahunan ? $jadwalKapTahunan->tahun : date('Y');
        }

        // Daftar status default yang ingin ditampilkan
        $defaultStatuses = ['Pending', 'Revision', 'Process', 'Approved', 'Rejected'];

        // Query data status dari database dengan filter tahun
        $data = DB::table('pengajuan_kap')
            ->select('status_pengajuan', DB::raw('count(*) as total'))
            ->when($tahun, function ($query) use ($tahun) {
                return $query->where('tahun', $tahun);
            })
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

        // Query untuk mengambil data berdasarkan institusi_sumber (BPKP dan Non BPKP) dan tahun
        $pengajuanData = DB::table('pengajuan_kap')
            ->select(
                'tahun',
                DB::raw('SUM(CASE WHEN institusi_sumber = "BPKP" THEN 1 ELSE 0 END) as totalBPKP'),
                DB::raw('SUM(CASE WHEN institusi_sumber = "Non BPKP" THEN 1 ELSE 0 END) as totalNonBPKP')
            )
            ->when($tahunSelected, function ($query) use ($tahunSelected) {
                return $query->where('tahun', $tahunSelected);
            })
            ->groupBy('tahun')
            ->get();

        // Inisialisasi array untuk labels (tahun) dan total untuk BPKP dan Non BPKP
        $labelsTahun = [];
        $totalsBPKP = [];
        $totalsNonBPKP = [];

        // Isi array dengan data dari query
        foreach ($pengajuanData as $row) {
            $labelsTahun[] = $row->tahun;
            $totalsBPKP[] = $row->totalBPKP;
            $totalsNonBPKP[] = $row->totalNonBPKP;
        }

        return view('dashboard', [
            'year' => $tahun,
            'totalUser' => $totalUser,
            'totalLokasi' => $countTotalLokasi,
            'labels' => $labels, // Labels untuk chart status
            'totals' => $totals, // Totals untuk chart status
            'labelsTahun' => $labelsTahun, // Labels (tahun) untuk chart BPKP/Non BPKP
            'totalsBPKP' => $totalsBPKP, // Totals BPKP berdasarkan tahun
            'totalsNonBPKP' => $totalsNonBPKP // Totals Non BPKP berdasarkan tahun
        ]);
    }
}
