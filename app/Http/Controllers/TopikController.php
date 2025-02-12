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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        Alert::toast('Program pembelajaran berhasil dibuat.', 'success');
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
        Alert::toast('Program pembelajaran berhasil diperbarui.', 'success');
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
            Alert::toast('Program pembelajaran berhasil dihapus.', 'success');
            return redirect()->route('topik.index');
        } catch (\Throwable $th) {
            Alert::toast('Program pembelajaran tidak dapat dihapus karena masih terhubung dengan tabel lain.', 'error');
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
        Alert::toast('Program pembelajaran berhasil diimpor.', 'success');
        return back();
    }

    public function formatImport()
    {
        $date = date('d-m-Y');
        $nameFile = 'format_import_program_pembelajaran' . $date;
        return Excel::download(new GenerateTopikMultiSheet(), $nameFile . '.xlsx');
    }

    public function usulanProgramPembelajaran(Request $request)
    {
        $validatedData = $request->validate([
            'rumpun_pembelajaran_id' => 'required|exists:rumpun_pembelajaran,id',
            'nama_topik' => 'required|string|max:255',
            'catatan_user_created' => 'nullable|string',
        ]);

        $userId = Auth::id(); // Ambil ID user yang sedang login
        $tanggalPengajuan = now(); // Ambil waktu saat ini
        DB::table('nomenklatur_pembelajaran')->insert([
            'rumpun_pembelajaran_id' => $validatedData['rumpun_pembelajaran_id'],
            'nama_topik' => $validatedData['nama_topik'],
            'status' => 'Pending',
            'user_created' => $userId,
            'tanggal_pengajuan' => $tanggalPengajuan,
            'catatan_user_created' => $validatedData['catatan_user_created'],
            'created_at' => $tanggalPengajuan,
            'updated_at' => $tanggalPengajuan,
        ]);

        return response()->json(['message' => 'Usulan berhasil disimpan.']);
    }
}
