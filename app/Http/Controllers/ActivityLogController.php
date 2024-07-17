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


    public function index(Request $request)
    {
        if (request()->ajax()) {
            $activityLog = ActivityLog::with('user');
            $start_date = intval($request->query('start_date'));
            $end_date = intval($request->query('end_date'));
            $log_name = $request->query('log_name');

            if (isset($start_date) && !empty($start_date)) {
                $from = date("Y-m-d H:i:s", substr($request->query('start_date'), 0, 10));
                $activityLog = $activityLog->where('created_at', '>=', $from);
            } else {
                $from = date('Y-m-d') . " 00:00:00";
                $activityLog = $activityLog->where('created_at', '>=', $from);
            }
            if (isset($end_date) && !empty($end_date)) {
                $to = date("Y-m-d H:i:s", substr($request->query('end_date'), 0, 10));
                $activityLog = $activityLog->where('created_at', '<=', $to);
            } else {
                $to = date('Y-m-d') . " 23:59:59";
                $activityLog = $activityLog->where('created_at', '<=', $to);
            }

            if (isset($log_name) && !empty($log_name)) {
                if ($log_name != 'All') {
                    $activityLog = $activityLog->where('log_name', $log_name);
                }
            }

            $activityLog = $activityLog->orderBy('activity_log.id', 'DESC');
            return DataTables::of($activityLog)
                ->addIndexColumn()
                ->addColumn('causer', function ($row) {
                    if ($row->user) {
                        return $row->user->name;
                    } else {
                        return '-';
                    }
                })
                ->addColumn('new_value', function ($row) {
                    $array =  json_decode($row->properties);
                    $items = array();
                    foreach ($array as $key => $value) {
                        if ($key == 'attributes') {
                            foreach ($value as $r => $b) {
                                $items[$r] = $b;
                            }
                        }
                    }
                    $hasil =  json_encode(($items), JSON_PRETTY_PRINT);
                    return $hasil;
                })
                ->addColumn('old_value', function ($row) {
                    $array =  json_decode($row->properties);
                    $items = array();
                    foreach ($array as $key => $value) {
                        if ($key == 'old') {
                            foreach ($value as $r => $b) {
                                $items[$r] = $b;
                            }
                        }
                    }
                    $hasil =  json_encode(($items), JSON_PRETTY_PRINT);
                    return $hasil;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })
                ->addColumn('time', function ($row) {
                    return Carbon::parse($row->created_at)->diffForHumans();
                })
                ->make(true);
        }

        $currentDate = date('Y-m-d');

        // Get the first and last date of the current month
        $firstDayOfMonth = date('Y-m-01', strtotime($currentDate));
        $lastDayOfMonth = date('Y-m-t', strtotime($currentDate));

        // Convert these dates to timestamps in milliseconds
        $microFrom = strtotime($firstDayOfMonth . " 00:00:00") * 1000;
        $microTo = strtotime($lastDayOfMonth . " 23:59:59") * 1000;

        // Get the start and end dates from the request or use the defaults
        $start_date = $request->query('start_date') !== null ? intval($request->query('start_date')) : $microFrom;
        $end_date = $request->query('end_date') !== null ? intval($request->query('end_date')) : $microTo;
        $log_name = $request->query('log_name') ?? 'All';

        $arrLog = [
            'log_auth',
            'log_asrama',
            'log_jadwal_kap_tahunan',
            'log_kompetensi',
            'log_kota',
            'log_lokasi',
            'log_ruang_kelas',
            'log_setting_app',
            'log_topik_pembelajaran',
            'log_users',
        ];

        return view('activity_log.index', [
            'microFrom' => $start_date,
            'microTo' => $end_date,
            'arrLog' => $arrLog,
            'log_name' => $log_name,
        ]);
    }
}
