<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;



class SyncInfoIDiklatController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pengajuan kap view')->only('index', 'show');
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $tahun = $request->query('tahun');
            $topik = intval($request->query('topik'));
            $sumber_dana = $request->query('sumber_dana');
            $current_step = intval($request->query('step'));
            $pengajuanKaps = DB::table('pengajuan_kap')
                ->select(
                    'pengajuan_kap.*',
                    'users.name as user_name',
                    'kompetensi.nama_kompetensi',
                    'topik.nama_topik',
                    'log_review_pengajuan_kap.remark'
                )
                ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
                ->leftJoin('kompetensi', 'pengajuan_kap.kompetensi_id', '=', 'kompetensi.id')
                ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id')
                ->join('log_review_pengajuan_kap', function ($join) {
                    $join->on('pengajuan_kap.id', '=', 'log_review_pengajuan_kap.pengajuan_kap_id')
                        ->whereColumn('log_review_pengajuan_kap.step', 'pengajuan_kap.current_step');
                })
                ->where('pengajuan_kap.status_pengajuan', '=', 'Approved');


            if (isset($tahun) && !empty($tahun)) {
                if ($tahun != 'All') {
                    $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.tahun', $tahun);
                }
            }

            if (isset($topik) && !empty($topik)) {
                if ($topik != 'All') {
                    $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.topik_id', $topik);
                }
            }

            if (isset($sumber_dana) && !empty($sumber_dana)) {
                if ($sumber_dana != 'All') {
                    $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.biayaName', $sumber_dana);
                }
            }

            if (isset($current_step) && !empty($current_step)) {
                if ($current_step != 'All') {
                    $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.current_step', $current_step);
                }
            }
            $pengajuanKaps = $pengajuanKaps->orderBy('pengajuan_kap.id', 'DESC');
            return DataTables::of($pengajuanKaps)
                ->addIndexColumn()
                ->addColumn('status_sync', function ($row) {
                    if ($row->status_sync == 'Waiting') {
                        return '<button style="width:90px" class="btn btn-gray btn-sm btn-block"><i class="fa fa-clock" aria-hidden="true"></i> Waiting</button>';
                    } else if ($row->status_sync == 'Success') {
                        return '<button style="width:90px" class="btn btn-success btn-sm btn-block"><i class="fa fa-check" aria-hidden="true"></i> Success</button>';
                    } else if ($row->status_sync == 'Failed') {
                        return '<button style="width:90px" class="btn btn-danger btn-sm btn-block"><i class="fa fa-times" aria-hidden="true"></i> Failed</button>';
                    }
                })
                ->addColumn('action', 'sync-info-diklat.include.action')
                ->rawColumns(['status_sync', 'action'])
                ->toJson();
        }

        $topiks = DB::table('topik')->get();
        $tahun = date('Y');
        $userId = Auth::id();
        $reviewRemarks = DB::table('config_step_review')
            ->where('user_review_id', $userId)
            ->pluck('remark')
            ->toArray();
        $topik = intval($request->query('topik'))  ?? 'All';
        $sumber_dana = $request->query('sumber_dana') ?? 'All';
        $curretnStep = intval($request->query('step'))  ?? 'All';
        return view('sync-info-diklat.index', [
            'year' => $tahun,
            'reviewRemarks' => $reviewRemarks,
            'topiks' => $topiks,
            'topik_id' => $topik,
            'sumberDana' => $sumber_dana,
            'curretnStep' => $curretnStep
        ]);
    }

    public function show($id)
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
        $gap_kompetensi_pengajuan_kap = DB::table('gap_kompetensi_pengajuan_kap')
            ->where('pengajuan_kap_id', $id)
            ->first();

        return view('sync-info-diklat.show', [
            'pengajuanKap' => $pengajuanKap,
            'logReviews' => $logReviews,
            'level_evaluasi_instrumen_kap' => $level_evaluasi_instrumen_kap,
            'indikator_keberhasilan_kap' => $indikator_keberhasilan_kap,
            'waktu_pelaksanaan' => $waktu_pelaksanaan,
            'currentStepRemark' => $currentStepRemark,
            'userHasAccess' => $userHasAccess,
            'gap_kompetensi_pengajuan_kap' => $gap_kompetensi_pengajuan_kap
        ]);
    }

    public function cetak_pdf($id)
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
        $gap_kompetensi_pengajuan_kap = DB::table('gap_kompetensi_pengajuan_kap')
            ->where('pengajuan_kap_id', $id)
            ->first();

        $pdf = PDF::loadview('sync-info-diklat.pdf', [
            'pengajuanKap' => $pengajuanKap,
            'logReviews' => $logReviews,
            'level_evaluasi_instrumen_kap' => $level_evaluasi_instrumen_kap,
            'indikator_keberhasilan_kap' => $indikator_keberhasilan_kap,
            'waktu_pelaksanaan' => $waktu_pelaksanaan,
            'gap_kompetensi_pengajuan_kap' => $gap_kompetensi_pengajuan_kap
        ]);
        return $pdf->stream('pengajuan-kap.pdf');
    }
}
