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

    public function index($tahun, $topik)
    {
        $topiks = DB::table('topik')->get();

        return view('kalender-pembelajaran.index', [
            'year' => $tahun,
            'topiks' => $topiks,
            'selectedTopik' => $topik,
        ]);
    }

    public function getEvents(Request $request)
    {
        $year = $request->input('year');
        $topik = $request->input('topik');

        $query = DB::table('waktu_tempat')
            ->leftJoin('pengajuan_kap', 'waktu_tempat.pengajuan_kap_id', '=', 'pengajuan_kap.id')
            ->leftJoin('lokasi', 'waktu_tempat.lokasi_id', '=', 'lokasi.id')
            ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id') // Menggunakan leftJoin jika topik bisa null
            ->where('pengajuan_kap.tahun', $year)
            ->where('pengajuan_kap.status_pengajuan', 'Approved');

        if ($topik && $topik != 'All') {
            $query->where('pengajuan_kap.topik_id', $topik);
        }

        $events = $query->select(
            'waktu_tempat.tanggal_mulai as start',
            'waktu_tempat.tanggal_selesai as end',
            'pengajuan_kap.kode_pembelajaran',
            'pengajuan_kap.institusi_sumber',
            'pengajuan_kap.jenis_program',
            'pengajuan_kap.frekuensi_pelaksanaan',
            'pengajuan_kap.tujuan_program_pembelajaran',
            'lokasi.type as type_lokasi',
            'lokasi.nama_lokasi',
            'topik.nama_topik' // Kolom dari tabel topik
        )->get();

        $events = $events->map(function ($event) {
            return [
                'kode_pembelajaran' => $event->kode_pembelajaran,
                'institusi_sumber' => $event->institusi_sumber,
                'jenis_program' => $event->jenis_program,
                'frekuensi_pelaksanaan' => $event->frekuensi_pelaksanaan,
                'title' => $event->nama_topik,
                'start' => \Carbon\Carbon::parse($event->start)->format('Y-m-d\TH:i:s'),
                'end' => \Carbon\Carbon::parse($event->end)->addDay()->format('Y-m-d\TH:i:s'),
                'description' => $event->tujuan_program_pembelajaran,
                'allDay' => true,
            ];
        });

        return response()->json($events);
    }
}
