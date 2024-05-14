<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Http\Requests\{StorekotaRequest, UpdatekotaRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class KotaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kota view')->only('index', 'show');
        $this->middleware('permission:kota create')->only('create', 'store');
        $this->middleware('permission:kota edit')->only('edit', 'update');
        $this->middleware('permission:kota delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $kota = kota::query();

            return DataTables::of($kota)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('action', 'kota.include.action')
                ->toJson();
        }

        return view('kota.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kota.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKotaRequest $request)
    {
        Kota::create($request->validated());
        Alert::toast('The kota was created successfully.', 'success');
        return redirect()->route('kota.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function show(Kota $kota)
    {
        return view('kota.show', compact('kota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kota = Kota::findOrFail($id);
        return view('kota.edit', compact('kota'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKotaRequest $request, $id)
    {
        $kota = Kota::findOrFail($id);
        $kota->update($request->validated());

        Alert::toast('The kota was updated successfully.', 'success');

        return redirect()->route('kota.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $kota = Kota::findOrFail($id);
            $kota->delete();

            Alert::toast('The kota was deleted successfully.', 'success');
        } catch (\Throwable $th) {
            Alert::toast('The kota cannot be deleted because it is related to another table.', 'error');
        }

        return redirect()->route('kota.index');
    }
}