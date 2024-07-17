<?php

namespace App\FormatImport;

use App\Models\Topik;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\Http;

class ReferencesIK implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function title(): string
    {
        return 'References IK ' . $this->type;
    }

    public function view(): View
    {
        if ($this->type === 'renstra') {
            $endpoint = config('stara.endpoint') . '/simaren/ref-indikator-kinerja-es2';
        } elseif ($this->type === 'app') {
            $endpoint = config('stara.endpoint') . '/simaren/ref-topik-app';
        } elseif ($this->type === 'apep') {
            $endpoint = config('stara.endpoint') . '/simaren/ref-topik-apep';
        } else {
            abort(404, 'Coming soon');
        }
        $token = session('api_token');
        $response = Http::withToken($token)->get($endpoint);
        if ($response->failed()) {
            abort(500, 'Failed to fetch data from API');
        }
        $data = $response->json()['data'];
        return view('tagging-kompetensi-ik.references_ik', [
            'data' => $data,
            'type' => $this->type
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
