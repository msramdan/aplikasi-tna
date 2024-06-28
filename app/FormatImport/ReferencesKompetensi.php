<?php

namespace App\FormatImport;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Kompetensi;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReferencesKompetensi implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    public function title(): string
    {
        return 'References Kompetensi';
    }

    public function view(): View
    {
        $data = Kompetensi::orderBy('id', 'desc')->get();
        return view('tagging-pembelajaran-kompetensi.references_kompetensi', [
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
