<?php

namespace App\Http\Controllers;

use App\Exports\ExportTaggingKompetensiIkReverse;
use App\FormatImport\GenerateTaggingKompetensiIkMultiSheetReverse;
use App\Http\Requests\ImportTaggingKompetensiIkRequest;
use App\Imports\ImportTaggingIkMultiSheet;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;


class TaggingKompetensiIkReverseController extends Controller
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

            $token = session('api_token');
            if (!$token) {
                return redirect()->back()->with('error', 'User is not authenticated.');
            }

            $endpoints = [
                'renstra' => '/simaren/ref-indikator-kinerja-es2',
                'app'     => '/simaren/ref-topik-app',
                'apep'    => '/simaren/ref-topik-apep',
            ];

            if (!array_key_exists($type, $endpoints)) {
                return redirect()->back()->with('error', 'Invalid type provided.');
            }


            $endpoint = config('stara.endpoint') . $endpoints[$type];

            $response = Http::withToken($token)->get($endpoint);
            if (!$response->successful()) {
                return redirect()->back()->with('error', 'Failed to retrieve data from the API.');
            }
            $apiData = $response->json();
            $apiItems = $apiData['data'] ?? [];
            return DataTables::of($apiItems)
                ->addIndexColumn()
                ->addColumn('indikator_kinerja', function ($row)  use ($type) {
                    if ($type == 'renstra') {
                        return $row['indikator_kinerja'] ? $row['indikator_kinerja'] : '-';
                    } else {
                        return $row['nama_topik'] ? $row['nama_topik'] : '-';
                    }
                })
                ->addColumn('type', function () use ($type) {
                    return $type;
                })
                ->addColumn('jumlah_tagging', function ($row) {
                    return 0;
                })
                ->addColumn('action', 'tagging-kompetensi-ik-reverse.include.action')
                ->rawColumns(['jumlah_tagging', 'action'])
                ->toJson();
        }
        return view('tagging-kompetensi-ik-reverse.index');
    }
    public function settingTagging($indikator_kinerja, $type)
    {
        $indikator_kinerja = str_replace('-', '/', $indikator_kinerja);
        $kompetensi = DB::table('kompetensi')->where('id', $indikator_kinerja)->first();
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
            return redirect()->back()->with('error', 'User is not authenticated.');
        }

        $endpoints = [
            'renstra' => '/simaren/ref-indikator-kinerja-es2',
            'app'     => '/simaren/ref-topik-app',
            'apep'    => '/simaren/ref-topik-apep',
        ];

        if (!array_key_exists($type, $endpoints)) {
            return redirect()->back()->with('error', 'Invalid type provided.');
        }

        $endpoint = config('stara.endpoint') . $endpoints[$type];

        $response = Http::withToken($token)->get($endpoint);
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Failed to retrieve data from the API.');
        }

        $apiData = $response->json();
        $apiItems = $apiData['data'] ?? [];

        $availableItems = array_filter($apiItems, function ($item) use ($assignedItems, $type) {
            foreach ($assignedItems as $assignedItem) {
                $searchField = $type === 'renstra' ? 'indikator_kinerja' : 'nama_topik';
                if (strpos($item[$searchField], $assignedItem) !== false) {
                    return false;
                }
            }
            return true;
        });

        return view('tagging-kompetensi-ik-reverse.edit', compact('kompetensi', 'assignedItems', 'availableItems', 'type'));
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
        return redirect('tagging-kompetensi-ik-reverse/' . $type);
    }

    public function destroy($indikator_kinerja, $type)
    {
        $indikator_kinerja = str_replace('-', '/', $indikator_kinerja);
        DB::table('tagging_kompetensi_ik')
            ->where('indikator_kinerja', $indikator_kinerja)
            ->where('type', $type)
            ->delete();

        Alert::toast('Tagging deleted successfully', 'success');
        return back();
    }

    public function detailTaggingIkKompetensi(Request $request)
    {
        $indikator_kinerja = $request->indikator_kinerja;
        $type = $request->type;
        try {
            $dataTagging = DB::table('tagging_kompetensi_ik')
                ->join('kompetensi', 'tagging_kompetensi_ik.kompetensi_id', '=', 'kompetensi.id')
                ->where('tagging_kompetensi_ik.indikator_kinerja', $indikator_kinerja)
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
        $nameFile = 'tagging_indikator_kerja_kompetensi_' . $type . '_' . $date;
        return Excel::download(new ExportTaggingKompetensiIkReverse($type), $nameFile . '.xlsx');
    }

    public function formatImport($type)
    {
        $date = date('d-m-Y');
        $nameFile = 'format_import_tagging_ik_kompetensi_' . $type . '' . $date;
        return Excel::download(new GenerateTaggingKompetensiIkMultiSheetReverse($type), $nameFile . '.xlsx');
    }

    public function importTaggingKompetensiIk(ImportTaggingKompetensiIkRequest $request, $type)
    {
        Excel::import(new ImportTaggingIkMultiSheet($type), $request->file('import_tagging_kompetensi_ik'));
        Alert::toast('Tagging kompetensi - IK has been successfully imported.', 'success');
        return back();
    }
}
