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
    public $sumber_dana;
    public $topik;
    public $step;
    public $is_bpkp;
    public $frekuensi;
    public $unit_kerja;
    public $prioritas;

    public function __construct($tahun, $sumber_dana, $topik, $step, $is_bpkp, $frekuensi, $unit_kerja, $prioritas)
    {
        $this->tahun = $tahun;
        $this->topik = $topik;
        $this->sumber_dana = $sumber_dana;
        $this->step = $step;
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
            ->where('pengajuan_kap.institusi_sumber', '=', $this->is_bpkp)
            ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $this->frekuensi);

        // Filter based on tahun
        if (isset($this->tahun) && !empty($this->tahun) && $this->tahun != 'All') {
            $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.tahun', $this->tahun);
        }

        // Filter based on topik
        if (isset($this->topik) && !empty($this->topik) && $this->topik != 'All') {
            $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.topik_id', $this->topik);
        }

        // Filter based on sumber_dana
        if (isset($this->sumber_dana) && !empty($this->sumber_dana) && $this->sumber_dana != 'All') {
            $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.biayaName', $this->sumber_dana);
        }

        // Filter based on current_step
        if (isset($this->step) && !empty($this->step) && $this->step != 'All') {
            $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.current_step', $this->step);
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
                $cellRange = 'A1:I1';
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
