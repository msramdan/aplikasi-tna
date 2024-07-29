<?php

namespace App\Http\Controllers;

use App\Exports\ExportTaggingKompetensiIk;
use App\FormatImport\GenerateTaggingKompetensiIkMultiSheet;
use App\Http\Requests\ImportTaggingKompetensiIkRequest;
use App\Imports\ImportTaggingIkMultiSheet;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;


class TaggingKompetensiIkController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tagging kompetensi ik view')->only('index', 'show');
        $this->middleware('permission:tagging kompetensi ik create')->only('create', 'store');
        $this->middleware('permission:tagging kompetensi ik edit')->only('edit', 'update');
        $this->middleware('permission:tagging kompetensi ik delete')->only('destroy');
    }

    public function index($type)
    {
        if (request()->ajax()) {
            $taggingKompetensiIk = DB::table('kompetensi')
                ->leftJoin('tagging_kompetensi_ik', function ($join) use ($type) {
                    $join->on('kompetensi.id', '=', 'tagging_kompetensi_ik.kompetensi_id')
                        ->where('tagging_kompetensi_ik.type', '=', $type);
                })
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

        return view('tagging-kompetensi-ik.index');
    }

    public function settingTagging($id, $type)
    {
        $kompetensi = DB::table('kompetensi')->where('id', $id)->first();
        if (!$kompetensi) {
            return redirect()->back()->with('error', 'Kompetensi tidak ditemukan.');
        }

        $assignedItems = DB::table('tagging_kompetensi_ik')
            ->join('kompetensi', 'tagging_kompetensi_ik.kompetensi_id', '=', 'kompetensi.id')
            ->where('tagging_kompetensi_ik.kompetensi_id', $kompetensi->id)
            ->where('tagging_kompetensi_ik.type', $type)
            ->pluck('tagging_kompetensi_ik.indikator_kinerja')
            ->toArray();

        $token = session('api_token');
        if (!$token) {
            dd('User is not authenticated.');
            return redirect()->back()->with('error', 'User is not authenticated.');
        }
        if ($type === 'renstra') {
            $endpoint = config('stara.endpoint') . '/simaren/ref-indikator-kinerja-es2';
        } elseif ($type === 'app') {
            $endpoint = config('stara.endpoint') . '/simaren/ref-topik-app';
        } elseif ($type === 'apep') {
            $endpoint = config('stara.endpoint') . '/simaren/ref-topik-apep';
        } elseif ($type === 'apip') {
            $endpoint = config('stara.endpoint') . '/simaren/ref-topik-apep';
        } else {
            dd('error');
        }

        $response = Http::withToken($token)->get($endpoint);
        $availableItems = [];
        if ($response->successful()) {
            $apiData = $response->json();
            $apiItems = $apiData['data'] ?? [];
            $availableItems = array_filter($apiItems, function ($item) use ($assignedItems) {
                foreach ($assignedItems as $assignedItem) {
                    if (strpos($item['indikator_kinerja'], $assignedItem) !== false) {
                        return false;
                    }
                }
                return true;
            });
        } else {
            return redirect()->back()->with('error', 'Failed to retrieve data from the API.');
        }

        return view('tagging-kompetensi-ik.edit', compact('kompetensi', 'assignedItems', 'availableItems', 'type'));
    }

    public function updateTagging(Request $request, $id, $type)
    {
        try {
            // Validate the request
            $request->validate([
                'assigned' => 'required|array'
            ]);

            // Get the assigned kompetensi IDs from the request
            $newAssignedKompetensiIds = $request->input('assigned');

            // Get current assigned kompetensi IDs from the database
            $currentAssignedKompetensiIds = DB::table('tagging_kompetensi_ik')
                ->where('kompetensi_id', $id)
                ->where('type', $type)
                ->pluck('indikator_kinerja')
                ->toArray();

            // Make sure $currentAssignedKompetensiIds is an array
            $currentAssignedKompetensiIds = is_array($currentAssignedKompetensiIds) ? $currentAssignedKompetensiIds : [];

            // Determine which kompetensi IDs to add
            $toAdd = array_diff($newAssignedKompetensiIds, $currentAssignedKompetensiIds);
            // Determine which kompetensi IDs to remove
            $toRemove = array_diff($currentAssignedKompetensiIds, $newAssignedKompetensiIds);

            // Start transaction
            DB::beginTransaction();

            // Add new kompetensi IDs
            foreach ($toAdd as $kompetensiId) {
                DB::table('tagging_kompetensi_ik')->insert([
                    'kompetensi_id' => $id,
                    'type' => $type,
                    'indikator_kinerja' => $kompetensiId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Remove deselected kompetensi IDs
            DB::table('tagging_kompetensi_ik')
                ->where('kompetensi_id', $id)
                ->where('type', $type)
                ->whereIn('indikator_kinerja', $toRemove)
                ->delete();

            // Commit transaction
            DB::commit();
            Alert::toast('The tagging was updated successfully.', 'success');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('The tagging was updated failed.', 'error');
            return back()->withErrors(['message' => $e->getMessage()]);
        }
        return redirect('tagging-kompetensi-ik/' . $type);
    }

    public function destroy($id, $type)
    {
        $kompetensi = DB::table('tagging_kompetensi_ik')
            ->where('kompetensi_id', $id)
            ->where('type', $type)
            ->first();

        if (!$kompetensi) {
            Alert::toast('Record not found.', 'error');
            return back();
        }
        DB::table('tagging_kompetensi_ik')
            ->where('kompetensi_id', $id)
            ->where('type', $type)
            ->delete();
        Alert::toast('Tagging deleted successfully', 'success');
        return back();
    }

    public function detailTaggingKompetensiIk(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        try {
            $dataTagging = DB::table('tagging_kompetensi_ik')
                ->join('kompetensi', 'tagging_kompetensi_ik.kompetensi_id', '=', 'kompetensi.id')
                ->where('tagging_kompetensi_ik.kompetensi_id', $id)
                ->where('tagging_kompetensi_ik.type', $type)
                ->select('tagging_kompetensi_ik.*', 'kompetensi.nama_kompetensi')
                ->get();
            if ($dataTagging->isNotEmpty()) {
                return response()->json(['success' => true, 'data' => $dataTagging]);
            } else {
                return response()->json(['success' => false, 'message' => 'Tagging pembelajaran - kompetensi tidak ditemukan']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function exportTagKompetensiIk($type)
    {
        $date = date('d-m-Y');
        $nameFile = 'tagging_kompetensi_indikator_kerja_' . $type . '_' . $date;
        return Excel::download(new ExportTaggingKompetensiIk($type), $nameFile . '.xlsx');
    }

    public function formatImport($type)
    {
        $date = date('d-m-Y');
        $nameFile = 'format_import_tagging_kompetensi_ik_' . $type . '' . $date;
        return Excel::download(new GenerateTaggingKompetensiIkMultiSheet($type), $nameFile . '.xlsx');
    }

    public function importTaggingKompetensiIk(ImportTaggingKompetensiIkRequest $request, $type)
    {
        Excel::import(new ImportTaggingIkMultiSheet($type), $request->file('import_tagging_kompetensi_ik'));
        Alert::toast('Tagging kompetensi - IK has been successfully imported.', 'success');
        return back();
    }
}
