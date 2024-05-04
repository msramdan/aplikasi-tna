<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class ReportingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:reporting view')->only('index', 'show');
        $this->middleware('permission:reporting create')->only('create', 'store');
        $this->middleware('permission:reporting edit')->only('edit', 'update');
        $this->middleware('permission:reporting delete')->only('destroy');
    }

    public function index()
    {
        return view('reporting.index');
    }
}
