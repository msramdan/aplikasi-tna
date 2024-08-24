<?php

namespace App\Http\Controllers;

use App\Exports\ExportKalenderPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class KalenderPembelajaranController extends Controller
{

    public function index($tahun, $waktu_pelaksanaan, $sumber_dana, $topik)
    {
        $topiks = DB::table('topik')->get();
        return view('kalender-pembelajaran.index', [
            'topiks' => $topiks,
            'year' => $tahun,
            'waktuPelaksanaan' => $waktu_pelaksanaan,
            'sumberDana' => $sumber_dana,
            'selectedTopik' => $topik,
        ]);
    }

    public function getEvents(Request $request)
    {
        $year = $request->input('year');
        $waktu_pelaksanaan = $request->input('waktu_pelaksanaan');
        $sumber_dana = $request->input('sumber_dana');
        $topik = $request->input('topik');
        $query = DB::table('waktu_pelaksanaan')
            ->leftJoin('pengajuan_kap', 'waktu_pelaksanaan.pengajuan_kap_id', '=', 'pengajuan_kap.id')
            ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id') // Menggunakan leftJoin jika topik bisa null
            ->where('pengajuan_kap.tahun', $year)
            ->where('pengajuan_kap.status_pengajuan', 'Approved');

        if ($waktu_pelaksanaan && $waktu_pelaksanaan != 'All') {
            $query->where('pengajuan_kap.frekuensi_pelaksanaan', $waktu_pelaksanaan);
        }

        if ($sumber_dana && $sumber_dana != 'All') {
            $query->where('pengajuan_kap.sumber_dana', $sumber_dana);
        }


        if ($topik && $topik != 'All') {
            $query->where('pengajuan_kap.topik_id', $topik);
        }


        $events = $query->select(
            'waktu_pelaksanaan.tanggal_mulai as start',
            'waktu_pelaksanaan.tanggal_selesai as end',
            'waktu_pelaksanaan.remarkMetodeName',
            'pengajuan_kap.kode_pembelajaran',
            'pengajuan_kap.institusi_sumber',
            'pengajuan_kap.jenis_program',
            'pengajuan_kap.frekuensi_pelaksanaan',
            'pengajuan_kap.tujuan_program_pembelajaran',
            'topik.nama_topik'
        )->get();

        $events = $events->map(function ($event) {
            return [
                'kode_pembelajaran' => $event->kode_pembelajaran,
                'institusi_sumber' => $event->institusi_sumber,
                'jenis_program' => $event->jenis_program,
                'frekuensi_pelaksanaan' => $event->frekuensi_pelaksanaan,
                'title' => $event->nama_topik,
                'remarkMetodeName' => $event->remarkMetodeName,
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
        $waktu_pelaksanaan = $request->query('waktu_pelaksanaan');
        $sumber_dana = $request->query('sumber_dana');
        $topik = $request->query('topik');
        $nameFile = 'Kalender pembelajaran ' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new ExportKalenderPembelajaran($tahun, $topik, $sumber_dana, $waktu_pelaksanaan), $nameFile);
    }
}
