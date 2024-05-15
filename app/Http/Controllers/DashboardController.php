<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;



class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalLokasi = DB::table('lokasi')->count();
        $totalAsrama = DB::table('asrama')->count();
        $totalKelas = DB::table('ruang_kelas')->count();
        $totalUser = DB::table('users')->count();
        return view('dashboard', [
            'totalLokasi' => $totalLokasi,
            'totalAsrama' => $totalAsrama,
            'totalKelas' => $totalKelas,
            'totalUser' => $totalUser
        ]);
    }
}
