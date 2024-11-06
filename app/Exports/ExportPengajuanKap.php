<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;


class ExportPengajuanKap implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    public $tahun;
    public $topik;
    public $step;
    public $status_pengajuan;
    public $is_bpkp;
    public $frekuensi;
    public $unit_kerja;
    public $prioritas;

    public function __construct($tahun, $topik, $step, $status_pengajuan, $is_bpkp, $frekuensi, $unit_kerja, $prioritas)
    {
        $this->tahun = $tahun;
        $this->topik = $topik;
        $this->step = $step;
        $this->status_pengajuan = $status_pengajuan;
        $this->is_bpkp = $is_bpkp;
        $this->frekuensi = $frekuensi;
        $this->unit_kerja = $unit_kerja;
        $this->prioritas = $prioritas;
    }


    public function title(): string
    {
        return 'Kalender pembelajaran';
    }


    public function view(): View
    {
        $pengajuanKaps = DB::table('pengajuan_kap')
            ->select(
                'pengajuan_kap.*',
                'users.name as user_name',
                'users.nama_unit',
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT("<li>", kompetensi.nama_kompetensi, "</li>")) as nama_kompetensi'),
                'topik.nama_topik',
                'log_review_pengajuan_kap.remark'
            )
            ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
            ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id')
            ->leftJoin('pengajuan_kap_gap_kompetensi', 'pengajuan_kap.id', '=', 'pengajuan_kap_gap_kompetensi.pengajuan_kap_id')
            ->leftJoin('kompetensi', 'pengajuan_kap_gap_kompetensi.kompetensi_id', '=', 'kompetensi.id')
            ->join('log_review_pengajuan_kap', function ($join) {
                $join->on('pengajuan_kap.id', '=', 'log_review_pengajuan_kap.pengajuan_kap_id')
                    ->whereColumn('log_review_pengajuan_kap.step', 'pengajuan_kap.current_step');
            })
            ->where('pengajuan_kap.institusi_sumber', '=', $this->is_bpkp)
            ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $this->frekuensi)
            ->groupBy('pengajuan_kap.id', 'users.name', 'users.nama_unit', 'topik.nama_topik', 'log_review_pengajuan_kap.remark');


        // Filter based on tahun
        if (isset($this->tahun) && !empty($this->tahun) && $this->tahun != 'All') {
            $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.tahun', $this->tahun);
        }

        // Filter based on topik
        if (isset($this->topik) && !empty($this->topik) && $this->topik != 'All') {
            $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.topik_id', $this->topik);
        }

        // Filter based on current_step
        if (isset($this->step) && !empty($this->step) && $this->step != 'All') {
            $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.current_step', $this->step);
        }

        // Filter based on status
        if (isset($this->status_pengajuan) && !empty($this->status_pengajuan) && $this->status_pengajuan != 'All') {
            $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.status_pengajuan', $this->status_pengajuan);
        }

        // Filter based on unit_kerja
        if (!empty($this->unit_kerja)) {
            $pengajuanKaps = $pengajuanKaps->whereIn('users.nama_unit', $this->unit_kerja);
        }

        // Filter based on prioritas_pembelajaran
        if (!empty($this->prioritas)) {
            $pengajuanKaps = $pengajuanKaps->whereIn('pengajuan_kap.prioritas_pembelajaran', $this->prioritas);
        }

        $pengajuanKaps = $pengajuanKaps->orderBy('pengajuan_kap.id', 'DESC')->get();

        return view('pengajuan-kap.pengajuan_kap_excel', [
            'data' => $pengajuanKaps
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:J1';
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
