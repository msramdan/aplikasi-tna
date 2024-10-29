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

        // Get the selected month and year for visitor filtering
        $tahunVisitorSelected = $request->query('tahunVisitor');
        if ($tahunVisitorSelected != null) {
            $tahunVisitor = $tahunVisitorSelected;
        } else {
            $currentYear = date('Y');
            $currentMonth = date('m');
            $tahunVisitor = $currentYear . '-' . $currentMonth;
        }

        // Split year and month for the query
        [$selectedYear, $selectedMonth] = explode('-', $tahunVisitor);

        // Get the number of days in the selected month
        $isCurrentMonth = ($selectedYear == date('Y') && $selectedMonth == date('m'));
        $daysInMonth = $isCurrentMonth ? date('d') : date('t', strtotime("$selectedYear-$selectedMonth-01"));

        // Initialize labelsTanggal with all dates of the month (in Y-m-d format for querying)
        $dates = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dates[] = sprintf('%04d-%02d-%02d', $selectedYear, $selectedMonth, $day);
        }

        // Query daily visitor count based on `log_auth` and `Login` event within the selected month and year
        $visitorData = DB::table('activity_log')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->where('log_name', 'log_auth')
            ->where('event', 'Login')
            ->whereYear('created_at', $selectedYear)
            ->whereMonth('created_at', $selectedMonth)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('total', 'date'); // Pluck results to get an associative array [date => total]

        // Fill totalVisitor array with login counts, defaulting to 0 where no data exists
        $totalVisitor = [];
        $labelsTanggal = [];
        foreach ($dates as $date) {
            $labelsTanggal[] = date('d-m-Y', strtotime($date)); // Convert to DD-MM-YYYY for chart display
            $totalVisitor[] = $visitorData[$date] ?? 0; // Use query result or default to 0
        }


        return view('dashboard', [
            'year' => $tahun,
            'totalUser' => $totalUser,
            'totalLokasi' => $countTotalLokasi,
            'labels' => $labels,
            'totals' => $totals,
            'labelsTahun' => $labelsTahun,
            'totalsBPKP' => $totalsBPKP,
            'totalsNonBPKP' => $totalsNonBPKP,
            'tahunVisitor' => $tahunVisitor,
            'labelsTanggal' => $labelsTanggal,
            'totalVisitor' => $totalVisitor,
        ]);
    }
}
