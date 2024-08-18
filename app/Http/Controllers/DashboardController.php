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
        $totalUser = DB::table('users')->count();
        return view('dashboard', [
            'totalUser' => $totalUser
        ]);
    }
}
