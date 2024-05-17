<?php

namespace App\Http\Controllers;

use App\Models\Topik;
use App\Http\Requests\{StoreTopikRequest, UpdateTopikRequest,ImportTopikRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportTopikPembelajaran;
use App\Imports\ImportTopik;


class TopikController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:topik view')->only('index', 'show');
        $this->middleware('permission:topik create')->only('create', 'store');
        $this->middleware('permission:topik edit')->only('edit', 'update');
        $this->middleware('permission:topik delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $topik = Topik::query();

            return DataTables::of($topik)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('action', 'topik.include.action')
                ->toJson();
        }

        return view('topik.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('topik.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTopikRequest $request)
    {

        Topik::create($request->validated());
        Alert::toast('The topik was created successfully.', 'success');
        return redirect()->route('topik.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Topik  $topik
     * @return \Illuminate\Http\Response
     */
    public function show(Topik $topik)
    {
        return view('topik.show', compact('topik'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topik  $topik
     * @return \Illuminate\Http\Response
     */
    public function edit(Topik $topik)
    {
        return view('topik.edit', compact('topik'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topik  $topik
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTopikRequest $request, Topik $topik)
    {

        $topik->update($request->validated());
        Alert::toast('The topik was updated successfully.', 'success');
        return redirect()
            ->route('topik.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topik  $topik
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topik $topik)
    {
        try {
            $topik->delete();
            Alert::toast('The topik was deleted successfully.', 'success');
            return redirect()->route('topik.index');
        } catch (\Throwable $th) {
            Alert::toast('The topik cant be deleted because its related to another table.', 'error');
            return redirect()->route('topik.index');
        }
    }

    public function exportTopik()
    {
        $date = date('d-m-Y');
        $nameFile = 'Topik pembelajaran ' . $date;
        return Excel::download(new ExportTopikPembelajaran(), $nameFile . '.xlsx');
    }

    public function importTopik(ImportTopikRequest $request)
    {
        Excel::import(new ImportTopik, $request->file('import_topik'));
        Alert::toast('Topik pembelajaran has been successfully imported.', 'success');
        return back();
    }
}
