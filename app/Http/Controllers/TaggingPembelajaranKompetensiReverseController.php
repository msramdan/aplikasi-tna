<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportTaggingPembelakaranKompetensiReverse;
use App\FormatImport\GenerateTaggingPembelajaranKompetensiMultiSheetReverse;
use App\Imports\ImportTaggingMultiSheetReverse;
use App\Http\Requests\ImportTaggingPembelajaranKompetensiRequest;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class TaggingPembelajaranKompetensiReverseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tagging pembelajaran kompetensi view')->only('index', 'show');
        $this->middleware('permission:tagging pembelajaran kompetensi create')->only('create', 'store');
        $this->middleware('permission:tagging pembelajaran kompetensi edit')->only('edit', 'update');
        $this->middleware('permission:tagging pembelajaran kompetensi delete')->only('destroy');
    }

    public function index()
    {
        if (request()->ajax()) {
            $taggingPembelajaranKompetensis = DB::table('kompetensi')
                ->leftJoin('tagging_pembelajaran_kompetensi', 'kompetensi.id', '=', 'tagging_pembelajaran_kompetensi.kompetensi_id')
                ->select(
                    'kompetensi.id as id',
                    'kompetensi.nama_kompetensi',
                    DB::raw('COUNT(tagging_pembelajaran_kompetensi.id) as jumlah_tagging'),
                    DB::raw('MIN(tagging_pembelajaran_kompetensi.id) as tagging_pembelajaran_kompetensi_id')
                )
                ->groupBy('kompetensi.id')
                ->get();
            return DataTables::of($taggingPembelajaranKompetensis)
                ->addIndexColumn()
                ->addColumn('jumlah_tagging', function ($row) {
                    if ($row->jumlah_tagging > 0) {
                        return '<span class="badge badge-label bg-info badge-width"><i class="mdi mdi-circle-medium"></i>' . $row->jumlah_tagging . ' Tagging</span>';
                    } else {
                        return '<span class="badge badge-label bg-danger badge-width"><i class="mdi mdi-circle-medium"></i>0 Tagging</span>';
                    }
                })
                ->addColumn('action', 'tagging-pembelajaran-kompetensi-reverse.include.action')
                ->rawColumns(['jumlah_tagging', 'action'])
                ->toJson();
        }

        return view('tagging-pembelajaran-kompetensi-reverse.index');
    }

    public function settingTagging($id)
    {
        $kompetensi = DB::table('kompetensi')->where('id', $id)->first();
        if (!$kompetensi) {
            return redirect()->back()->with('error', 'Kompetensi tidak ditemukan.');
        }

        // Mendapatkan daftar topik yang sudah ditugaskan ke kompetensi
        $assignedItems = DB::table('tagging_pembelajaran_kompetensi')
            ->join('topik', 'tagging_pembelajaran_kompetensi.topik_id', '=', 'topik.id')
            ->where('tagging_pembelajaran_kompetensi.kompetensi_id', $kompetensi->id)
            ->pluck('topik.nama_topik', 'topik.id');

        // Mendapatkan daftar topik yang belum ditugaskan ke kompetensi
        $availableItems = DB::table('topik')
            ->whereNotIn('id', $assignedItems->keys())
            ->pluck('nama_topik', 'id');

        return view('tagging-pembelajaran-kompetensi-reverse.edit', compact('kompetensi', 'assignedItems', 'availableItems'));
    }

    public function updateTagging(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'assigned' => 'required|array'
            ]);

            // Get the assigned topik IDs from the request
            $newAssignedTopikIds = $request->input('assigned');

            // Get current assigned topik IDs from the database
            $currentAssignedTopikIds = DB::table('tagging_pembelajaran_kompetensi')
                ->where('kompetensi_id', $id)
                ->pluck('topik_id')
                ->toArray();

            // Make sure $currentAssignedTopikIds is an array
            $currentAssignedTopikIds = is_array($currentAssignedTopikIds) ? $currentAssignedTopikIds : [];

            // Determine which topik IDs to add
            $toAdd = array_diff($newAssignedTopikIds, $currentAssignedTopikIds);

            // Determine which topik IDs to remove
            $toRemove = array_diff($currentAssignedTopikIds, $newAssignedTopikIds);

            // Start transaction
            DB::beginTransaction();

            // Add new topik IDs
            foreach ($toAdd as $topikId) {
                DB::table('tagging_pembelajaran_kompetensi')->insert([
                    'kompetensi_id' => $id,
                    'topik_id' => $topikId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Remove deselected topik IDs
            DB::table('tagging_pembelajaran_kompetensi')
                ->where('kompetensi_id', $id)
                ->whereIn('topik_id', $toRemove)
                ->delete();

            // Commit transaction
            DB::commit();
            Alert::toast('The tagging was updated successfully.', 'success');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('The tagging update failed.', 'error');
            return back()->withErrors(['message' => $e->getMessage()]);
        }

        return redirect()->route('tagging-kompetensi-pembelajaran.index');
    }

    public function destroy($id)
    {
        // Check if the record exists based on kompetensi_id instead of topik_id
        $cek = DB::table('tagging_pembelajaran_kompetensi')
            ->where('kompetensi_id', $id)
            ->first();

        if (!$cek) {
            Alert::toast('Record not found.', 'error');
            return back();
        }

        // Delete the record(s) based on kompetensi_id
        DB::table('tagging_pembelajaran_kompetensi')->where('kompetensi_id', $id)->delete();
        Alert::toast('Tagging deleted successfully.', 'success');
        return back();
    }

    public function detailTaggingKompetensiPembelajaran(Request $request)
    {
        $id = $request->id;
        try {
            $dataTagging = DB::table('tagging_pembelajaran_kompetensi')
                ->join('topik', 'tagging_pembelajaran_kompetensi.topik_id', '=', 'topik.id')
                ->where('tagging_pembelajaran_kompetensi.kompetensi_id', $id)
                ->select('tagging_pembelajaran_kompetensi.*', 'topik.nama_topik')
                ->get();

            if ($dataTagging->isNotEmpty()) {
                return response()->json(['success' => true, 'data' => $dataTagging]);
            } else {
                return response()->json(['success' => false, 'message' => 'Tagging pembelajaran - topik tidak ditemukan']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function exportTagKompetensiPembelajaran()
    {
        $date = date('d-m-Y');
        $nameFile = 'tagging_kompetensi_pembelajaran ' . $date;
        return Excel::download(new ExportTaggingPembelakaranKompetensiReverse(), $nameFile . '.xlsx');
    }

    public function formatImport()
    {
        $date = date('d-m-Y');
        $nameFile = 'format_import_tagging_kompetensi_pembelajaran' . $date;
        return Excel::download(new GenerateTaggingPembelajaranKompetensiMultiSheetReverse(), $nameFile . '.xlsx');
    }

    public function importTaggingKompetensiPembelajaran(ImportTaggingPembelajaranKompetensiRequest $request)
    {
        Excel::import(new ImportTaggingMultiSheetReverse, $request->file('import_tagging_pembelajaran_kompetensi'));
        Alert::toast('Tagging kompetensi - kompetensi has been successfully imported.', 'success');
        return back();
    }
}
