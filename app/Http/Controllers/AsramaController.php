<?php

namespace App\Http\Controllers;

use App\Models\Asrama;
use App\Http\Requests\{StoreAsramaRequest, UpdateAsramaRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class AsramaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:asrama view')->only('index', 'show');
        $this->middleware('permission:asrama create')->only('create', 'store');
        $this->middleware('permission:asrama edit')->only('edit', 'update');
        $this->middleware('permission:asrama delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $asrama = DB::table('asrama')
                ->leftJoin('lokasi', 'asrama.lokasi_id', '=', 'lokasi.id')
                ->select('asrama.*', 'lokasi.nama_lokasi')
                ->get();

            return DataTables::of($asrama)
                ->addIndexColumn()
                ->addColumn('keterangan', function ($row) {
                    return str($row->keterangan)->limit(100);
                })
                ->addColumn('kuota', function ($row) {
                    return $row->kuota . ' Peserta';
                })
                ->addColumn('status_asrama', function ($row) {
                    if ($row->status_asrama == 'Available') {
                        return '<button class="btn btn-success btn-sm">Available</button>';
                    } else {
                        return '<button class="btn btn-danger btn-sm">Not Available</button>';
                    }
                })
                ->addColumn('lokasi', function ($row) {
                    return $row->nama_lokasi;
                })->addColumn('action', 'asrama.include.action')
                ->rawColumns(['status_asrama', 'action'])
                ->toJson();
        }
        return view('asrama.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('asrama.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAsramaRequest $request)
    {
        Asrama::create($request->validated());
        Alert::toast('The asrama was created successfully.', 'success');
        return redirect()->route('asrama.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asrama  $asrama
     * @return \Illuminate\Http\Response
     */
    public function show(Asrama $asrama)
    {
        $asrama->load('lokasi:id');

        return view('asrama.show', compact('asrama'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asrama  $asrama
     * @return \Illuminate\Http\Response
     */
    public function edit(Asrama $asrama)
    {
        $asrama->load('lokasi:id');

        return view('asrama.edit', compact('asrama'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asrama  $asrama
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAsramaRequest $request, Asrama $asrama)
    {

        $asrama->update($request->validated());
        Alert::toast('The asrama was updated successfully.', 'success');
        return redirect()
            ->route('asrama.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asrama  $asrama
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asrama $asrama)
    {
        try {
            $asrama->delete();
            Alert::toast('The asrama was deleted successfully.', 'success');
            return redirect()->route('asrama.index');
        } catch (\Throwable $th) {
            Alert::toast('The asrama cant be deleted because its related to another table.', 'error');
            return redirect()->route('asrama.index');
        }
    }
}
