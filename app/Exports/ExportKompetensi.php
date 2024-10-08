<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;


class ExportKompetensi implements FromView, ShouldAutoSize, WithEvents,WithTitle
{
    public function title(): string
    {
        return 'Data kompetensi';
    }


    public function view(): View
    {

        $data = DB::table('kompetensi_detail')
            ->join('kompetensi', 'kompetensi_detail.kompetensi_id', '=', 'kompetensi.id')
            ->leftJoin('kelompok_besar', 'kompetensi.kelompok_besar_id', '=', 'kelompok_besar.id')
            ->leftJoin('akademi', 'kompetensi.akademi_id', '=', 'akademi.id')
            ->leftJoin('kategori_kompetensi', 'kompetensi.kategori_kompetensi_id', '=', 'kategori_kompetensi.id')
            ->select(
                'kompetensi_detail.level',
                'kompetensi_detail.deskripsi_level',
                'kompetensi_detail.indikator_perilaku',
                'kompetensi.nama_kompetensi',
                'kompetensi.deskripsi_kompetensi',
                'kelompok_besar.nama_kelompok_besar',
                'akademi.nama_akademi',
                'kategori_kompetensi.nama_kategori_kompetensi'
            )->orderBy('kompetensi.nama_kompetensi', 'ASC')->get();

        return view('kompetensi.kamus_kompetensi_excel', [
            'data' => $data
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
