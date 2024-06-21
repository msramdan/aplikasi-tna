<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportTaggingPembelakaranKompetensi;
use App\Models\TaggingPembelajaranKompetensi;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class TaggingPembelajaranKompetensiController extends Controller
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
            $taggingPembelajaranKompetensis = DB::table('topik')
                ->leftJoin('tagging_pembelajaran_kompetensi', 'topik.id', '=', 'tagging_pembelajaran_kompetensi.topik_id')
                ->select(
                    'topik.id as id',
                    'topik.nama_topik as nama_topik',
                    DB::raw('COUNT(tagging_pembelajaran_kompetensi.id) as jumlah_tagging'),
                    DB::raw('MIN(tagging_pembelajaran_kompetensi.id) as tagging_pembelajaran_kompetensi_id')
                )
                ->groupBy('topik.id')
                ->get();
            return DataTables::of($taggingPembelajaranKompetensis)
                ->addIndexColumn()
                ->addColumn('jumlah_tagging', function ($row) {
                    if ($row->jumlah_tagging > 0) {
                        return '<span class="badge badge-label bg-info"><i class="mdi mdi-circle-medium"></i>' . $row->jumlah_tagging . ' Tagging</span>';
                    } else {
                        return '<span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i>0 Tagging</span>';
                    }
                })
                ->addColumn('action', 'tagging-pembelajaran-kompetensi.include.action')
                ->rawColumns(['jumlah_tagging', 'action'])
                ->toJson();
        }

        return view('tagging-pembelajaran-kompetensi.index');
    }

    public function settingTagging($id)
    {
        $topik = DB::table('topik')->where('id', $id)->first();
        if (!$topik) {
            return redirect()->back()->with('error', 'Topik tidak ditemukan.');
        }
        $assignedItems = DB::table('tagging_pembelajaran_kompetensi')
            ->join('kompetensi', 'tagging_pembelajaran_kompetensi.kompetensi_id', '=', 'kompetensi.id')
            ->where('tagging_pembelajaran_kompetensi.topik_id', $topik->id)
            ->pluck('kompetensi.nama_kompetensi', 'kompetensi.id');

        $availableItems = DB::table('kompetensi')
            ->whereNotIn('id', $assignedItems->keys())
            ->pluck('nama_kompetensi', 'id');

        return view('tagging-pembelajaran-kompetensi.edit', compact('topik', 'assignedItems', 'availableItems'));
    }

    public function updateTagging(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'assigned' => 'required|array'
            ]);

            // Get the assigned kompetensi IDs from the request
            $newAssignedKompetensiIds = $request->input('assigned');

            // Get current assigned kompetensi IDs from the database
            $currentAssignedKompetensiIds = DB::table('tagging_pembelajaran_kompetensi')
                ->where('topik_id', $id)
                ->pluck('kompetensi_id')
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
                DB::table('tagging_pembelajaran_kompetensi')->insert([
                    'topik_id' => $id,
                    'kompetensi_id' => $kompetensiId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Remove deselected kompetensi IDs
            DB::table('tagging_pembelajaran_kompetensi')
                ->where('topik_id', $id)
                ->whereIn('kompetensi_id', $toRemove)
                ->delete();

            // Commit transaction
            DB::commit();
            Alert::toast('The tagging was updated successfully.', 'success');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('The tagging was updated failed.', 'error');
            return back()->withErrors(['message' => $e->getMessage()]);
        }

        return redirect()->route('tagging-pembelajaran-kompetensi.index');
    }

    public function destroy($id)
    {
        try {
            DB::table('tagging_pembelajaran_kompetensi')->where('topik_id', $id)->delete();
            Alert::toast('Tagging deleted successfully.', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to delete Tagging.', 'error');
        }

        // Redirect back to the previous page
        return back();
    }

    public function detailTaggingPembelajaranKompetensi(Request $request)
    {
        $id = $request->id;
        try {
            $dataTagging = DB::table('tagging_pembelajaran_kompetensi')
                ->join('kompetensi', 'tagging_pembelajaran_kompetensi.kompetensi_id', '=', 'kompetensi.id')
                ->where('tagging_pembelajaran_kompetensi.topik_id', $id)
                ->select('tagging_pembelajaran_kompetensi.*', 'kompetensi.nama_kompetensi')
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

    public function exportTagPembelajaranKompetensi()
    {
        $date = date('d-m-Y');
        $nameFile = 'tagging_pembelajaran_kompetensi ' . $date;
        return Excel::download(new ExportTaggingPembelakaranKompetensi(), $nameFile . '.xlsx');
    }
}
