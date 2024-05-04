<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class KalenderPembelajaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kalender pembelajaran view')->only('index', 'show');
        $this->middleware('permission:kalender pembelajaran create')->only('create', 'store');
        $this->middleware('permission:kalender pembelajaran edit')->only('edit', 'update');
        $this->middleware('permission:kalender pembelajaran delete')->only('destroy');
    }

    public function index()
    {

        return view('kalender-pembelajaran.index');
    }
}
