<?php

namespace App\Http\Controllers;

use App\Models\TaggingPembelajaranKompetensi;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaggingKompetensiIkController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tagging kompetensi ik view')->only('index', 'show');
        $this->middleware('permission:tagging kompetensi ik create')->only('create', 'store');
        $this->middleware('permission:tagging kompetensi ik edit')->only('edit', 'update');
        $this->middleware('permission:tagging kompetensi ik delete')->only('destroy');
    }

    public function renstra()
    {
        if (request()->ajax()) {
            $taggingKompetensiIk = DB::table('kompetensi')
                ->leftJoin('tagging_kompetensi_ik', 'kompetensi.id', '=', 'tagging_kompetensi_ik.kompetensi_id')
                ->select(
                    'kompetensi.id as id',
                    'kompetensi.nama_kompetensi as nama_kompetensi',
                    DB::raw('COUNT(tagging_kompetensi_ik.id) as jumlah_tagging'),
                    DB::raw('MIN(tagging_kompetensi_ik.id) as tagging_kompetensi_ik_id')
                )
                ->groupBy('kompetensi.id')
                ->get();
            return DataTables::of($taggingKompetensiIk)
                ->addIndexColumn()
                ->addColumn('jumlah_tagging', function ($row) {
                    if ($row->jumlah_tagging > 0) {
                        return '<span class="badge badge-label bg-info"><i class="mdi mdi-circle-medium"></i>' . $row->jumlah_tagging . ' Tagging</span>';
                    } else {
                        return '<span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i>0 Tagging</span>';
                    }
                })
                ->addColumn('action', 'tagging-kompetensi-ik.include.action')
                ->rawColumns(['jumlah_tagging', 'action'])
                ->toJson();
        }

        return view('tagging-kompetensi-ik.index_renstra');
    }

    public function app()
    {
        if (request()->ajax()) {
            $taggingKompetensiIk = DB::table('kompetensi')
                ->leftJoin('tagging_kompetensi_ik', 'kompetensi.id', '=', 'tagging_kompetensi_ik.kompetensi_id')
                ->select(
                    'kompetensi.id as id',
                    'kompetensi.nama_kompetensi as nama_kompetensi',
                    DB::raw('COUNT(tagging_kompetensi_ik.id) as jumlah_tagging'),
                    DB::raw('MIN(tagging_kompetensi_ik.id) as tagging_kompetensi_ik_id')
                )
                ->groupBy('kompetensi.id')
                ->get();
            return DataTables::of($taggingKompetensiIk)
                ->addIndexColumn()
                ->addColumn('jumlah_tagging', function ($row) {
                    if ($row->jumlah_tagging > 0) {
                        return '<span class="badge badge-label bg-info"><i class="mdi mdi-circle-medium"></i>' . $row->jumlah_tagging . ' Tagging</span>';
                    } else {
                        return '<span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i>0 Tagging</span>';
                    }
                })
                ->addColumn('action', 'tagging-kompetensi-ik.include.action')
                ->rawColumns(['jumlah_tagging', 'action'])
                ->toJson();
        }

        return view('tagging-kompetensi-ik.index_app');
    }

    public function apep()
    {
        if (request()->ajax()) {
            $taggingKompetensiIk = DB::table('kompetensi')
                ->leftJoin('tagging_kompetensi_ik', 'kompetensi.id', '=', 'tagging_kompetensi_ik.kompetensi_id')
                ->select(
                    'kompetensi.id as id',
                    'kompetensi.nama_kompetensi as nama_kompetensi',
                    DB::raw('COUNT(tagging_kompetensi_ik.id) as jumlah_tagging'),
                    DB::raw('MIN(tagging_kompetensi_ik.id) as tagging_kompetensi_ik_id')
                )
                ->groupBy('kompetensi.id')
                ->get();
            return DataTables::of($taggingKompetensiIk)
                ->addIndexColumn()
                ->addColumn('jumlah_tagging', function ($row) {
                    if ($row->jumlah_tagging > 0) {
                        return '<span class="badge badge-label bg-info"><i class="mdi mdi-circle-medium"></i>' . $row->jumlah_tagging . ' Tagging</span>';
                    } else {
                        return '<span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i>0 Tagging</span>';
                    }
                })
                ->addColumn('action', 'tagging-kompetensi-ik.include.action')
                ->rawColumns(['jumlah_tagging', 'action'])
                ->toJson();
        }

        return view('tagging-kompetensi-ik.index_apep');
    }

    public function apip()
    {
        if (request()->ajax()) {
            $taggingKompetensiIk = DB::table('kompetensi')
                ->leftJoin('tagging_kompetensi_ik', 'kompetensi.id', '=', 'tagging_kompetensi_ik.kompetensi_id')
                ->select(
                    'kompetensi.id as id',
                    'kompetensi.nama_kompetensi as nama_kompetensi',
                    DB::raw('COUNT(tagging_kompetensi_ik.id) as jumlah_tagging'),
                    DB::raw('MIN(tagging_kompetensi_ik.id) as tagging_kompetensi_ik_id')
                )
                ->groupBy('kompetensi.id')
                ->get();
            return DataTables::of($taggingKompetensiIk)
                ->addIndexColumn()
                ->addColumn('jumlah_tagging', function ($row) {
                    if ($row->jumlah_tagging > 0) {
                        return '<span class="badge badge-label bg-info"><i class="mdi mdi-circle-medium"></i>' . $row->jumlah_tagging . ' Tagging</span>';
                    } else {
                        return '<span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i>0 Tagging</span>';
                    }
                })
                ->addColumn('action', 'tagging-kompetensi-ik.include.action')
                ->rawColumns(['jumlah_tagging', 'action'])
                ->toJson();
        }

        return view('tagging-kompetensi-ik.index_apip');
    }

    public function settingTagging($id)
    {
        $tahun = '2024';
        $kompetensi = DB::table('kompetensi')->where('id', $id)->first();
        if (!$kompetensi) {
            return redirect()->back()->with('error', 'Kompetensi tidak ditemukan.');
        }
        $assignedItems = DB::table('tagging_kompetensi_ik')
            ->join('kompetensi', 'tagging_kompetensi_ik.kompetensi_id', '=', 'kompetensi.id')
            ->where('tagging_kompetensi_ik.kompetensi_id', $kompetensi->id)
            ->where('tagging_kompetensi_ik.tahun',  $tahun)
            ->pluck('tagging_kompetensi_ik.indikator_kinerja', 'kompetensi.id');

        $token = session('api_token');
        if (!$token) {
            return redirect()->back()->with('error', 'User is not authenticated.');
        }
        $type = request()->query('type', '');
        if ($type === 'renstra') {
            $endpoint = config('stara.endpoint') . '/simaren/indikator-kinerja/es2';
        } else {
            dd('API blm ready');
        }

        $response = Http::withToken($token)->get($endpoint, [
            'tahun' => $tahun
        ]);
        $availableItems = [];

        if ($response->successful()) {
            $apiData = $response->json();
            $availableItems = $apiData['data'] ?? [];
        } else {
            return redirect()->back()->with('error', 'Failed to retrieve data from the API.');
        }
        return view('tagging-kompetensi-ik.edit', compact('kompetensi', 'assignedItems', 'availableItems'));
    }
}
