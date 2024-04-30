<?php

namespace App\Http\Controllers;

use App\Models\RuangKelas;
use App\Http\Requests\{StoreRuangKelasRequest, UpdateRuangKelasRequest};
use Yajra\DataTables\Facades\DataTables;
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
            $ruangKelas = RuangKelas::with('campus:id,nama_kampus');

            return DataTables::of($ruangKelas)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })
                ->addColumn('kuota', function ($row) {
                    return $row->kuota . ' Peserta';
                })
                ->addColumn('keterangan', function ($row) {
                    return str($row->keterangan)->limit(100);
                })
                ->addColumn('campus', function ($row) {
                    return $row->campus ? $row->campus->nama_kampus : '';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 'Available') {
                        return '<span class="badge bg-success">Available</span>';
                    } else {
                        return '<span class="badge bg-danger">Not available</span>';
                    }
                })
                ->rawColumns(['status', 'action'])
                ->addColumn('action', 'ruang-kelas.include.action')
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
    public function show(RuangKelas $ruangKela)
    {
        $ruangKela->load('campus:id,nama_kampus');

        return view('ruang-kelas.show', compact('ruangKela'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RuangKela  $ruangKela
     * @return \Illuminate\Http\Response
     */
    public function edit(RuangKelas $ruangKela)
    {
        $ruangKela->load('campus:id,nama_kampus');

        return view('ruang-kelas.edit', compact('ruangKela'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RuangKela  $ruangKela
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRuangKelasRequest $request, RuangKelas $ruangKela)
    {

        $ruangKela->update($request->validated());
        Alert::toast('The  ruang kelas was updated successfully.', 'success');
        return redirect()
            ->route('ruang-kelas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RuangKela  $ruangKela
     * @return \Illuminate\Http\Response
     */
    public function destroy(RuangKelas $ruangKela)
    {
        try {
            $ruangKela->delete();
            Alert::toast('The  ruang kelas was deleted successfully.', 'success');
            return redirect()->route('ruang-kelas.index');
        } catch (\Throwable $th) {
            Alert::toast('The  ruang kelas cant be deleted because its related to another table.', 'error');
            return redirect()->route('ruang-kelas.index');
        }
    }
}
