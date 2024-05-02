<?php

namespace App\Http\Controllers;

use App\Models\Kompetensi;
use App\Http\Requests\{StoreKompetensiRequest, UpdateKompetensiRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class KompetensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kompetensi view')->only('index', 'show');
        $this->middleware('permission:kompetensi create')->only('create', 'store');
        $this->middleware('permission:kompetensi edit')->only('edit', 'update');
        $this->middleware('permission:kompetensi delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $kompetensi = Kompetensi::query();

            return DataTables::of($kompetensi)
                ->addIndexColumn()
                ->addColumn('deksripsi_kompetensi', function ($row) {
                    return str($row->deksripsi_kompetensi)->limit(100);
                })
                ->addColumn('action', 'kompetensi.include.action')
                ->toJson();
        }

        return view('kompetensi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kompetensi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKompetensiRequest $request)
    {
        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Buat record untuk Kompetensi
            $kompetensi = Kompetensi::create($request->validated());

            // Buat record untuk setiap detail kompetensi
            $details = [];
            for ($i = 1; $i <= 5; $i++) {
                $details[] = [
                    'kompetensi_id' => $kompetensi->id,
                    'level' => $request->input('level_' . $i),
                    'deskripsi_level' => $request->input('deskripsi_level_' . $i),
                    'indikator_perilaku' => $request->input('indikator_perilaku_' . $i)
                ];
            }
            DB::table('kompetensi_detail')->insert($details);

            // Commit transaksi jika semuanya berhasil
            DB::commit();

            // Tampilkan pesan sukses
            Alert::toast('The kompetensi was created successfully.', 'success');
            return redirect()->route('kompetensi.index');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            // Tampilkan pesan kesalahan
            Alert::error('Failed to create kompetensi. Please try again later.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kompetensi  $kompetensi
     * @return \Illuminate\Http\Response
     */
    public function show(Kompetensi $kompetensi)
    {
        return view('kompetensi.show', compact('kompetensi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kompetensi  $kompetensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Kompetensi $kompetensi)
    {
        return view('kompetensi.edit', compact('kompetensi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kompetensi  $kompetensi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKompetensiRequest $request, Kompetensi $kompetensi)
    {

        $kompetensi->update($request->validated());
        Alert::toast('The kompetensi was updated successfully.', 'success');
        return redirect()
            ->route('kompetensi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kompetensi  $kompetensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kompetensi $kompetensi)
    {
        try {
            $kompetensi->delete();
            Alert::toast('The kompetensi was deleted successfully.', 'success');
            return redirect()->route('kompetensi.index');
        } catch (\Throwable $th) {
            Alert::toast('The kompetensi cant be deleted because its related to another table.', 'error');
            return redirect()->route('kompetensi.index');
        }
    }
}
