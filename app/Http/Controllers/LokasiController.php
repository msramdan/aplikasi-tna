<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Http\Requests\{StoreLokasiRequest, UpdateLokasiRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class LokasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:lokasi view')->only('index', 'show');
        $this->middleware('permission:lokasi create')->only('create', 'store');
        $this->middleware('permission:lokasi edit')->only('edit', 'update');
        $this->middleware('permission:lokasi delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $lokasi = Lokasi::with('kota:id,nama_kota');

            return DataTables::of($lokasi)
                ->addIndexColumn()
                ->addColumn('kota', function ($row) {
                    return $row->kota ? $row->kota->nama_kota : '';
                })->addColumn('action', 'lokasi.include.action')
                ->toJson();
        }

        return view('lokasi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lokasi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLokasiRequest $request)
    {

        Lokasi::create($request->validated());
        Alert::toast('The lokasi was created successfully.', 'success');
        return redirect()->route('lokasi.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function show(Lokasi $lokasi)
    {
        $lokasi->load('kota:id,nama_kota');

		return view('lokasi.show', compact('lokasi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Lokasi $lokasi)
    {
        $lokasi->load('kota:id,nama_kota');

		return view('lokasi.edit', compact('lokasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLokasiRequest $request, Lokasi $lokasi)
    {

        $lokasi->update($request->validated());
        Alert::toast('The lokasi was updated successfully.', 'success');
        return redirect()
            ->route('lokasi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lokasi $lokasi)
    {
        try {
            $lokasi->delete();
            Alert::toast('The lokasi was deleted successfully.', 'success');
            return redirect()->route('lokasi.index');
        } catch (\Throwable $th) {
            Alert::toast('The lokasi cant be deleted because its related to another table.', 'error');
            return redirect()->route('lokasi.index');
        }
    }
}
