<?php

namespace App\FormatImport;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Kompetensi;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\DB;

class ReferencesRumpunPembelajaran implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    public function title(): string
    {
        return 'References rumpun pembelajaran';
    }

    public function view(): View
    {
        $data = DB::table('rumpun_pembelajaran')->orderBy('id', 'desc')->get();
        return view('topik.references_rumpun_pembelajaran', [
            'data' => $data
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:A1';
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
