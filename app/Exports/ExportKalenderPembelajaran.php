<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;


class ExportKalenderPembelajaran implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    public $tahun;
    public $topik;
    public $sumber_dana;
    public $waktu_pelaksanaan;

    public function __construct($tahun, $topik, $sumber_dana, $waktu_pelaksanaan)
    {
        $this->tahun = $tahun;
        $this->topik = $topik;
        $this->sumber_dana = $sumber_dana;
        $this->waktu_pelaksanaan = $waktu_pelaksanaan;
    }


    public function title(): string
    {
        return 'Kalender pembelajaran';
    }


    public function view(): View
    {
        $query = DB::table('waktu_tempat')
            ->leftJoin('pengajuan_kap', 'waktu_tempat.pengajuan_kap_id', '=', 'pengajuan_kap.id')
            ->leftJoin('lokasi', 'waktu_tempat.lokasi_id', '=', 'lokasi.id')
            ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id')
            ->leftJoin('kompetensi', 'pengajuan_kap.kompetensi_id', '=', 'kompetensi.id')
            ->where('pengajuan_kap.tahun', $this->tahun)
            ->where('pengajuan_kap.status_pengajuan', 'Approved');

        if ($this->topik && $this->topik != 'All') {
            $query->where('pengajuan_kap.topik_id', $this->topik);
        }

        if ($this->sumber_dana && $this->sumber_dana != 'All') {
            $query->where('pengajuan_kap.sumber_dana', $this->sumber_dana);
        }

        if ($this->waktu_pelaksanaan && $this->waktu_pelaksanaan != 'All') {
            $query->where('pengajuan_kap.frekuensi_pelaksanaan', $this->waktu_pelaksanaan);
        }

        $data = $query->select(
            'waktu_tempat.tanggal_mulai as start',
            'waktu_tempat.tanggal_selesai as end',
            'pengajuan_kap.*',
            'lokasi.nama_lokasi',
            'kompetensi.nama_kompetensi as nama_kompetensi',
            'topik.nama_topik'
        )->get();

        return view('kalender-pembelajaran.kalender_pembelajaran_excel', [
            'data' => $data
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:M1';
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
