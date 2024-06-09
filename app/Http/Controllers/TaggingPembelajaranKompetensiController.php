<?php

namespace App\Http\Controllers;

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
                        return '<button class="btn btn-success btn-sm">' . $row->jumlah_tagging . ' Tagging</button>';
                    } else {
                        return '<button class="btn btn-danger btn-sm"> 0 Tagging</button>';
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
                    'kompetensi_id' => $kompetensiId
                ]);
            }

            // Remove deselected kompetensi IDs
            DB::table('tagging_pembelajaran_kompetensi')
                ->where('topik_id', $id)
                ->whereIn('kompetensi_id', $toRemove)
                ->delete();

            // Commit transaction
            DB::commit();

            // If the process is successful, return success message
            Alert::toast('The tagging was updated successfully.', 'success');
        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction and return error message
            DB::rollback();
            Alert::toast('The tagging was updated failed.', 'error');
            return back()->withErrors(['message' => $e->getMessage()]);
        }

        return redirect()->route('tagging-pembelajaran-kompetensi.index');
    }

    public function destroy(TaggingPembelajaranKompetensi $taggingPembelajaranKompetensi)
    {
        try {
            $taggingPembelajaranKompetensi->delete();
            Alert::toast('The taggingPembelajaranKompetensi was deleted successfully.', 'success');
            return redirect()->route('tagging-pembelajaran-kompetensi.index');
        } catch (\Throwable $th) {
            Alert::toast('The taggingPembelajaranKompetensi cant be deleted because its related to another table.', 'error');
            return redirect()->route('tagging-pembelajaran-kompetensi.index');
        }
    }
}
