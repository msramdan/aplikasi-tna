<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExportTopikPembelajaran implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    public function title(): string
    {
        return 'Data pembelajaran';
    }


    public function view(): View
    {

        $data = DB::table('topik')
            ->leftJoin('rumpun_pembelajaran', 'topik.rumpun_pembelajaran_id', '=', 'rumpun_pembelajaran.id')
            ->select('topik.*', 'rumpun_pembelajaran.rumpun_pembelajaran')
            ->get();
        return view('topik.topik_pembelajaran_excel', [
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
