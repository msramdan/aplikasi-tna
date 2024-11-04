<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportPengajuanKap;
use Illuminate\Support\Facades\Route;



class PengajuanKapController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pengajuan kap view')->only('index', 'show');
        // $this->middleware('permission:pengajuan kap create')->only('create', 'store');
        $this->middleware('permission:pengajuan kap edit')->only('edit', 'update');
        $this->middleware('permission:pengajuan kap delete')->only('destroy');
    }

    public function index(Request $request, $is_bpkp, $frekuensi)
    {
        if (request()->ajax()) {
            $tahun = $request->query('tahun');
            $topik = intval($request->query('topik'));
            $status_pengajuan = $request->query('status_pengajuan');
            $current_step = intval($request->query('step'));
            $unit_kerja = $request->query('unit_kerja', []);
            $prioritas = $request->query('prioritas', []);

            $pengajuanKaps = DB::table('pengajuan_kap')
                ->select(
                    'pengajuan_kap.*',
                    'users.name as user_name',
                    'users.nama_unit',
                    DB::raw('GROUP_CONCAT(DISTINCT CONCAT("<li>", kompetensi.nama_kompetensi, "</li>")) as nama_kompetensi'),
                    DB::raw('GROUP_CONCAT(DISTINCT CONCAT("<li>", pengajuan_kap_indikator_kinerja.indikator_kinerja, "</li>")) as nama_indikator'),
                    'topik.nama_topik',
                    'log_review_pengajuan_kap.remark'
                )
                ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
                ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id')
                ->leftJoin('pengajuan_kap_gap_kompetensi', 'pengajuan_kap.id', '=', 'pengajuan_kap_gap_kompetensi.pengajuan_kap_id')
                ->leftJoin('kompetensi', 'pengajuan_kap_gap_kompetensi.kompetensi_id', '=', 'kompetensi.id')
                ->leftJoin('pengajuan_kap_indikator_kinerja', 'pengajuan_kap.id', '=', 'pengajuan_kap_indikator_kinerja.pengajuan_kap_id')
                ->join('log_review_pengajuan_kap', function ($join) {
                    $join->on('pengajuan_kap.id', '=', 'log_review_pengajuan_kap.pengajuan_kap_id')
                        ->whereColumn('log_review_pengajuan_kap.step', 'pengajuan_kap.current_step');
                })
                ->where('pengajuan_kap.institusi_sumber', '=', $is_bpkp)
                ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $frekuensi)
                ->groupBy('pengajuan_kap.id', 'users.name', 'users.nama_unit', 'topik.nama_topik', 'log_review_pengajuan_kap.remark');



            // Filter based on tahun
            if (isset($tahun) && !empty($tahun) && $tahun != 'All') {
                $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.tahun', $tahun);
            }

            // Filter based on topik
            if (isset($topik) && !empty($topik) && $topik != 'All') {
                $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.topik_id', $topik);
            }
            if (isset($status_pengajuan) && !empty($status_pengajuan) && $status_pengajuan != 'All') {
                $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.status_pengajuan', $status_pengajuan);
            }

            // Filter based on current_step
            if (isset($current_step) && !empty($current_step) && $current_step != 'All') {
                $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.current_step', $current_step);
            }

            // Filter based on unit_kerja
            if (!empty($unit_kerja)) {
                $pengajuanKaps = $pengajuanKaps->whereIn('users.nama_unit', $unit_kerja);
            }

            // Filter based on prioritas_pembelajaran
            if (!empty($prioritas)) {
                $pengajuanKaps = $pengajuanKaps->whereIn('pengajuan_kap.prioritas_pembelajaran', $prioritas);
            }

            $pengajuanKaps = $pengajuanKaps->orderBy('pengajuan_kap.id', 'DESC');
            return DataTables::of($pengajuanKaps)
                ->addIndexColumn()
                ->addColumn('status_kap', function ($row) {
                    return $row->status_pengajuan;
                })
                ->addColumn('remark', function ($row) {
                    return $row->remark;
                })
                ->addColumn('nama_kompetensi', function ($row) {
                    $kompetensiList = explode(',', $row->nama_kompetensi);
                    return '<ul>' . implode('', $kompetensiList) . '</ul>';
                })

                ->addColumn('indikator_kinerja', function ($row) {
                    $indikatorKinerjaList = explode(',', $row->nama_indikator);
                    return '<ul>' . implode('', $indikatorKinerjaList) . '</ul>';
                })
                ->addColumn('status_pengajuan', function ($row) {
                    if ($row->status_pengajuan == 'Pending') {
                        return '<button style="width:90px" class="btn btn-gray btn-sm btn-block"><i class="fa fa-clock" aria-hidden="true"></i> Pending</button>';
                    } else if ($row->status_pengajuan == 'Approved') {
                        return '<button style="width:90px" class="btn btn-success btn-sm btn-block"><i class="fa fa-check" aria-hidden="true"></i> Approved</button>';
                    } else if ($row->status_pengajuan == 'Rejected') {
                        return '<button style="width:90px" class="btn btn-danger btn-sm btn-block"><i class="fa fa-times" aria-hidden="true"></i> Rejected</button>';
                    } else if ($row->status_pengajuan == 'Process') {
                        return '<button style="width:90px" class="btn btn-primary btn-sm btn-block"><i class="fa fa-spinner" aria-hidden="true"></i> Process</button>';
                    } else if ($row->status_pengajuan == 'Revision') {
                        return '<button style="width:90px" class="btn btn-gray btn-sm btn-block"><i class="fa fa-refresh" aria-hidden="true"></i> Revision</button>';
                    }
                })
                ->addColumn('prioritas_pembelajaran', function ($row) {
                    $prioritas = (int) preg_replace('/[^0-9]/', '', $row->prioritas_pembelajaran);

                    if ($prioritas > 0 && $prioritas <= 5) {
                        return '<span class="badge badge-label bg-danger badge-width"><i class="mdi mdi-circle-medium"></i> ' . $row->prioritas_pembelajaran . '</span>'; // Danger
                    } elseif ($prioritas > 5 && $prioritas <= 10) {
                        return '<span class="badge badge-label bg-warning badge-width"><i class="mdi mdi-circle-medium"></i> ' . $row->prioritas_pembelajaran . '</span>'; // Warning
                    } elseif ($prioritas > 10 && $prioritas <= 20) {
                        return '<span class="badge badge-label bg-info badge-width"><i class="mdi mdi-circle-medium"></i> ' . $row->prioritas_pembelajaran . '</span>'; // Info
                    } elseif ($prioritas > 20 && $prioritas <= 30) {
                        return '<span class="badge badge-label bg-success badge-width"><i class="mdi mdi-circle-medium"></i> ' . $row->prioritas_pembelajaran . '</span>'; // Success
                    } elseif ($prioritas > 30 && $prioritas <= 40) {
                        return '<span class="badge badge-label bg-primary badge-width"><i class="mdi mdi-circle-medium"></i> ' . $row->prioritas_pembelajaran . '</span>'; // Primary
                    } elseif ($prioritas > 40 && $prioritas <= 50) {
                        return '<span class="badge badge-label bg-secondary badge-width"><i class="mdi mdi-circle-medium"></i> ' . $row->prioritas_pembelajaran . '</span>'; // Secondary
                    } else {
                        return '<span class="badge badge-label badge-width"><i class="mdi mdi-circle-medium"></i> ' . $row->prioritas_pembelajaran . '</span>';
                    }
                })
                ->addColumn('action', 'pengajuan-kap.include.action')
                ->rawColumns(['status_pengajuan', 'action', 'prioritas_pembelajaran', 'nama_kompetensi', 'indikator_kinerja'])
                ->toJson();
        }


        $topiks = DB::table('topik')->get();
        $units = DB::table('users')
            ->select('nama_unit')
            ->groupBy('nama_unit')
            ->get();


        $userId = Auth::id();
        $reviewRemarks = DB::table('config_step_review')
            ->where('user_review_id', $userId)
            ->pluck('remark')
            ->toArray();
        $tahunSelected = $request->query('tahun');
        if ($tahunSelected != null) {
            $tahun = $tahunSelected;
        } else {
            if ($frekuensi === 'Tahunan') {
                $jadwalKapTahunan = DB::table('jadwal_kap_tahunan')
                    ->orderBy('id', 'desc')
                    ->first();
                $tahun = $jadwalKapTahunan->tahun;
            } else {
                $tahun =  date('Y');
            }
        }
        $topik = intval($request->query('topik'))  ?? 'All';
        $curretnStep = intval($request->query('step'))  ?? 'All';
        $status_pengajuan = $request->query('status_pengajuan') ?? 'All';
        $unit_kerja = $request->query('unit_kerja', []);
        $prioritas = $request->query('prioritas', []);




        // Convert unit_kerja and prioritas from comma-separated strings to arrays
        $unit_kerja = is_array($unit_kerja) ? $unit_kerja : explode(',', $unit_kerja);
        $prioritas = is_array($prioritas) ? $prioritas : explode(',', $prioritas);
        return view('pengajuan-kap.index', [
            'year' => $tahun,
            'is_bpkp' => $is_bpkp,
            'frekuensi' => $frekuensi,
            'reviewRemarks' => $reviewRemarks,
            'topiks' => $topiks,
            'topik_id' => $topik,
            'statusPengajuan' => $status_pengajuan,
            'curretnStep' => $curretnStep,
            'units' => $units,
            'unit_kerja' => $unit_kerja, // Pass unit_kerja to the view
            'prioritas' => $prioritas // Pass prioritas to the view
        ]);
    }

    public function create($is_bpkp, $frekuensi)
    {
        if ($frekuensi === 'Tahunan') {
            $today = now()->toDateString();
            $jadwalKapTahunan = DB::table('jadwal_kap_tahunan')
                ->whereDate('tanggal_mulai', '<=', $today)
                ->whereDate('tanggal_selesai', '>=', $today)
                ->orderBy('id', 'desc')
                ->first();

            if (!$jadwalKapTahunan) {
                Alert::info('Informasi', 'Jadwal pengajuan KAP tahunan telah berakhir / belum dibuka oleh admin.');
                return redirect()->back();
            }
            $tahun = $jadwalKapTahunan->tahun;
        } else {
            $tahun =  date('Y');
        }
        if ($is_bpkp === 'BPKP') {
            $jenis_program = ['Renstra', 'APP', 'APEP'];
        } elseif ($is_bpkp === 'Non BPKP') {
            $jenis_program = ['APIP'];
        } else {
            $jenis_program = [];
        }

        $jalur_pembelajaran = [
            'Pelatihan',
            'Seminar/konferensi/sarasehan',
            'Kursus',
            'Lokakarya (workshop)',
            'Belajar mandiri',
            'Coaching',
            'Mentoring',
            'Bimbingan teknis',
            'Sosialisasi',
            'Detasering (secondment)',
            'Job shadowing',
            'Outbond',
            'Benchmarking',
            'Pertukaran PNS',
            'Community of practices',
            'Pelatihan di kantor sendiri',
            'Library cafe',
            'Magang/praktik kerja'
        ];

        $endpoint_pusdiklatwap = config('stara.endpoint_pusdiklatwap');
        $api_key_pusdiklatwap = config('stara.api_token_pusdiklatwap');

        // Call API for metode
        $metode_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/metode', [
            'api_key' => $api_key_pusdiklatwap
        ]);

        if (isset($metode_data['error'])) {
            Alert::error('Error', $metode_data['error']);
            return redirect()->back();
        }

        // Call API for diklatType
        $diklatType_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/diklatType', [
            'api_key' => $api_key_pusdiklatwap
        ]);

        if (isset($diklatType_data['error'])) {
            Alert::error('Error', $diklatType_data['error']);
            return redirect()->back();
        }

        // Call API for diklatLocation
        $diklatLocation_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/diklatLocation', [
            'api_key' => $api_key_pusdiklatwap
        ]);

        if (isset($diklatLocation_data['error'])) {
            Alert::error('Error', $diklatLocation_data['error']);
            return redirect()->back();
        }

        $user = Auth::user();
        $nama_unit = $user->nama_unit;

        $pengajuanKaps = DB::table('pengajuan_kap')
            ->select(
                'pengajuan_kap.*',
                'users.name as user_name',
                'pengajuan_kap.prioritas_pembelajaran',
                'pengajuan_kap.kode_pembelajaran'
            )
            ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
            ->where('pengajuan_kap.institusi_sumber', '=', $is_bpkp)
            ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $frekuensi)
            ->where('pengajuan_kap.tahun', '=', $tahun)
            ->where('users.nama_unit', '=', $nama_unit)
            ->get();

        // Ambil prioritas yang sudah digunakan beserta kode_pembelajaran
        $usedPrioritas = $pengajuanKaps->pluck('prioritas_pembelajaran')->toArray();
        $kodePembelajaran = $pengajuanKaps->pluck('kode_pembelajaran', 'prioritas_pembelajaran')->toArray();

        // for hidden forn
        $userUnitKerja = auth()->user()->nama_unit; // Contoh mendapatkan unit kerja user yang sedang login
        $unitKerjaWithoutForm = array_map('trim', explode('|', env('WITHOUT_FORM_IK_KOMPETENSI')));
        $hideForm = in_array($userUnitKerja, $unitKerjaWithoutForm);
        $topikOptions = [];
        if ($hideForm) {
            $topikOptions = DB::table('topik')
                ->select('topik.id', 'topik.nama_topik')
                ->get();
        }


        return view($is_bpkp == 'BPKP' ? 'pengajuan-kap.create' : 'pengajuan-kap.create-apip', [
            'is_bpkp' => $is_bpkp,
            'frekuensi' => $frekuensi,
            'jenis_program' => $jenis_program,
            'jalur_pembelajaran' => $jalur_pembelajaran,
            'metode_data' => $metode_data,
            'diklatType_data' => $diklatType_data,
            'diklatLocation_data' => $diklatLocation_data,
            'tahun' => $tahun,
            'usedPrioritas' => $usedPrioritas,
            'kodePembelajaran' => $kodePembelajaran,
            'hideForm' => $hideForm,
            'topikOptions' => $topikOptions,
        ]);
    }

    public function edit($id, $is_bpkp, $frekuensi)
    {
        $pengajuanKap = DB::table('pengajuan_kap')
            ->select(
                'pengajuan_kap.*',
                'users.name as user_name',
                'kompetensi.nama_kompetensi',
                'topik.nama_topik'
            )
            ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
            ->leftJoin('kompetensi', 'pengajuan_kap.kompetensi_id', '=', 'kompetensi.id')
            ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id')
            ->where('pengajuan_kap.id', '=', $id)
            ->where('pengajuan_kap.institusi_sumber', '=', $is_bpkp)
            ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $frekuensi)
            ->first();

        // Cek apakah data pengajuan_kap ditemukan
        if (!$pengajuanKap) {
            return redirect()->route('not-found'); // Atur route ke halaman Not Found
        }

        // Cek apakah user yang login adalah user yang membuat pengajuan
        if ($pengajuanKap->user_created !== Auth::id()) {
            return redirect()->route('un-authorized'); // Atur route ke halaman Un-authorized
        }

        // Pengecekan jenis program
        if ($is_bpkp === 'BPKP') {
            $jenis_program = ['Renstra', 'APP', 'APEP'];
        } elseif ($is_bpkp === 'Non BPKP') {
            $jenis_program = ['APIP'];
        } else {
            $jenis_program = [];
        }

        $jalur_pembelajaran = [
            'Pelatihan',
            'Seminar/konferensi/sarasehan',
            'Kursus',
            'Lokakarya (workshop)',
            'Belajar mandiri',
            'Coaching',
            'Mentoring',
            'Bimbingan teknis',
            'Sosialisasi',
            'Detasering (secondment)',
            'Job shadowing',
            'Outbond',
            'Benchmarking',
            'Pertukaran PNS',
            'Community of practices',
            'Pelatihan di kantor sendiri',
            'Library cafe',
            'Magang/praktik kerja'
        ];

        $level_evaluasi_instrumen_kap = DB::table('level_evaluasi_instrumen_kap')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $indikator_keberhasilan_kap = DB::table('indikator_keberhasilan_kap')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $waktu_pelaksanaan = DB::table('waktu_pelaksanaan')
            ->where('pengajuan_kap_id', $id)
            ->get()
            ->toArray(); // Dapatkan data dalam bentuk array
        $pengajuan_kap_gap_kompetensi = DB::table('pengajuan_kap_gap_kompetensi')
            ->where('pengajuan_kap_id', $id)
            ->first();

        $endpoint_pusdiklatwap = config('stara.endpoint_pusdiklatwap');
        $api_key_pusdiklatwap = config('stara.api_token_pusdiklatwap');

        // Call API for metode
        $metode_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/metode', [
            'api_key' => $api_key_pusdiklatwap
        ]);

        if (isset($metode_data['error'])) {
            Alert::error('Error', $metode_data['error']);
            return redirect()->back();
        }

        // Call API for diklatType
        $diklatType_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/diklatType', [
            'api_key' => $api_key_pusdiklatwap
        ]);

        if (isset($diklatType_data['error'])) {
            Alert::error('Error', $diklatType_data['error']);
            return redirect()->back();
        }

        // Call API for diklatLocation
        $diklatLocation_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/diklatLocation', [
            'api_key' => $api_key_pusdiklatwap
        ]);

        if (isset($diklatLocation_data['error'])) {
            Alert::error('Error', $diklatLocation_data['error']);
            return redirect()->back();
        }

        $user = Auth::user();
        $nama_unit = $user->nama_unit;

        $pengajuanKaps = DB::table('pengajuan_kap')
            ->select(
                'pengajuan_kap.*',
                'users.name as user_name',
                'pengajuan_kap.prioritas_pembelajaran',
                'pengajuan_kap.kode_pembelajaran'
            )
            ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
            ->where('pengajuan_kap.institusi_sumber', '=', $is_bpkp)
            ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $frekuensi)
            ->where('pengajuan_kap.tahun', '=', $pengajuanKap->tahun)
            ->where('users.nama_unit', '=', $nama_unit)
            ->get();

        $usedPrioritas = $pengajuanKaps->pluck('prioritas_pembelajaran')->toArray();
        $kodePembelajaran = $pengajuanKaps->pluck('kode_pembelajaran', 'prioritas_pembelajaran')->toArray();

        // for hidden forn
        $userUnitKerja = auth()->user()->nama_unit;
        $unitKerjaWithoutForm = array_map('trim', explode('|', env('WITHOUT_FORM_IK_KOMPETENSI')));
        $hideForm = in_array($userUnitKerja, $unitKerjaWithoutForm);

        $topikOptions = [];
        if ($hideForm) {
            $topikOptions = DB::table('topik')
                ->select('topik.id', 'topik.nama_topik')
                ->get();
        } else {
            $topikOptions = DB::table('tagging_pembelajaran_kompetensi')
                ->join('topik', 'tagging_pembelajaran_kompetensi.topik_id', '=', 'topik.id')
                ->select('topik.id', 'topik.nama_topik')
                ->where('tagging_pembelajaran_kompetensi.kompetensi_id', $pengajuanKap->kompetensi_id)
                ->get();
        }
        return view($is_bpkp == 'BPKP' ? 'pengajuan-kap.edit' : 'pengajuan-kap.edit-apip', [
            'pengajuanKap' => $pengajuanKap,
            'is_bpkp' => $is_bpkp,
            'frekuensi' => $frekuensi,
            'jenis_program' => $jenis_program,
            'jalur_pembelajaran' => $jalur_pembelajaran,
            'level_evaluasi_instrumen_kap' => $level_evaluasi_instrumen_kap,
            'indikator_keberhasilan_kap' => $indikator_keberhasilan_kap,
            'waktuPelaksanaanData' => json_encode($waktu_pelaksanaan),
            'metode_data' => $metode_data,
            'diklatType_data' => $diklatType_data,
            'diklatLocation_data' => $diklatLocation_data,
            'pengajuan_kap_gap_kompetensi' => $pengajuan_kap_gap_kompetensi,
            'topikOptions' => $topikOptions,
            'tahun' => $pengajuanKap->tahun,
            'usedPrioritas' => $usedPrioritas,
            'kodePembelajaran' => $kodePembelajaran,
            'hideForm' => $hideForm,
        ]);
    }

    public function duplikat($id, $is_bpkp, $frekuensi)
    {

        if ($frekuensi === 'Tahunan') {
            $today = now()->toDateString();
            $jadwalKapTahunan = DB::table('jadwal_kap_tahunan')
                ->whereDate('tanggal_mulai', '<=', $today)
                ->whereDate('tanggal_selesai', '>=', $today)
                ->orderBy('id', 'desc')
                ->first();

            if (!$jadwalKapTahunan) {
                Alert::info('Informasi', 'Jadwal pengajuan KAP tahunan telah berakhir / belum dibuka oleh admin.');
                return redirect()->back();
            }
            $tahun = $jadwalKapTahunan->tahun;
        } else {
            $tahun =  date('Y');
        }

        $pengajuanKap = DB::table('pengajuan_kap')
            ->select(
                'pengajuan_kap.*',
                'users.name as user_name',
                'kompetensi.nama_kompetensi',
                'topik.nama_topik'
            )
            ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
            ->leftJoin('kompetensi', 'pengajuan_kap.kompetensi_id', '=', 'kompetensi.id')
            ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id')
            ->where('pengajuan_kap.id', '=', $id)
            ->where('pengajuan_kap.institusi_sumber', '=', $is_bpkp)
            ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $frekuensi)
            ->first();

        // Cek apakah data pengajuan_kap ditemukan
        if (!$pengajuanKap) {
            return redirect()->route('not-found'); // Atur route ke halaman Not Found
        }

        // Cek apakah user yang login adalah user yang membuat pengajuan
        if ($pengajuanKap->user_created !== Auth::id()) {
            return redirect()->route('un-authorized'); // Atur route ke halaman Un-authorized
        }

        // Pengecekan jenis program
        if ($is_bpkp === 'BPKP') {
            $jenis_program = ['Renstra', 'APP', 'APEP'];
        } elseif ($is_bpkp === 'Non BPKP') {
            $jenis_program = ['APIP'];
        } else {
            $jenis_program = [];
        }

        $jalur_pembelajaran = [
            'Pelatihan',
            'Seminar/konferensi/sarasehan',
            'Kursus',
            'Lokakarya (workshop)',
            'Belajar mandiri',
            'Coaching',
            'Mentoring',
            'Bimbingan teknis',
            'Sosialisasi',
            'Detasering (secondment)',
            'Job shadowing',
            'Outbond',
            'Benchmarking',
            'Pertukaran PNS',
            'Community of practices',
            'Pelatihan di kantor sendiri',
            'Library cafe',
            'Magang/praktik kerja'
        ];

        $level_evaluasi_instrumen_kap = DB::table('level_evaluasi_instrumen_kap')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $indikator_keberhasilan_kap = DB::table('indikator_keberhasilan_kap')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $waktu_pelaksanaan = DB::table('waktu_pelaksanaan')
            ->where('pengajuan_kap_id', $id)
            ->get()
            ->toArray(); // Dapatkan data dalam bentuk array
        $pengajuan_kap_gap_kompetensi = DB::table('pengajuan_kap_gap_kompetensi')
            ->where('pengajuan_kap_id', $id)
            ->first();

        $endpoint_pusdiklatwap = config('stara.endpoint_pusdiklatwap');
        $api_key_pusdiklatwap = config('stara.api_token_pusdiklatwap');

        // Call API for metode
        $metode_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/metode', [
            'api_key' => $api_key_pusdiklatwap
        ]);

        if (isset($metode_data['error'])) {
            Alert::error('Error', $metode_data['error']);
            return redirect()->back();
        }

        // Call API for diklatType
        $diklatType_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/diklatType', [
            'api_key' => $api_key_pusdiklatwap
        ]);

        if (isset($diklatType_data['error'])) {
            Alert::error('Error', $diklatType_data['error']);
            return redirect()->back();
        }

        // Call API for diklatLocation
        $diklatLocation_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/diklatLocation', [
            'api_key' => $api_key_pusdiklatwap
        ]);

        if (isset($diklatLocation_data['error'])) {
            Alert::error('Error', $diklatLocation_data['error']);
            return redirect()->back();
        }

        $user = Auth::user();
        $nama_unit = $user->nama_unit;

        $pengajuanKaps = DB::table('pengajuan_kap')
            ->select(
                'pengajuan_kap.*',
                'users.name as user_name',
                'pengajuan_kap.prioritas_pembelajaran',
                'pengajuan_kap.kode_pembelajaran'
            )
            ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
            ->where('pengajuan_kap.institusi_sumber', '=', $is_bpkp)
            ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $frekuensi)
            ->where('pengajuan_kap.tahun', '=', $pengajuanKap->tahun)
            ->where('users.nama_unit', '=', $nama_unit)
            ->get();

        $usedPrioritas = $pengajuanKaps->pluck('prioritas_pembelajaran')->toArray();
        $kodePembelajaran = $pengajuanKaps->pluck('kode_pembelajaran', 'prioritas_pembelajaran')->toArray();

        // for hidden forn
        $userUnitKerja = auth()->user()->nama_unit;
        $unitKerjaWithoutForm = array_map('trim', explode('|', env('WITHOUT_FORM_IK_KOMPETENSI')));
        $hideForm = in_array($userUnitKerja, $unitKerjaWithoutForm);

        $topikOptions = [];
        if ($hideForm) {
            $topikOptions = DB::table('topik')
                ->select('topik.id', 'topik.nama_topik')
                ->get();
        } else {
            $topikOptions = DB::table('tagging_pembelajaran_kompetensi')
                ->join('topik', 'tagging_pembelajaran_kompetensi.topik_id', '=', 'topik.id')
                ->select('topik.id', 'topik.nama_topik')
                ->where('tagging_pembelajaran_kompetensi.kompetensi_id', $pengajuanKap->kompetensi_id)
                ->get();
        }
        return view($is_bpkp == 'BPKP' ? 'pengajuan-kap.edit' : 'pengajuan-kap.edit-apip', [
            'pengajuanKap' => $pengajuanKap,
            'is_bpkp' => $is_bpkp,
            'frekuensi' => $frekuensi,
            'jenis_program' => $jenis_program,
            'jalur_pembelajaran' => $jalur_pembelajaran,
            'level_evaluasi_instrumen_kap' => $level_evaluasi_instrumen_kap,
            'indikator_keberhasilan_kap' => $indikator_keberhasilan_kap,
            'waktuPelaksanaanData' => json_encode($waktu_pelaksanaan),
            'metode_data' => $metode_data,
            'diklatType_data' => $diklatType_data,
            'diklatLocation_data' => $diklatLocation_data,
            'pengajuan_kap_gap_kompetensi' => $pengajuan_kap_gap_kompetensi,
            'topikOptions' => $topikOptions,
            'tahun' => $tahun,
            'usedPrioritas' => $usedPrioritas,
            'kodePembelajaran' => $kodePembelajaran,
            'hideForm' => $hideForm,
        ]);
    }

    public function store(Request $request, $is_bpkp, $frekuensi)
    {
        $validatedData = $request->validate([
            'jenis_program' => 'required|in:Renstra,APP,APEP,APIP',
            'indikator_kinerja' => 'nullable|array',
            'referensi_indikator_kinerja' => 'string',
            'kompetensi_id' => 'nullable|array',
            'topik_id' => 'nullable|exists:topik,id',
            'judul' => 'required|string',
            'tahun' => 'required',
            'indikator_keberhasilan' => 'required|array',
            'arahan_pimpinan' => 'required|string',
            'prioritas_pembelajaran' => 'required|string',
            'tujuan_program_pembelajaran' => 'required|string',
            'indikator_dampak_terhadap_kinerja_organisasi' => 'required|string',
            'penugasan_yang_terkait_dengan_pembelajaran' => 'required|string',
            'skill_group_owner' => 'required|string',
            'diklatLocID' => 'nullable|string',
            'diklatLocName' => 'nullable|string',
            'detail_lokasi' => 'nullable|string',
            'kelas' => 'nullable',
            'diklatTypeID' => 'nullable|string',
            'diklatTypeName' => 'nullable|string',
            'metodeID' => 'nullable|string',
            'metodeName' => 'nullable|string',
            'biayaID' => 'nullable|string',
            'biayaName' => 'nullable|string',
            'bentuk_pembelajaran' => 'nullable|string',
            'jalur_pembelajaran' => 'nullable|string',
            'model_pembelajaran' => 'nullable|string',
            'peserta_pembelajaran' => 'nullable|string',
            'sasaran_peserta' => 'nullable|string',
            'kriteria_peserta' => 'nullable|string',
            'aktivitas_prapembelajaran' => 'nullable|string',
            'penyelenggara_pembelajaran' => 'nullable|string',
            'fasilitator_pembelajaran' => 'nullable|array',
            'fasilitator_pembelajaran.*' => 'nullable|string',
            'sertifikat' => 'nullable|string',
            'level_evaluasi_instrumen' => 'nullable|array',
            'no_level' => 'nullable|array',
            'tatap_muka_start' => 'nullable|string',
            'tatap_muka_end' => 'nullable|string',
            'hybrid_tatap_muka_start' => 'nullable|string',
            'hybrid_tatap_muka_end' => 'nullable|string',
            'hybrid_elearning_start' => 'nullable|string',
            'hybrid_elearning_end' => 'nullable|string',
            'elearning_start' => 'nullable|string',
            'elearning_end' => 'nullable|string',
            'remark_1' => 'nullable|string',
            'remark_2' => 'nullable|string',
            'remark_3' => 'nullable|string',
            'remark_4' => 'nullable|string',
        ]);

        $year =  $request->tahun;
        $topikId = sprintf('%03d', $validatedData['topik_id']);
        $lastPengajuan = DB::table('pengajuan_kap')
            ->where('tahun', $year)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastPengajuan) {
            // Ambil tiga digit terakhir dari kode_pembelajaran
            $lastKodePembelajaran = substr($lastPengajuan->kode_pembelajaran, -3);

            // Ubah menjadi bilangan bulat untuk memastikan operasi matematika berjalan dengan benar
            $newNoUrut = sprintf('%03d', (int)$lastKodePembelajaran + 1);
        } else {
            // Jika tidak ada data sebelumnya, mulai dari '001'
            $newNoUrut = '001';
        }

        // Gabungkan tahun, topikId, dan newNoUrut
        $kodePembelajaran = $year . $topikId . $newNoUrut;

        DB::beginTransaction();
        try {
            $fasilitator_pembelajaran = $request->input('fasilitator_pembelajaran');
            $fasilitator_pembelajaran_json = empty($fasilitator_pembelajaran) ? null : json_encode($fasilitator_pembelajaran);
            foreach ($validatedData as $key => $value) {
                if ($value === 'null') {
                    $validatedData[$key] = null;
                }
            }
            if ($is_bpkp == 'BPKP') {
                $biayaID = "1";
                $biayaName = "RM";
            } else {
                $biayaID = "3";
                $biayaName = "PNBP";
            }

            $pengajuanKapId = DB::table('pengajuan_kap')->insertGetId([
                'kode_pembelajaran' => $kodePembelajaran,
                'institusi_sumber' => $is_bpkp,
                'jenis_program' => $validatedData['jenis_program'],
                'frekuensi_pelaksanaan' => $frekuensi,
                'referensi_indikator_kinerja' => isset($validatedData['referensi_indikator_kinerja']) ? $validatedData['referensi_indikator_kinerja'] : null,
                'topik_id' => $validatedData['topik_id'],
                'judul' => $validatedData['judul'],
                'arahan_pimpinan' => $validatedData['arahan_pimpinan'],
                'tahun' => $year,
                'prioritas_pembelajaran' => $validatedData['prioritas_pembelajaran'],
                'tujuan_program_pembelajaran' => $validatedData['tujuan_program_pembelajaran'],
                'indikator_dampak_terhadap_kinerja_organisasi' => $validatedData['indikator_dampak_terhadap_kinerja_organisasi'],
                'penugasan_yang_terkait_dengan_pembelajaran' => $validatedData['penugasan_yang_terkait_dengan_pembelajaran'],
                'skill_group_owner' => $validatedData['skill_group_owner'],
                'diklatLocID' => $validatedData['diklatLocID'],
                'diklatLocName' => $validatedData['diklatLocName'],
                'detail_lokasi' => $validatedData['detail_lokasi'],
                'kelas' => $validatedData['kelas'],
                'diklatTypeID' => $validatedData['diklatTypeID'],
                'diklatTypeName' => $validatedData['diklatTypeName'],
                'metodeID' => $validatedData['metodeID'],
                'metodeName' => $validatedData['metodeName'],
                'biayaID' =>  $biayaID,
                'biayaName' =>  $biayaName,
                'latsar_stat' => '0',
                'bentuk_pembelajaran' => $validatedData['bentuk_pembelajaran'],
                'jalur_pembelajaran' => $validatedData['jalur_pembelajaran'],
                'model_pembelajaran' => $validatedData['model_pembelajaran'],
                'peserta_pembelajaran' => $validatedData['peserta_pembelajaran'],
                'sasaran_peserta' => $validatedData['sasaran_peserta'],
                'kriteria_peserta' => $validatedData['kriteria_peserta'],
                'aktivitas_prapembelajaran' => $validatedData['aktivitas_prapembelajaran'],
                'penyelenggara_pembelajaran' => $validatedData['penyelenggara_pembelajaran'],
                'fasilitator_pembelajaran' => $fasilitator_pembelajaran_json,
                'sertifikat' => $validatedData['sertifikat'],
                'tanggal_created' => date('Y-m-d H:i:s'),
                'status_pengajuan' => 'Pending',
                'user_created' => Auth::id(),
                'current_step' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $metodeID = $validatedData['metodeID'];
            if ($metodeID === '1') {
                DB::table('waktu_pelaksanaan')->insert([
                    'pengajuan_kap_id' => $pengajuanKapId,
                    'remarkMetodeName' => $validatedData['remark_1'],
                    'tanggal_mulai' => $validatedData['tatap_muka_start'],
                    'tanggal_selesai' => $validatedData['tatap_muka_end'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } elseif ($metodeID === '2') {
                // Insert E-Learning data
                DB::table('waktu_pelaksanaan')->insert([
                    'pengajuan_kap_id' => $pengajuanKapId,
                    'remarkMetodeName' => $validatedData['remark_2'],
                    'tanggal_mulai' => $validatedData['hybrid_elearning_start'],
                    'tanggal_selesai' => $validatedData['hybrid_elearning_end'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert Tatap Muka data
                DB::table('waktu_pelaksanaan')->insert([
                    'pengajuan_kap_id' => $pengajuanKapId,
                    'remarkMetodeName' => $validatedData['remark_3'],
                    'tanggal_mulai' => $validatedData['hybrid_tatap_muka_start'],
                    'tanggal_selesai' => $validatedData['hybrid_tatap_muka_end'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('waktu_pelaksanaan')->insert([
                    'pengajuan_kap_id' => $pengajuanKapId,
                    'remarkMetodeName' => $validatedData['remark_4'],
                    'tanggal_mulai' => $validatedData['elearning_start'],
                    'tanggal_selesai' => $validatedData['elearning_end'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            // insert table pengajuan_kap_indikator_kinerja
            $dataIndikator = [];
            foreach ($request->indikator_kinerja as $indikator) {
                $dataIndikator[] = [
                    'pengajuan_kap_id' => $pengajuanKapId,
                    'indikator_kinerja' => $indikator,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert all records at once
            DB::table('pengajuan_kap_indikator_kinerja')->insert($dataIndikator);

            // insert table pengajuan_kap_gap_kompetensi
            $dataGapKompetensi = [];
            foreach ($request->kompetensi_id as $index => $kompetensiId) {
                $dataGapKompetensi[] = [
                    'pengajuan_kap_id' => $pengajuanKapId,
                    'kompetensi_id' => $kompetensiId,
                    'total_pegawai' => $request->total_employees[$index],
                    'pegawai_kompeten' => $request->count_100[$index],
                    'pegawai_belum_kompeten' => $request->count_less_than_100[$index],
                    'persentase_kompetensi' => $request->average_persentase[$index],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert all records at once
            DB::table('pengajuan_kap_gap_kompetensi')->insert($dataGapKompetensi);

            foreach ($validatedData['indikator_keberhasilan'] as $index => $row) {
                DB::table('indikator_keberhasilan_kap')->insert([
                    'pengajuan_kap_id' => $pengajuanKapId,
                    'indikator_keberhasilan' => $row,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($validatedData['level_evaluasi_instrumen'] as $index => $x) {
                DB::table('level_evaluasi_instrumen_kap')->insert([
                    'pengajuan_kap_id' => $pengajuanKapId,
                    'level' => $validatedData['no_level'][$index],
                    'keterangan' => $x,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $remarks = ($frekuensi == 'Tahunan') ?
                [
                    'Biro SDM',
                    'Tim Unit Pengelola Pembelajaran',
                    'Penjaminan Mutu',
                    'Subkoordinator',
                    'Koordinator',
                    'Kepala Unit Pengelola Pembelajaran'
                ] :
                [
                    'Biro SDM',
                    'Tim Unit Pengelola Pembelajaran',
                    'Penjaminan Mutu',
                    'Subkoordinator'
                ];
            foreach ($remarks as $index => $remark) {
                DB::table('log_review_pengajuan_kap')->insert([
                    'pengajuan_kap_id' => $pengajuanKapId,
                    'step' => $index + 1,
                    'remark' => $remark,
                    'user_review_id' => null,
                    'status' => 'Pending',
                    'tanggal_review' => null,
                    'catatan' => '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::commit();
            Alert::toast('Pengajuan KAP berhasil disimpan.', 'success');
            return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error: ' . $e->getMessage());
            Alert::toast('Pengajuan KAP gagal disimpan.', 'error');
            return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]);
        }
    }

    public function update(Request $request, $id, $is_bpkp, $frekuensi)
    {
        $validatedData = $request->validate([
            'jenis_program' => 'required|in:Renstra,APP,APEP,APIP',
            'indikator_kinerja' => 'nullable|string',
            'referensi_indikator_kinerja' => 'string',
            'kompetensi_id' => 'nullable|exists:kompetensi,id',
            'topik_id' => 'nullable|exists:topik,id',
            'judul' => 'required|string',
            'tahun' => 'required',
            'indikator_keberhasilan' => 'required|array',
            'arahan_pimpinan' => 'required|string',
            'prioritas_pembelajaran' => 'required|string',
            'tujuan_program_pembelajaran' => 'required|string',
            'indikator_dampak_terhadap_kinerja_organisasi' => 'required|string',
            'penugasan_yang_terkait_dengan_pembelajaran' => 'required|string',
            'skill_group_owner' => 'required|string',
            'diklatLocID' => 'nullable|string',
            'diklatLocName' => 'nullable|string',
            'detail_lokasi' => 'nullable|string',
            'kelas' => 'nullable',
            'diklatTypeID' => 'nullable|string',
            'diklatTypeName' => 'nullable|string',
            'metodeID' => 'nullable|string',
            'metodeName' => 'nullable|string',
            'biayaID' => 'nullable|string',
            'biayaName' => 'nullable|string',
            'bentuk_pembelajaran' => 'nullable|string',
            'jalur_pembelajaran' => 'nullable|string',
            'model_pembelajaran' => 'nullable|string',
            'peserta_pembelajaran' => 'nullable|string',
            'sasaran_peserta' => 'nullable|string',
            'kriteria_peserta' => 'nullable|string',
            'aktivitas_prapembelajaran' => 'nullable|string',
            'penyelenggara_pembelajaran' => 'nullable|string',
            'fasilitator_pembelajaran' => 'nullable|array',
            'fasilitator_pembelajaran.*' => 'nullable|string',
            'sertifikat' => 'nullable|string',
            'level_evaluasi_instrumen' => 'nullable|array',
            'no_level' => 'nullable|array',
            'tatap_muka_start' => 'nullable|string',
            'tatap_muka_end' => 'nullable|string',
            'hybrid_tatap_muka_start' => 'nullable|string',
            'hybrid_tatap_muka_end' => 'nullable|string',
            'hybrid_elearning_start' => 'nullable|string',
            'hybrid_elearning_end' => 'nullable|string',
            'elearning_start' => 'nullable|string',
            'elearning_end' => 'nullable|string',
            'remark_1' => 'nullable|string',
            'remark_2' => 'nullable|string',
            'remark_3' => 'nullable|string',
            'remark_4' => 'nullable|string',
        ]);

        $fasilitator_pembelajaran = $request->input('fasilitator_pembelajaran');
        $fasilitator_pembelajaran_json = empty($fasilitator_pembelajaran) ? null : json_encode($fasilitator_pembelajaran);
        foreach ($validatedData as $key => $value) {
            if ($value === 'null') {
                $validatedData[$key] = null;
            }
        }
        if ($is_bpkp == 'BPKP') {
            $biayaID = "1";
            $biayaName = "RM";
        } else {
            $biayaID = "3";
            $biayaName = "PNBP";
        }
        $pengajuanKap = DB::table('pengajuan_kap')->where('id', $id)->first();

        if ($pengajuanKap) {
            DB::table('pengajuan_kap')
                ->where('id', $id)
                ->update([
                    'jenis_program' => $validatedData['jenis_program'] ?? $pengajuanKap->jenis_program,
                    'indikator_kinerja' => $validatedData['indikator_kinerja'] ?? $pengajuanKap->indikator_kinerja,
                    'referensi_indikator_kinerja' => $validatedData['referensi_indikator_kinerja'] ?? $pengajuanKap->referensi_indikator_kinerja,
                    'kompetensi_id' => $validatedData['kompetensi_id'] ?? $pengajuanKap->kompetensi_id,
                    'topik_id' => $validatedData['topik_id'] ?? $pengajuanKap->topik_id,
                    'judul' => $validatedData['judul'] ?? $pengajuanKap->judul,
                    'arahan_pimpinan' => $validatedData['arahan_pimpinan'] ?? $pengajuanKap->arahan_pimpinan,
                    'prioritas_pembelajaran' => $validatedData['prioritas_pembelajaran'] ?? $pengajuanKap->prioritas_pembelajaran,
                    'tujuan_program_pembelajaran' => $validatedData['tujuan_program_pembelajaran'] ?? $pengajuanKap->tujuan_program_pembelajaran,
                    'indikator_dampak_terhadap_kinerja_organisasi' => $validatedData['indikator_dampak_terhadap_kinerja_organisasi'] ?? $pengajuanKap->indikator_dampak_terhadap_kinerja_organisasi,
                    'penugasan_yang_terkait_dengan_pembelajaran' => $validatedData['penugasan_yang_terkait_dengan_pembelajaran'] ?? $pengajuanKap->penugasan_yang_terkait_dengan_pembelajaran,
                    'skill_group_owner' => $validatedData['skill_group_owner'] ?? $pengajuanKap->skill_group_owner,
                    'diklatLocID' => $validatedData['diklatLocID'] ?? $pengajuanKap->diklatLocID,
                    'diklatLocName' => $validatedData['diklatLocName'] ?? $pengajuanKap->diklatLocName,
                    'detail_lokasi' => $validatedData['detail_lokasi'] ?? $pengajuanKap->detail_lokasi,
                    'kelas' => $validatedData['kelas'] ?? $pengajuanKap->kelas,
                    'diklatTypeID' => $validatedData['diklatTypeID'] ?? $pengajuanKap->diklatTypeID,
                    'diklatTypeName' => $validatedData['diklatTypeName'] ?? $pengajuanKap->diklatTypeName,
                    'metodeID' => $validatedData['metodeID'] ?? $pengajuanKap->metodeID,
                    'metodeName' => $validatedData['metodeName'] ?? $pengajuanKap->metodeName,
                    'biayaID' => $biayaID ?? $pengajuanKap->biayaID,
                    'biayaName' => $biayaName ?? $pengajuanKap->biayaName,
                    'latsar_stat' => '0',
                    'bentuk_pembelajaran' => $validatedData['bentuk_pembelajaran'] ?? $pengajuanKap->bentuk_pembelajaran,
                    'jalur_pembelajaran' => $validatedData['jalur_pembelajaran'] ?? $pengajuanKap->jalur_pembelajaran,
                    'model_pembelajaran' => $validatedData['model_pembelajaran'] ?? $pengajuanKap->model_pembelajaran,
                    'peserta_pembelajaran' => $validatedData['peserta_pembelajaran'] ?? $pengajuanKap->peserta_pembelajaran,
                    'sasaran_peserta' => $validatedData['sasaran_peserta'] ?? $pengajuanKap->sasaran_peserta,
                    'kriteria_peserta' => $validatedData['kriteria_peserta'] ?? $pengajuanKap->kriteria_peserta,
                    'aktivitas_prapembelajaran' => $validatedData['aktivitas_prapembelajaran'] ?? $pengajuanKap->aktivitas_prapembelajaran,
                    'penyelenggara_pembelajaran' => $validatedData['penyelenggara_pembelajaran'] ?? $pengajuanKap->penyelenggara_pembelajaran,
                    'fasilitator_pembelajaran' => $fasilitator_pembelajaran_json ?? $pengajuanKap->fasilitator_pembelajaran,
                    'sertifikat' => $validatedData['sertifikat'] ?? $pengajuanKap->sertifikat,
                    'status_pengajuan' => ($pengajuanKap->current_step == 1) ? 'Pending' : 'Process',
                    'updated_at' => now(),
                ]);
        }

        $metodeID = $validatedData['metodeID'];
        DB::table('waktu_pelaksanaan')
            ->where('pengajuan_kap_id', $id)
            ->delete();
        if ($metodeID === '1') {
            DB::table('waktu_pelaksanaan')->insert([
                'pengajuan_kap_id' => $id,
                'remarkMetodeName' => $validatedData['remark_1'],
                'tanggal_mulai' => $validatedData['tatap_muka_start'],
                'tanggal_selesai' => $validatedData['tatap_muka_end'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($metodeID === '2') {
            // Insert E-Learning data
            DB::table('waktu_pelaksanaan')->insert([
                'pengajuan_kap_id' => $id,
                'remarkMetodeName' => $validatedData['remark_2'],
                'tanggal_mulai' => $validatedData['hybrid_elearning_start'],
                'tanggal_selesai' => $validatedData['hybrid_elearning_end'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert Tatap Muka data
            DB::table('waktu_pelaksanaan')->insert([
                'pengajuan_kap_id' => $id,
                'remarkMetodeName' => $validatedData['remark_3'],
                'tanggal_mulai' => $validatedData['hybrid_tatap_muka_start'],
                'tanggal_selesai' => $validatedData['hybrid_tatap_muka_end'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('waktu_pelaksanaan')->insert([
                'pengajuan_kap_id' => $id,
                'remarkMetodeName' => $validatedData['remark_4'],
                'tanggal_mulai' => $validatedData['elearning_start'],
                'tanggal_selesai' => $validatedData['elearning_end'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // insert table pengajuan_kap_gap_kompetensi
        DB::table('pengajuan_kap_gap_kompetensi')
            ->where('pengajuan_kap_id', $id)
            ->delete();
        DB::table('pengajuan_kap_gap_kompetensi')->insert([
            'pengajuan_kap_id' => $id,
            'total_pegawai' => $request->total_pegawai ?? 0,
            'pegawai_kompeten' => $request->pegawai_kompeten ?? 0,
            'pegawai_belum_kompeten' => $request->pegawai_belum_kompeten ?? 0,
            'persentase_kompetensi' => $request->persentase_kompetensi ?? 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('indikator_keberhasilan_kap')
            ->where('pengajuan_kap_id', $id)
            ->delete();
        foreach ($validatedData['indikator_keberhasilan'] as $index => $row) {
            DB::table('indikator_keberhasilan_kap')->insert([
                'pengajuan_kap_id' => $id,
                'indikator_keberhasilan' => $row,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('level_evaluasi_instrumen_kap')
            ->where('pengajuan_kap_id', $id)
            ->delete();
        foreach ($validatedData['level_evaluasi_instrumen'] as $index => $x) {
            DB::table('level_evaluasi_instrumen_kap')->insert([
                'pengajuan_kap_id' => $id,
                'level' => $validatedData['no_level'][$index],
                'keterangan' => $x,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Alert::toast('Pengajuan KAP berhasil diperbarui.', 'success');
        return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]);
    }

    public function destroy($id, $is_bpkp, $frekuensi)
    {
        try {
            $pengajuanKap = DB::table('pengajuan_kap')->find($id);
            if (!$pengajuanKap) {
                Alert::toast('Pengajuan KAP tidak ditemukan.', 'error');
                return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]);
            }
            DB::table('pengajuan_kap')->where('id', $id)->delete();
            Alert::toast('Pengajuan KAP berhasil dihapus.', 'success');
        } catch (\Exception $e) {
            Alert::toast('Terjadi kesalahan saat menghapus Pengajuan KAP', 'error');
            return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]);
        }
        return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]);
    }

    public function show($id, $is_bpkp, $frekuensi)
    {
        DB::table('notifications')
            ->where('user_id', auth()->id()) // Menggunakan user ID dari user yang sedang login
            ->where('pengajuan_kap_id', $id) // Kondisi pengajuan_kap_id
            ->update(['is_read' => 1]); // Mengubah is_read menjadi 1 (true)

        $pengajuanKap = DB::table('pengajuan_kap')
            ->select(
                'pengajuan_kap.*',
                'users.name as user_name',
                'users.nama_unit as nama_unit',
                'topik.nama_topik'
            )
            ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
            ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id')
            ->where('pengajuan_kap.id', '=', $id)
            ->where('pengajuan_kap.institusi_sumber', '=', $is_bpkp)
            ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $frekuensi)
            ->first();
        // Cek apakah data pengajuan_kap ditemukan
        if (!$pengajuanKap) {
            return redirect()->route('not-found'); // Atur route ke halaman Not Found
        }

        $logReviews = DB::table('log_review_pengajuan_kap')
            ->select(
                'log_review_pengajuan_kap.*',
                'users.name as user_name'
            )
            ->leftJoin('users', 'log_review_pengajuan_kap.user_review_id', '=', 'users.id')
            ->where('log_review_pengajuan_kap.pengajuan_kap_id', '=', $id)
            ->orderBy('log_review_pengajuan_kap.step')
            ->get();

        $pengajuan_kap_indikator_kinerja = DB::table('pengajuan_kap_indikator_kinerja')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $pengajuan_kap_gap_kompetensi = DB::table('pengajuan_kap_gap_kompetensi')
            ->join('kompetensi', 'pengajuan_kap_gap_kompetensi.kompetensi_id', '=', 'kompetensi.id')
            ->where('pengajuan_kap_gap_kompetensi.pengajuan_kap_id', $id)
            ->select(
                'pengajuan_kap_gap_kompetensi.*',
                'kompetensi.nama_kompetensi'
            )
            ->get();
        $level_evaluasi_instrumen_kap = DB::table('level_evaluasi_instrumen_kap')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $indikator_keberhasilan_kap = DB::table('indikator_keberhasilan_kap')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $waktu_pelaksanaan = DB::table('waktu_pelaksanaan')
            ->where('waktu_pelaksanaan.pengajuan_kap_id', $id)
            ->select('waktu_pelaksanaan.*')
            ->get();
        $steps = [
            'Biro SDM',
            'Tim Unit Pengelola Pembelajaran',
            'Penjaminan Mutu',
            'Subkoordinator',
            'Koordinator',
            'Kepala Unit Pengelola Pembelajaran'
        ];

        $currentStepRemark = isset($pengajuanKap->current_step) && $pengajuanKap->current_step > 0 && $pengajuanKap->current_step <= count($steps)
            ? $steps[$pengajuanKap->current_step - 1]
            : '-';

        $userHasAccess = DB::table('config_step_review')
            ->where('remark', $currentStepRemark)
            ->where('user_review_id', Auth::id())
            ->exists();

        if ($pengajuanKap->current_step == 2) {


            $endpoint_pusdiklatwap = config('stara.endpoint_pusdiklatwap');
            $api_key_pusdiklatwap = config('stara.api_token_pusdiklatwap');

            // Call API for metode
            $metode_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/metode', [
                'api_key' => $api_key_pusdiklatwap
            ]);

            if (isset($metode_data['error'])) {
                Alert::error('Error', $metode_data['error']);
                return redirect()->back();
            }

            // Call API for diklatType
            $diklatType_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/diklatType', [
                'api_key' => $api_key_pusdiklatwap
            ]);

            if (isset($diklatType_data['error'])) {
                Alert::error('Error', $diklatType_data['error']);
                return redirect()->back();
            }

            // Call API for diklatLocation
            $diklatLocation_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/diklatLocation', [
                'api_key' => $api_key_pusdiklatwap
            ]);

            if (isset($diklatLocation_data['error'])) {
                Alert::error('Error', $diklatLocation_data['error']);
                return redirect()->back();
            }

            $jalur_pembelajaran = [
                'Pelatihan',
                'Seminar/konferensi/sarasehan',
                'Kursus',
                'Lokakarya (workshop)',
                'Belajar mandiri',
                'Coaching',
                'Mentoring',
                'Bimbingan teknis',
                'Sosialisasi',
                'Detasering (secondment)',
                'Job shadowing',
                'Outbond',
                'Benchmarking',
                'Pertukaran PNS',
                'Community of practices',
                'Pelatihan di kantor sendiri',
                'Library cafe',
                'Magang/praktik kerja'
            ];
        }
        $fasilitator_selected = json_decode($pengajuanKap->fasilitator_pembelajaran, true) ?? [];

        return view('pengajuan-kap.show', [
            'pengajuanKap' => $pengajuanKap,
            'fasilitator_selected' => $fasilitator_selected,
            'logReviews' => $logReviews,
            'level_evaluasi_instrumen_kap' => $level_evaluasi_instrumen_kap,
            'indikator_keberhasilan_kap' => $indikator_keberhasilan_kap,
            'waktu_pelaksanaan' => $waktu_pelaksanaan,
            'is_bpkp' => $is_bpkp,
            'frekuensi' => $frekuensi,
            'currentStepRemark' => $currentStepRemark,
            'userHasAccess' => $userHasAccess,
            'jalur_pembelajaran' => isset($jalur_pembelajaran) ? $jalur_pembelajaran : null,
            'metode_data' => isset($metode_data) ? $metode_data : null,
            'diklatType_data' => isset($diklatType_data) ? $diklatType_data : null,
            'diklatLocation_data' => isset($diklatLocation_data) ? $diklatLocation_data : null,
            'currentStepRemark' => $currentStepRemark,
            'pengajuan_kap_indikator_kinerja' => $pengajuan_kap_indikator_kinerja,
            'pengajuan_kap_gap_kompetensi' => $pengajuan_kap_gap_kompetensi
        ]);
    }

    public function approve(Request $request, $id)
    {

        DB::beginTransaction();
        $syncResult = null;
        try {
            // Retrieve the PengajuanKap record by its ID
            $pengajuanKap = DB::table('pengajuan_kap')->find($id);

            // Check for the current_step in PengajuanKap
            $currentStep = $pengajuanKap->current_step;

            // Query the log_review_pengajuan_kap table for the first matching record
            $logReview = DB::table('log_review_pengajuan_kap')
                ->where('pengajuan_kap_id', $id)
                ->where('step', $currentStep)
                ->first();

            // If a matching log review is found, update its fields
            if ($logReview) {
                DB::table('log_review_pengajuan_kap')
                    ->where('id', $logReview->id)
                    ->update([
                        'status' => 'Approved',
                        'tanggal_review' => Carbon::now(),
                        'catatan' => $request->approveNotes,
                        'user_review_id' => Auth::id(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                // After updating log review, get the maximum step from log_review_pengajuan_kap
                $maxStep = DB::table('log_review_pengajuan_kap')
                    ->where('pengajuan_kap_id', $id)
                    ->max('step');

                // Update logic based on the maximum step found
                if ($maxStep === $currentStep) {

                    DB::table('pengajuan_kap')
                        ->where('id', $id)
                        ->update([
                            'status_pengajuan' => 'Approved',
                            'updated_at' => Carbon::now(),
                        ]);

                    if (setting_web()->otomatis_sync_info_diklat == 'Yes') {
                        $syncResult = syncData($pengajuanKap);
                        $statusSync = $syncResult ? 'Success' : 'Failed';

                        // Update status_sync based on sync result
                        DB::table('pengajuan_kap')
                            ->where('id', $id)
                            ->update([
                                'status_sync' => $statusSync,
                                'updated_at' => Carbon::now(),
                            ]);
                    }
                } else {
                    $fasilitator_pembelajaran = $request->input('fasilitator_pembelajaran');
                    $fasilitator_pembelajaran_json = empty($fasilitator_pembelajaran) ? null : json_encode($fasilitator_pembelajaran);

                    if ($currentStep == "2" || $currentStep == 2) {
                        DB::table('pengajuan_kap')
                            ->where('id', $id)
                            ->update([
                                'current_step' => $currentStep + 1,
                                'status_pengajuan' => 'Process',
                                'updated_at' => Carbon::now(),
                                'diklatLocID' => $request->diklatLocID,
                                'diklatLocName' => $request->diklatLocName,
                                'detail_lokasi' => $request->detail_lokasi,
                                'kelas' => $request->kelas,
                                'bentuk_pembelajaran' => $request->bentuk_pembelajaran,
                                'jalur_pembelajaran' => $request->jalur_pembelajaran,
                                'model_pembelajaran' => $request->model_pembelajaran,
                                'diklatTypeID' => $request->diklatTypeID,
                                'diklatTypeName' => $request->diklatTypeName,
                                'peserta_pembelajaran' => $request->peserta_pembelajaran,
                                'sasaran_peserta' => $request->sasaran_peserta,
                                'kriteria_peserta' => $request->kriteria_peserta,
                                'aktivitas_prapembelajaran' => $request->aktivitas_prapembelajaran,
                                'penyelenggara_pembelajaran' => $request->penyelenggara_pembelajaran,
                                'sertifikat' => $request->sertifikat,
                                'fasilitator_pembelajaran' => $fasilitator_pembelajaran_json
                            ]);
                    } else {
                        DB::table('pengajuan_kap')
                            ->where('id', $id)
                            ->update([
                                'current_step' => $currentStep + 1,
                                'status_pengajuan' => 'Process',
                                'updated_at' => Carbon::now(),
                            ]);
                    }

                    if (isset($request->no_level) && isset($request->level_evaluasi_instrumen)) {
                        foreach ($request->no_level as $index => $level) {
                            // Pastikan bahwa array level_evaluasi_instrumen memiliki index yang sesuai
                            if (isset($request->level_evaluasi_instrumen[$index])) {
                                // Periksa apakah data sudah ada di database
                                $existingRecord = DB::table('level_evaluasi_instrumen_kap')
                                    ->where('pengajuan_kap_id', $id)
                                    ->where('level', $level)
                                    ->first();

                                if ($existingRecord) {
                                    // Jika ada, lakukan update
                                    DB::table('level_evaluasi_instrumen_kap')
                                        ->where('id', $existingRecord->id)
                                        ->update([
                                            'keterangan' => $request->level_evaluasi_instrumen[$index],
                                            'updated_at' => now(),
                                        ]);
                                } else {
                                    // Jika tidak ada, lakukan insert
                                    DB::table('level_evaluasi_instrumen_kap')->insert([
                                        'pengajuan_kap_id' => $id,
                                        'level' => $level,
                                        'keterangan' => $request->level_evaluasi_instrumen[$index],
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
            DB::commit();
            if ($syncResult === null) {
                // Sync was not attempted
                Alert::toast('Pengajuan Kap berhasil disetujui.', 'success');
            } else if (!$syncResult) {
                Alert::toast('Pengajuan Kap disetujui, namun gagal sync dengan Info Diklat', 'warning');
            } else {
                Alert::toast('Pengajuan Kap berhasil disetujui dan berhasil disinkronkan dengan Info Diklat.', 'success');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('Gagal menyetujui Pengajuan Kap. Error: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function reject(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Retrieve the PengajuanKap record by its ID
            $pengajuanKap = DB::table('pengajuan_kap')->find($id);

            // Check for the current_step in PengajuanKap
            $currentStep = $pengajuanKap->current_step;

            // Query the log_review_pengajuan_kap table for the first matching record
            $logReview = DB::table('log_review_pengajuan_kap')
                ->where('pengajuan_kap_id', $id)
                ->where('step', $currentStep)
                ->first();

            // If a matching log review is found, update its fields
            if ($logReview) {
                DB::table('log_review_pengajuan_kap')
                    ->where('id', $logReview->id)
                    ->update([
                        'status' => 'Rejected',
                        'tanggal_review' => Carbon::now(),
                        'catatan' => $request->rejectNotes,
                        'user_review_id' => Auth::id(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                // Update pengajuan_kap status to 'Rejected'
                DB::table('pengajuan_kap')
                    ->where('id', $id)
                    ->update([
                        'status_pengajuan' => 'Rejected',
                        'updated_at' => Carbon::now(),
                    ]);
            }

            DB::commit();
            Alert::toast('Pengajuan Kap berhasil ditolak.', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('Gagal menolak Pengajuan Kap. Silakan coba lagi', 'error');

            // Handle the exception, optionally log it or notify the user
            return redirect()->back();
        }
    }

    public function revisi(Request $request, $id)
    {

        DB::beginTransaction();

        try {
            // Retrieve the PengajuanKap record by its ID
            $pengajuanKap = DB::table('pengajuan_kap')->find($id);

            // Check for the current_step in PengajuanKap
            $currentStep = $pengajuanKap->current_step;

            // Query the log_review_pengajuan_kap table for the first matching record
            $logReview = DB::table('log_review_pengajuan_kap')
                ->where('pengajuan_kap_id', $id)
                ->where('step', $currentStep)
                ->first();

            // If a matching log review is found, update its fields
            if ($logReview) {
                DB::table('log_review_pengajuan_kap')
                    ->where('id', $logReview->id)
                    ->update([
                        'status' => 'Revision',
                        'tanggal_review' => Carbon::now(),
                        'catatan' => $request->revisiNotes,
                        'user_review_id' => Auth::id(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                // Update pengajuan_kap status to 'Rejected'
                DB::table('pengajuan_kap')
                    ->where('id', $id)
                    ->update([
                        'status_pengajuan' => 'Revision',
                        'updated_at' => Carbon::now(),
                    ]);
            }

            DB::commit();
            Alert::toast('Pengajuan Kap berhasil direview.', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('Gagal review Pengajuan Kap. Silakan coba lagi', 'error');

            // Handle the exception, optionally log it or notify the user
            return redirect()->back();
        }
    }

    public function cetak_pdf($id, $is_bpkp, $frekuensi)
    {
        $pengajuanKap = DB::table('pengajuan_kap')
            ->select(
                'pengajuan_kap.*',
                'users.name as user_name',
                'users.nama_unit as nama_unit',
                'topik.nama_topik'
            )
            ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
            ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id')
            ->where('pengajuan_kap.id', '=', $id)
            ->where('pengajuan_kap.institusi_sumber', '=', $is_bpkp)
            ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $frekuensi)
            ->first();

        $logReviews = DB::table('log_review_pengajuan_kap')
            ->select(
                'log_review_pengajuan_kap.*',
                'users.name as user_name'
            )
            ->leftJoin('users', 'log_review_pengajuan_kap.user_review_id', '=', 'users.id')
            ->where('log_review_pengajuan_kap.pengajuan_kap_id', '=', $id)
            ->orderBy('log_review_pengajuan_kap.step')
            ->get();

        $level_evaluasi_instrumen_kap = DB::table('level_evaluasi_instrumen_kap')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $indikator_keberhasilan_kap = DB::table('indikator_keberhasilan_kap')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $waktu_pelaksanaan = DB::table('waktu_pelaksanaan')
            ->where('waktu_pelaksanaan.pengajuan_kap_id', $id)
            ->select('waktu_pelaksanaan.*')
            ->get();
        $pengajuan_kap_indikator_kinerja = DB::table('pengajuan_kap_indikator_kinerja')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $pengajuan_kap_gap_kompetensi = DB::table('pengajuan_kap_gap_kompetensi')
            ->join('kompetensi', 'pengajuan_kap_gap_kompetensi.kompetensi_id', '=', 'kompetensi.id')
            ->where('pengajuan_kap_gap_kompetensi.pengajuan_kap_id', $id)
            ->select(
                'pengajuan_kap_gap_kompetensi.*',
                'kompetensi.nama_kompetensi'
            )
            ->get();

        $pdf = PDF::loadview('pengajuan-kap.pdf', [
            'pengajuanKap' => $pengajuanKap,
            'logReviews' => $logReviews,
            'level_evaluasi_instrumen_kap' => $level_evaluasi_instrumen_kap,
            'indikator_keberhasilan_kap' => $indikator_keberhasilan_kap,
            'waktu_pelaksanaan' => $waktu_pelaksanaan,
            'is_bpkp' => $is_bpkp,
            'frekuensi' => $frekuensi,
            'pengajuan_kap_gap_kompetensi' => $pengajuan_kap_gap_kompetensi,
            'pengajuan_kap_indikator_kinerja' => $pengajuan_kap_indikator_kinerja
        ]);
        $namePdf = $pengajuanKap->kode_pembelajaran . '_' . $pengajuanKap->user_name . '.pdf';
        return $pdf->stream($namePdf);
    }

    public function approveSelected(Request $request)
    {
        $ids = $request->ids;
        $approvalNote = $request->note;
        $syncErrors = [];

        DB::beginTransaction();

        try {
            foreach ($ids as $id) {
                // Retrieve the PengajuanKap record by its ID
                $pengajuanKap = DB::table('pengajuan_kap')->find($id);

                // Check for the current_step in PengajuanKap
                $currentStep = $pengajuanKap->current_step;

                // Query the log_review_pengajuan_kap table for the first matching record
                $logReview = DB::table('log_review_pengajuan_kap')
                    ->where('pengajuan_kap_id', $id)
                    ->where('step', $currentStep)
                    ->first();

                // If a matching log review is found, update its fields
                if ($logReview) {
                    DB::table('log_review_pengajuan_kap')
                        ->where('id', $logReview->id)
                        ->update([
                            'status' => 'Approved',
                            'tanggal_review' => Carbon::now(),
                            'catatan' => $approvalNote,
                            'user_review_id' => Auth::id(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    // After updating log review, get the maximum step from log_review_pengajuan_kap
                    $maxStep = DB::table('log_review_pengajuan_kap')
                        ->where('pengajuan_kap_id', $id)
                        ->max('step');

                    // Update logic based on the maximum step found
                    if ($maxStep === $currentStep) {
                        // If the current step matches the max step, update pengajuan_kap status
                        DB::table('pengajuan_kap')
                            ->where('id', $id)
                            ->update([
                                'status_pengajuan' => 'Approved',
                                'updated_at' => Carbon::now(),
                            ]);

                        if (setting_web()->otomatis_sync_info_diklat == 'Yes') {
                            $syncResult = syncData($pengajuanKap);
                            $statusSync = $syncResult ? 'Success' : 'Failed';
                            DB::table('pengajuan_kap')
                                ->where('id', $id)
                                ->update([
                                    'status_sync' => $statusSync,
                                    'updated_at' => Carbon::now(),
                                ]);
                            if (!$syncResult) {
                                $syncErrors[] = $id;
                            }
                        }
                    } else {
                        DB::table('pengajuan_kap')
                            ->where('id', $id)
                            ->update([
                                'current_step' => $currentStep + 1,
                                'status_pengajuan' => 'Process',
                                'updated_at' => Carbon::now(),
                            ]);
                    }
                }
            }

            // Commit transaction if all operations are successful
            DB::commit();

            // Handle sync errors if there are any
            if (!empty($syncErrors)) {
                $message = 'Pengajuan Kap disetujui. Beberapa data gagal sync dengan Aplikasi Info Diklat';
            } else {
                $message = 'Pengajuan Kap berhasil disetujui.';
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            // Rollback on any exception
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui Pengajuan Kap. Silakan coba lagi.'
            ]);
        }
    }

    public function rejectSelected(Request $request)
    {
        $ids = $request->ids;
        $rejectionNote = $request->note;

        DB::beginTransaction();

        try {
            foreach ($ids as $id) {
                // Retrieve the PengajuanKap record by its ID
                $pengajuanKap = DB::table('pengajuan_kap')->find($id);

                // Check for the current_step in PengajuanKap
                $currentStep = $pengajuanKap->current_step;

                // Query the log_review_pengajuan_kap table for the first matching record
                $logReview = DB::table('log_review_pengajuan_kap')
                    ->where('pengajuan_kap_id', $id)
                    ->where('step', $currentStep)
                    ->first();

                // If a matching log review is found, update its fields
                if ($logReview) {
                    DB::table('log_review_pengajuan_kap')
                        ->where('id', $logReview->id)
                        ->update([
                            'status' => 'Rejected',
                            'tanggal_review' => Carbon::now(),
                            'catatan' => $rejectionNote,
                            'user_review_id' => Auth::id(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    // Update pengajuan_kap status to 'Rejected'
                    DB::table('pengajuan_kap')
                        ->where('id', $id)
                        ->update([
                            'status_pengajuan' => 'Rejected',
                            'updated_at' => Carbon::now(),
                        ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pengajuan Kap berhasil ditolak.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Gagal menolak Pengajuan Kap. Silakan coba lagi.']);
        }
    }

    public function skipSelected(Request $request)
    {
        $ids = $request->ids;
        $approvalNote = $request->note;
        $syncErrors = [];

        DB::beginTransaction();

        try {
            foreach ($ids as $id) {
                $pengajuanKap = DB::table('pengajuan_kap')->find($id);

                $currentStep = $pengajuanKap->current_step;

                $logReview = DB::table('log_review_pengajuan_kap')
                    ->where('pengajuan_kap_id', $id)
                    ->where('step', $currentStep)
                    ->first();

                if ($logReview) {
                    DB::table('log_review_pengajuan_kap')
                        ->where('id', $logReview->id)
                        ->update([
                            'status' => 'Skiped',
                            'tanggal_review' => Carbon::now(),
                            'catatan' => $approvalNote,
                            'user_review_id' => Auth::id(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    $maxStep = DB::table('log_review_pengajuan_kap')
                        ->where('pengajuan_kap_id', $id)
                        ->max('step');

                    if ($maxStep === $currentStep) {
                        DB::table('pengajuan_kap')
                            ->where('id', $id)
                            ->update([
                                'status_pengajuan' => 'Approved',
                                'updated_at' => Carbon::now(),
                            ]);

                        if (setting_web()->otomatis_sync_info_diklat == 'Yes') {
                            $syncResult = syncData($pengajuanKap);
                            $statusSync = $syncResult ? 'Success' : 'Failed';
                            DB::table('pengajuan_kap')
                                ->where('id', $id)
                                ->update([
                                    'status_sync' => $statusSync,
                                    'updated_at' => Carbon::now(),
                                ]);
                            if (!$syncResult) {
                                $syncErrors[] = $id;
                            }
                        }
                    } else {
                        DB::table('pengajuan_kap')
                            ->where('id', $id)
                            ->update([
                                'current_step' => $currentStep + 1,
                                'status_pengajuan' => 'Process',
                                'updated_at' => Carbon::now(),
                            ]);
                    }
                }
            }
            DB::commit();

            if (!empty($syncErrors)) {
                $message = 'Pengajuan Kap di-skip. Beberapa data gagal sync dengan Aplikasi Info Diklat';
            } else {
                $message = 'Pengajuan Kap berhasil di-skip.';
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal skip Pengajuan Kap: ' . $e->getMessage()
            ]);
        }
    }

    public function exportPengajuanKap(Request $request)
    {
        // Ambil data dari query string
        $tahun = $request->query('year');
        $topik = $request->query('topik');
        $step = $request->query('step');
        $status_pengajuan = $request->query('status_pengajuan');
        $is_bpkp = $request->query('is_bpkp');
        $frekuensi = $request->query('frekuensi');
        $unit_kerja = $request->query('unit_kerja'); // array dari select multiple
        $prioritas = $request->query('prioritas');   // array dari select multiple

        // Penamaan file yang akan didownload
        $nameFile = 'Kalender pembelajaran ' . now()->format('Ymd_His') . '.xlsx';

        // Unduh file Excel dengan data yang dihasilkan oleh ExportPengajuanKap
        return Excel::download(new ExportPengajuanKap(
            $tahun,
            $topik,
            $step,
            $status_pengajuan,
            $is_bpkp,
            $frekuensi,
            $unit_kerja,
            $prioritas
        ), $nameFile);
    }

    public function check($qrCode)
    {
        $pengajuan = DB::table('pengajuan_kap')->where('kode_pembelajaran', $qrCode)->first();
        if ($pengajuan) {
            return response()->json([
                'exists' => true,
                'id' => $pengajuan->id,
                'is_bpkp' => $pengajuan->institusi_sumber,
                'frekuensi' => $pengajuan->frekuensi_pelaksanaan
            ]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
}
