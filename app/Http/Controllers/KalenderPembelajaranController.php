<?php

namespace App\Http\Controllers;

use App\Exports\ExportKalenderPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class KalenderPembelajaranController extends Controller
{

    public function index($tahun, $topik, $sumber_dana)
    {
        $topiks = DB::table('topik')->get();
        return view('kalender-pembelajaran.index', [
            'year' => $tahun,
            'topiks' => $topiks,
            'sumberDana' => $sumber_dana,
            'selectedTopik' => $topik,
        ]);
    }

    public function getEvents(Request $request)
    {
        $year = $request->input('year');
        $topik = $request->input('topik');
        $sumber_dana = $request->input('sumber_dana');

        $query = DB::table('waktu_tempat')
            ->leftJoin('pengajuan_kap', 'waktu_tempat.pengajuan_kap_id', '=', 'pengajuan_kap.id')
            ->leftJoin('lokasi', 'waktu_tempat.lokasi_id', '=', 'lokasi.id')
            ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id') // Menggunakan leftJoin jika topik bisa null
            ->where('pengajuan_kap.tahun', $year)
            ->where('pengajuan_kap.status_pengajuan', 'Approved');

        if ($topik && $topik != 'All') {
            $query->where('pengajuan_kap.topik_id', $topik);
        }

        if ($sumber_dana && $sumber_dana != 'All') {
            $query->where('pengajuan_kap.sumber_dana', $sumber_dana);
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
            'topik.nama_topik'
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

    public function exportKalenderPembelajaran(Request $request)
    {
        $tahun = $request->query('year');
        $topik = $request->query('topik');
        $sumber_dana = $request->query('sumber_dana');
        $nameFile = 'Kalender pembelajaran ' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new ExportKalenderPembelajaran($tahun, $topik, $sumber_dana), $nameFile);
    }
}
