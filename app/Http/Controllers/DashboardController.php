<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Employee;
use App\Models\Hospital;
use App\Models\Equipment;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;



class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard');
    }

}
