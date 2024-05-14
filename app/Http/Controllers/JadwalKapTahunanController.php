<?php

namespace App\Http\Controllers;

use App\Models\JadwalKapTahunan;
use App\Http\Requests\{StoreJadwalKapTahunanRequest, UpdateJadwalKapTahunanRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalKapTahunanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:jadwal kap tahunan view')->only('index', 'show');
        $this->middleware('permission:jadwal kap tahunan create')->only('create', 'store');
        $this->middleware('permission:jadwal kap tahunan edit')->only('edit', 'update');
        $this->middleware('permission:jadwal kap tahunan delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $jadwalKapTahunans = JadwalKapTahunan::query();

            return DataTables::of($jadwalKapTahunans)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('action', 'jadwal-kap-tahunans.include.action')
                ->toJson();
        }

        return view('jadwal-kap-tahunans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jadwal-kap-tahunans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJadwalKapTahunanRequest $request)
    {
        
        JadwalKapTahunan::create($request->validated());
        Alert::toast('The jadwalKapTahunan was created successfully.', 'success');
        return redirect()->route('jadwal-kap-tahunans.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JadwalKapTahunan  $jadwalKapTahunan
     * @return \Illuminate\Http\Response
     */
    public function show(JadwalKapTahunan $jadwalKapTahunan)
    {
        return view('jadwal-kap-tahunans.show', compact('jadwalKapTahunan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JadwalKapTahunan  $jadwalKapTahunan
     * @return \Illuminate\Http\Response
     */
    public function edit(JadwalKapTahunan $jadwalKapTahunan)
    {
        return view('jadwal-kap-tahunans.edit', compact('jadwalKapTahunan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JadwalKapTahunan  $jadwalKapTahunan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJadwalKapTahunanRequest $request, JadwalKapTahunan $jadwalKapTahunan)
    {
        
        $jadwalKapTahunan->update($request->validated());
        Alert::toast('The jadwalKapTahunan was updated successfully.', 'success');
        return redirect()
            ->route('jadwal-kap-tahunans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JadwalKapTahunan  $jadwalKapTahunan
     * @return \Illuminate\Http\Response
     */
    public function destroy(JadwalKapTahunan $jadwalKapTahunan)
    {
        try {
            $jadwalKapTahunan->delete();
            Alert::toast('The jadwalKapTahunan was deleted successfully.', 'success');
            return redirect()->route('jadwal-kap-tahunans.index');
        } catch (\Throwable $th) {
            Alert::toast('The jadwalKapTahunan cant be deleted because its related to another table.', 'error');
            return redirect()->route('jadwal-kap-tahunans.index');
        }
    }
}
