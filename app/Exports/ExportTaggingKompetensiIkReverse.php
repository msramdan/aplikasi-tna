<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;


class ExportTaggingKompetensiIkReverse implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }


    public function title(): string
    {
        return 'Tag IK ' . $this->type . ' - kompetensi';
    }

    public function view(): View
    {
        $type = $this->type;
        $data = DB::table('tagging_kompetensi_ik')
            ->join('kompetensi', 'tagging_kompetensi_ik.kompetensi_id', '=', 'kompetensi.id')
            ->where('tagging_kompetensi_ik.type', '=', $type)
            ->select(
                'tagging_kompetensi_ik.indikator_kinerja',
                'kompetensi.nama_kompetensi'
            )
            ->get();
        return view('tagging-kompetensi-ik-reverse.tagging_kompetensi_ik_excel', [
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
