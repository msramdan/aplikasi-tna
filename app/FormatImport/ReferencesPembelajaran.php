<?php

namespace App\FormatImport;

use App\Models\Topik;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReferencesPembelajaran implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    public function title(): string
    {
        return 'References Pembelajaran';
    }

    public function view(): View
    {
        $data = Topik::orderBy('id', 'desc')->get();
        return view('tagging-pembelajaran-kompetensi.references_pembelajaran', [
            'data' => $data
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:A1'; // All headers
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
