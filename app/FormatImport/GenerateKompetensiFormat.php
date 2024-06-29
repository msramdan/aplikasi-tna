<?php

namespace App\FormatImport;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;


class GenerateKompetensiFormat implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison,WithTitle
{
    public function title(): string
    {
        return 'Format import';
    }


    public function view(): View
    {
        return view('kompetensi.format_import');
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:H1'; // All headers
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Kelompok besar
                $kolom_a = 'A';
                $dataKolomA = [];
                $getDataKelompokBesar = DB::table('kelompok_besar')->get();
                foreach ($getDataKelompokBesar as $a) {
                    array_push($dataKolomA, $a->nama_kelompok_besar);
                }
                $validationA = $event->sheet->getCell("{$kolom_a}2")->getDataValidation();
                $validationA->setType(DataValidation::TYPE_LIST);
                $validationA->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationA->setAllowBlank(false);
                $validationA->setShowInputMessage(true);
                $validationA->setShowErrorMessage(true);
                $validationA->setShowDropDown(true);
                $validationA->setErrorTitle('Input error');
                $validationA->setError('Value is not in list.');
                $validationA->setPromptTitle('Pick from list');
                $validationA->setPrompt('Please pick a value from the drop-down list.');
                $validationA->setFormula1(sprintf('"%s"', implode(',', $dataKolomA)));

                // kategori
                $kolom_b = 'B';
                $dataKolomB = [];
                $getDataKategori = DB::table('kategori_kompetensi')->get();
                foreach ($getDataKategori as $b) {
                    array_push($dataKolomB, $b->nama_kategori_kompetensi);
                }
                $validationB = $event->sheet->getCell("{$kolom_b}2")->getDataValidation();
                $validationB->setType(DataValidation::TYPE_LIST);
                $validationB->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationB->setAllowBlank(false);
                $validationB->setShowInputMessage(true);
                $validationB->setShowErrorMessage(true);
                $validationB->setShowDropDown(true);
                $validationB->setErrorTitle('Input error');
                $validationB->setError('Value is not in list.');
                $validationB->setPromptTitle('Pick from list');
                $validationB->setPrompt('Please pick a value from the drop-down list.');
                $validationB->setFormula1(sprintf('"%s"', implode(',', $dataKolomB)));

                // nama akademi
                $kolom_c = 'C';
                $dataKolomC = [];
                $getDataAkademi = DB::table('akademi')->get();
                foreach ($getDataAkademi as $c) {
                    array_push($dataKolomC, $c->nama_akademi);
                }
                $validationC = $event->sheet->getCell("{$kolom_c}2")->getDataValidation();
                $validationC->setType(DataValidation::TYPE_LIST);
                $validationC->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationC->setAllowBlank(false);
                $validationC->setShowInputMessage(true);
                $validationC->setShowErrorMessage(true);
                $validationC->setShowDropDown(true);
                $validationC->setErrorTitle('Input error');
                $validationC->setError('Value is not in list.');
                $validationC->setPromptTitle('Pick from list');
                $validationC->setPrompt('Please pick a value from the drop-down list.');
                $validationC->setFormula1(sprintf('"%s"', implode(',', $dataKolomC)));

                for ($i = 2; $i <= 1000; $i++) {
                    $event->sheet->getCell("{$kolom_a}{$i}")->setDataValidation(clone $validationA);
                    $event->sheet->getCell("{$kolom_b}{$i}")->setDataValidation(clone $validationB);
                    $event->sheet->getCell("{$kolom_c}{$i}")->setDataValidation(clone $validationC);
                }
            },
        ];
    }
}
