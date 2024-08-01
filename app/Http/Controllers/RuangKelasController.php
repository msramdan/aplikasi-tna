<?php

namespace App\Http\Controllers;

use App\Models\RuangKelas;
use App\Http\Requests\{StoreRuangKelasRequest, UpdateRuangKelasRequest};
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RuangKelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ruang kelas view')->only('index', 'show');
        $this->middleware('permission:ruang kelas create')->only('create', 'store');
        $this->middleware('permission:ruang kelas edit')->only('edit', 'update');
        $this->middleware('permission:ruang kelas delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $ruangKelas = DB::table('ruang_kelas')
                ->leftJoin('lokasi', 'ruang_kelas.lokasi_id', '=', 'lokasi.id')
                ->select('ruang_kelas.*', 'lokasi.nama_lokasi')
                ->get();
            return DataTables::of($ruangKelas)
                ->addIndexColumn()
                ->addColumn('keterangan', function ($row) {
                    return str($row->keterangan)->limit(100);
                })
                ->addColumn('kuota', function ($row) {
                    return $row->kuota .' Peserta';
                })
                ->addColumn('status_ruang_kelas', function ($row) {
                    if ($row->status_ruang_kelas == 'Available') {
                        return '<button class="btn btn-success btn-sm btn-block">Available</button>';
                    } else {
                        return '<button class="btn btn-danger btn-sm btn-block">Not Available</button>';
                    }
                })
                ->addColumn('nama_lokasi', function ($row) {
                    return $row->nama_lokasi;
                })->addColumn('action', 'ruang-kelas.include.action')
                ->rawColumns(['status_ruang_kelas', 'action'])
                ->toJson();
        }

        return view('ruang-kelas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ruang-kelas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRuangKelasRequest $request)
    {

        RuangKelas::create($request->validated());
        Alert::toast('The ruang kelas was created successfully.', 'success');
        return redirect()->route('ruang-kelas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RuangKela  $ruangKela
     * @return \Illuminate\Http\Response
     */
    public function show(RuangKelas $ruangKelas)
    {
        $ruangKelas->load('lokasi:id');

        return view('ruang-kelas.show', compact('ruangKelas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RuangKela  $ruangKela
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ruangKelas = RuangKelas::findOrFail($id);
        return view('ruang-kelas.edit', compact('ruangKelas'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RuangKela  $ruangKela
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRuangKelasRequest $request, $id)
    {
        $ruangKelas = RuangKelas::findOrFail($id);
        $ruangKelas->update($request->validated());
        Alert::toast('The ruang kelas was updated successfully.', 'success');
        return redirect()->route('ruang-kelas.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RuangKela  $ruangKela
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $ruangKelas = RuangKelas::findOrFail($id);
            $ruangKelas->delete();
            Alert::toast('The ruang kelas was deleted successfully.', 'success');
        } catch (\Throwable $th) {
            Alert::toast('The ruang kelas cannot be deleted because it is related to another table.', 'error');
        }

        return redirect()->route('ruang-kelas.index');
    }
}
