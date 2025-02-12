<?php

namespace App\Http\Controllers;

use App\Models\RumpunPembelajaran;
use App\Http\Requests\{StoreRumpunPembelajaranRequest, UpdateRumpunPembelajaranRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;


class RumpunPembelajaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:rumpun pembelajaran view')->only('index', 'show');
        $this->middleware('permission:rumpun pembelajaran create')->only('create', 'store');
        $this->middleware('permission:rumpun pembelajaran edit')->only('edit', 'update');
        $this->middleware('permission:rumpun pembelajaran delete')->only('destroy');
    }

    public function index()
    {
        if (request()->ajax()) {
            $rumpunPembelajarans = RumpunPembelajaran::query();

            return DataTables::of($rumpunPembelajarans)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('rumpun_pembelajaran', function ($row) {
                    return str($row->rumpun_pembelajaran)->limit(100);
                })
                ->addColumn('action', 'rumpun-pembelajaran.include.action')
                ->toJson();
        }

        return view('rumpun-pembelajaran.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rumpun-pembelajaran.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRumpunPembelajaranRequest $request)
    {
        RumpunPembelajaran::create($request->validated());
        Alert::toast('Rumpun pembelajaran berhasil dibuat.', 'success');
        return redirect()->route('rumpun-pembelajaran.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RumpunPembelajaran  $rumpunPembelajaran
     * @return \Illuminate\Http\Response
     */
    public function show(RumpunPembelajaran $rumpunPembelajaran)
    {
        return view('rumpun-pembelajaran.show', compact('rumpunPembelajaran'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RumpunPembelajaran  $rumpunPembelajaran
     * @return \Illuminate\Http\Response
     */
    public function edit(RumpunPembelajaran $rumpunPembelajaran)
    {
        return view('rumpun-pembelajaran.edit', compact('rumpunPembelajaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RumpunPembelajaran  $rumpunPembelajaran
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRumpunPembelajaranRequest $request, RumpunPembelajaran $rumpunPembelajaran)
    {
        $rumpunPembelajaran->update($request->validated());
        Alert::toast('Rumpun pembelajaran berhasil diperbarui.', 'success');
        return redirect()
            ->route('rumpun-pembelajaran.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RumpunPembelajaran  $rumpunPembelajaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(RumpunPembelajaran $rumpunPembelajaran)
    {
        try {
            $rumpunPembelajaran->delete();
            Alert::toast('Rumpun pembelajaran berhasil dihapus.', 'success');
            return redirect()->route('rumpun-pembelajaran.index');
        } catch (\Throwable $th) {
            Alert::toast('Rumpun pembelajaran tidak dapat dihapus karena masih terhubung dengan tabel lain.', 'error');
            return redirect()->route('rumpun-pembelajaran.index');
        }
    }

    public function getRumpunPembelajaran()
    {
        $rumpunPembelajaran = DB::table('rumpun_pembelajaran')
            ->select('id', 'rumpun_pembelajaran')
            ->orderBy('rumpun_pembelajaran', 'asc')
            ->get();

        return response()->json($rumpunPembelajaran);
    }
}
