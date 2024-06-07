<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:activity log view')->only('index');
    }

    public function index()
    {
        if (request()->ajax()) {
            $query = ActivityLog::with('user')
                ->where('log_name', 'log_user')
                ->orderBy('id', 'DESC')
                ->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('causer', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('new_value', function ($row) {
                    $array = json_decode($row->properties, true);
                    $items = [];

                    if (isset($array['new'])) {
                        if (isset($array['new']['roles'])) {
                            $items['roles'] = $array['new']['roles'][0]; // Menampilkan 1 data dari array roles
                        }
                        if (isset($array['new']['avatar'])) {
                            $items['avatar'] = $array['new']['avatar'];
                        }
                    }

                    return empty($items) ? '-' : json_encode($items, JSON_PRETTY_PRINT);
                })
                ->addColumn('old_value', function ($row) {
                    $array = json_decode($row->properties, true);
                    $items = [];

                    if (isset($array['old'])) {
                        if (isset($array['old']['roles'])) {
                            $items['roles'] = $array['old']['roles'][0]; // Menampilkan 1 data dari array roles
                        }
                        if (isset($array['old']['avatar'])) {
                            $items['avatar'] = $array['old']['avatar'];
                        }
                    }

                    return empty($items) ? '-' : json_encode($items, JSON_PRETTY_PRINT);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })
                ->addColumn('time', function ($row) {
                    return Carbon::parse($row->created_at)->diffForHumans();
                })
                ->make(true);
        }
        return view('activity_log.index');
    }
}
