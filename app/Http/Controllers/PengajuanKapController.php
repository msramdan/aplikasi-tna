<?php

namespace App\Http\Controllers;

use App\Models\PengajuanKap;
use App\Http\Requests\{StorePengajuanKapRequest, UpdatePengajuanKapRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class PengajuanKapController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pengajuan kap view')->only('index', 'show');
        $this->middleware('permission:pengajuan kap create')->only('create', 'store');
        $this->middleware('permission:pengajuan kap edit')->only('edit', 'update');
        $this->middleware('permission:pengajuan kap delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $pengajuanKaps = PengajuanKap::with('kompetensi:id', 'topik:id', );

            return DataTables::of($pengajuanKaps)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('kompetensi', function ($row) {
                    return $row->kompetensi ? $row->kompetensi->id : '';
                })->addColumn('topik', function ($row) {
                    return $row->topik ? $row->topik->id : '';
                })->addColumn('action', 'pengajuan-kap.include.action')
                ->toJson();
        }

        return view('pengajuan-kap.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengajuan-kap.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePengajuanKapRequest $request)
    {

        PengajuanKap::create($request->validated());
        Alert::toast('The pengajuanKap was created successfully.', 'success');
        return redirect()->route('pengajuan-kap.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PengajuanKap  $pengajuanKap
     * @return \Illuminate\Http\Response
     */
    public function show(PengajuanKap $pengajuanKap)
    {
        $pengajuanKap->load('kompetensi:id', 'topik:id', );

		return view('pengajuan-kap.show', compact('pengajuanKap'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PengajuanKap  $pengajuanKap
     * @return \Illuminate\Http\Response
     */
    public function edit(PengajuanKap $pengajuanKap)
    {
        $pengajuanKap->load('kompetensi:id', 'topik:id', );

		return view('pengajuan-kap.edit', compact('pengajuanKap'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PengajuanKap  $pengajuanKap
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePengajuanKapRequest $request, PengajuanKap $pengajuanKap)
    {

        $pengajuanKap->update($request->validated());
        Alert::toast('The pengajuanKap was updated successfully.', 'success');
        return redirect()
            ->route('pengajuan-kap.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PengajuanKap  $pengajuanKap
     * @return \Illuminate\Http\Response
     */
    public function destroy(PengajuanKap $pengajuanKap)
    {
        try {
            $pengajuanKap->delete();
            Alert::toast('The pengajuanKap was deleted successfully.', 'success');
            return redirect()->route('pengajuan-kap.index');
        } catch (\Throwable $th) {
            Alert::toast('The pengajuanKap cant be deleted because its related to another table.', 'error');
            return redirect()->route('pengajuan-kap.index');
        }
    }
}
