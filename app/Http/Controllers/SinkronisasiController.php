<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SinkronisasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:sinkronisasi view')->only('index');
    }

    public function index(Request $request, $is_bpkp, $frekuensi)
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
                ->where('pengajuan_kap.institusi_sumber', '=', $is_bpkp)
                ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $frekuensi);

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
                    $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.sumber_dana', $sumber_dana);
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
                ->addColumn('status_kap', function ($row) {
                    return $row->status_pengajuan;
                })
                ->addColumn('remark', function ($row) {
                    return $row->remark;
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
                    }
                })
                ->addColumn('action', 'pengajuan-kap.include.action')
                ->rawColumns(['status_pengajuan', 'action'])
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
        return view('pengajuan-kap.index', [
            'year' => $tahun,
            'is_bpkp' => $is_bpkp,
            'frekuensi' => $frekuensi,
            'reviewRemarks' => $reviewRemarks,
            'topiks' => $topiks,
            'topik_id' => $topik,
            'sumberDana' => $sumber_dana,
            'curretnStep' => $curretnStep
        ]);
    }
}
