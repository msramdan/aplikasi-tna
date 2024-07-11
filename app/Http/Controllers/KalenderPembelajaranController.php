<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KalenderPembelajaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kalender pembelajaran view')->only('index', 'show');
        $this->middleware('permission:kalender pembelajaran create')->only('create', 'store');
        $this->middleware('permission:kalender pembelajaran edit')->only('edit', 'update');
        $this->middleware('permission:kalender pembelajaran delete')->only('destroy');
    }

    public function index($tahun)
    {
        return view('kalender-pembelajaran.index', [
            'year' => $tahun,
        ]);
    }

    public function getEvents(Request $request)
    {
        $year = '2024';
        $events = DB::table('waktu_tempat')
            ->join('pengajuan_kap', 'waktu_tempat.pengajuan_kap_id', '=', 'pengajuan_kap.id')
            ->join('lokasi', 'waktu_tempat.lokasi_id', '=', 'lokasi.id')
            ->where('pengajuan_kap.tahun', $year)
            ->select(
                'waktu_tempat.tanggal_mulai as start',
                'waktu_tempat.tanggal_selesai as end',
                'pengajuan_kap.kode_pembelajaran',
                'pengajuan_kap.institusi_sumber',
                'pengajuan_kap.jenis_program',
                'pengajuan_kap.frekuensi_pelaksanaan',
                'pengajuan_kap.tujuan_program_pembelajaran',
                'lokasi.type as type_lokasi',
                'lokasi.nama_lokasi'
            )
            ->get();

        $events = $events->map(function ($event) {
            return [
                'title' => $event->institusi_sumber,
                'start' => \Carbon\Carbon::parse($event->start)->format('Y-m-d\TH:i:s'),
                'end' => \Carbon\Carbon::parse($event->end)->format('Y-m-d\TH:i:s'),
                'description' => $event->tujuan_program_pembelajaran,
            ];
        });

        return response()->json($events);
    }
}
