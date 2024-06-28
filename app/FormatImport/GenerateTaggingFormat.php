<?php

namespace App\FormatImport;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\EquipmentCategory;
use App\Models\Vendor;
use App\Models\EquipmentLocation;
use App\Models\Nomenklatur;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Auth;



class GenerateTaggingFormat implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison, WithTitle
{
    public function title(): string
    {
        return 'Format import';
    }

    public function view(): View
    {
        return view('tagging-pembelajaran-kompetensi.format_import');
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:B1'; // All headers
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
