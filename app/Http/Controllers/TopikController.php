<?php

namespace App\Http\Controllers;

use App\Models\Topik;
use App\Http\Requests\{StoreTopikRequest, UpdateTopikRequest, ImportTopikRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportTopikPembelajaran;
use App\FormatImport\GenerateTopikMultiSheet;
use App\Imports\ImportTopik;
use App\Imports\ImportTopikMultiSheet;
use Illuminate\Support\Facades\DB;


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
            $topik = DB::table('topik')
                ->leftJoin('rumpun_pembelajaran', 'topik.rumpun_pembelajaran_id', '=', 'rumpun_pembelajaran.id')
                ->select('topik.*', 'rumpun_pembelajaran.rumpun_pembelajaran')
                ->get();
            return DataTables::of($topik)
                ->addIndexColumn()
                ->addColumn('id', function ($row) {
                    return sprintf('%03d', $row->id);
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
        $rumpunPembelajaran = DB::table('rumpun_pembelajaran')->get();
        return view('topik.create', [
            'rumpunPembelajaran' => $rumpunPembelajaran
        ]);
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
        Alert::toast('The program pembelajaran was created successfully.', 'success');
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
        $rumpunPembelajaran = DB::table('rumpun_pembelajaran')->get();
        return view('topik.edit', compact('topik', 'rumpunPembelajaran'));
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
        Alert::toast('The program pembelajaran was updated successfully.', 'success');
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
            Alert::toast('The program pembelajaran was deleted successfully.', 'success');
            return redirect()->route('topik.index');
        } catch (\Throwable $th) {
            Alert::toast('The program pembelajaran cant be deleted because its related to another table.', 'error');
            return redirect()->route('topik.index');
        }
    }

    public function exportTopik()
    {
        $date = date('d-m-Y');
        $nameFile = 'Program pembelajaran ' . $date;
        return Excel::download(new ExportTopikPembelajaran(), $nameFile . '.xlsx');
    }

    public function importTopik(ImportTopikRequest $request)
    {
        Excel::import(new ImportTopikMultiSheet, $request->file('import_topik'));
        Alert::toast('Program pembelajaran has been successfully imported.', 'success');
        return back();
    }

    public function formatImport()
    {
        $date = date('d-m-Y');
        $nameFile = 'format_import_program_pembelajaran' . $date;
        return Excel::download(new GenerateTopikMultiSheet(), $nameFile . '.xlsx');
    }
}
