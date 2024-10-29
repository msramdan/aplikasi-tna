<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;


class ExportTaggingPembelakaranKompetensiReverse implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    public function title(): string
    {
        return 'Tag kompetensi - pembelajaran';
    }

    public function view(): View
    {

        $data = DB::table('tagging_pembelajaran_kompetensi')
            ->join('topik', 'tagging_pembelajaran_kompetensi.topik_id', '=', 'topik.id')
            ->join('kompetensi', 'tagging_pembelajaran_kompetensi.kompetensi_id', '=', 'kompetensi.id')
            ->select(
                'tagging_pembelajaran_kompetensi.id',
                'topik.nama_topik',
                'kompetensi.nama_kompetensi'
            )
            ->get();

        return view('tagging-pembelajaran-kompetensi-reverse.tagging_pembelajaran_kompetensi_excel', [
            'data' => $data
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:C1';
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
