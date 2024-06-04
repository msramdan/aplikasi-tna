<?php

namespace App\Http\Controllers;

use App\Models\TaggingPembelajaranKompetensi;
use App\Http\Requests\{StoreTaggingPembelajaranKompetensiRequest, UpdateTaggingPembelajaranKompetensiRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class TaggingPembelajaranKompetensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tagging pembelajaran kompetensi view')->only('index', 'show');
        $this->middleware('permission:tagging pembelajaran kompetensi create')->only('create', 'store');
        $this->middleware('permission:tagging pembelajaran kompetensi edit')->only('edit', 'update');
        $this->middleware('permission:tagging pembelajaran kompetensi delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                        return '<button class="btn btn-success btn-md">' . $row->jumlah_tagging . ' Tagging</button>';
                    } else {
                        return '<button class="btn btn-danger btn-md"> 0 Tagging</button>';
                    }
                })
                ->addColumn('action', 'tagging-pembelajaran-kompetensi.include.action')
                ->rawColumns(['jumlah_tagging', 'action'])
                ->toJson();
        }

        return view('tagging-pembelajaran-kompetensi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tagging-pembelajaran-kompetensi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaggingPembelajaranKompetensiRequest $request)
    {

        TaggingPembelajaranKompetensi::create($request->validated());
        Alert::toast('The taggingPembelajaranKompetensi was created successfully.', 'success');
        return redirect()->route('tagging-pembelajaran-kompetensi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaggingPembelajaranKompetensi  $taggingPembelajaranKompetensi
     * @return \Illuminate\Http\Response
     */
    public function show(TaggingPembelajaranKompetensi $taggingPembelajaranKompetensi)
    {
        $taggingPembelajaranKompetensi->load('topik:id', 'kompetensi:id');

        return view('tagging-pembelajaran-kompetensi.show', compact('taggingPembelajaranKompetensi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaggingPembelajaranKompetensi  $taggingPembelajaranKompetensi
     * @return \Illuminate\Http\Response
     */
    public function edit(TaggingPembelajaranKompetensi $taggingPembelajaranKompetensi)
    {
        $taggingPembelajaranKompetensi->load('topik:id', 'kompetensi:id');

        return view('tagging-pembelajaran-kompetensi.edit', compact('taggingPembelajaranKompetensi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaggingPembelajaranKompetensi  $taggingPembelajaranKompetensi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaggingPembelajaranKompetensiRequest $request, TaggingPembelajaranKompetensi $taggingPembelajaranKompetensi)
    {

        $taggingPembelajaranKompetensi->update($request->validated());
        Alert::toast('The taggingPembelajaranKompetensi was updated successfully.', 'success');
        return redirect()
            ->route('tagging-pembelajaran-kompetensi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaggingPembelajaranKompetensi  $taggingPembelajaranKompetensi
     * @return \Illuminate\Http\Response
     */
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
