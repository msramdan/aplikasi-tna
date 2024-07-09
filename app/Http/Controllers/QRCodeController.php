<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function generateQRCode()
    {
        $url = '/pengajuan-kap/{is_bpkp}/{frekuensi}'; // Ganti dengan URL yang Anda inginkan
        $qrCode = QrCode::size(300)->generate($url);
        return view('layouts.app', compact('qrCode')); // Mengirim 'qrCode' ke view utama
    }
}
