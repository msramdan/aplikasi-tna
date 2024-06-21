<?php

namespace App\Http\Controllers;

use App\Models\Kompetensi;
use App\Http\Requests\{ImportKompetensiRequest, StoreKompetensiRequest, UpdateKompetensiRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Exports\ExportKompetensi;
use App\FormatImport\GenerateKompetensiFormat;
use App\Imports\ImportKompetensi;
use Maatwebsite\Excel\Facades\Excel;


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
            $kompetensi = DB::table('kompetensi')
                ->leftJoin('kelompok_besar', 'kompetensi.kelompok_besar_id', '=', 'kelompok_besar.id')
                ->leftJoin('akademi', 'kompetensi.akademi_id', '=', 'akademi.id')
                ->leftJoin('kategori_kompetensi', 'kompetensi.kategori_kompetensi_id', '=', 'kategori_kompetensi.id')
                ->select('kompetensi.*', 'kelompok_besar.nama_kelompok_besar', 'akademi.nama_akademi', 'kategori_kompetensi.nama_kategori_kompetensi')
                ->get();

            return DataTables::of($kompetensi)
                ->addIndexColumn()
                ->addColumn('deskripsi_kompetensi', function ($row) {
                    return str($row->deskripsi_kompetensi)->limit(100);
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
        $kelompokBesar = DB::table('kelompok_besar')->get();
        $namaAkademi = DB::table('akademi')->get();
        $kategoriKompetensi = DB::table('kategori_kompetensi')->get();
        return view('kompetensi.create', [
            'kelompokBesar' => $kelompokBesar,
            'namaAkademi' => $namaAkademi,
            'kategoriKompetensi' => $kategoriKompetensi
        ]);
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
                    'level' => $request->input('level')[$i - 1],
                    'deskripsi_level' => $request->input('deskripsi_level')[$i - 1],
                    'indikator_perilaku' => $request->input('indikator_perilaku')[$i - 1]
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
        $kompetensiDetail = DB::table('kompetensi_detail')
            ->where('kompetensi_id', $kompetensi->id)
            ->get();
        $kelompokBesar = DB::table('kelompok_besar')->get();
        $namaAkademi = DB::table('akademi')->get();
        $kategoriKompetensi = DB::table('kategori_kompetensi')->get();
        return view('kompetensi.edit', compact('kompetensi', 'kompetensiDetail', 'kelompokBesar', 'namaAkademi', 'kategoriKompetensi'));
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

        $kompetensi = $kompetensi->update($request->validated());

        // Update data pada tabel kompetensi_detail
        foreach ($request->kompetensi_detail_id as $index => $detailId) {
            DB::table('kompetensi_detail')
                ->where('id', $detailId)
                ->update([
                    'deskripsi_level' => $request->deskripsi_level[$index],
                    'indikator_perilaku' => $request->indikator_perilaku[$index],
                ]);
        }

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

    public function detailKompetensi(Request $request)
    {
        // Mengambil id dari request
        $id = $request->id;

        try {
            // Mengambil data kompetensi_detail berdasarkan kompetensi_id
            $kompetensiDetail = DB::table('kompetensi_detail')
                ->where('kompetensi_id', $id)
                ->get();

            if ($kompetensiDetail->isNotEmpty()) {
                // Jika data ditemukan, kembalikan respons dengan data tersebut
                return response()->json(['success' => true, 'data' => $kompetensiDetail]);
            } else {
                // Jika data tidak ditemukan, kembalikan respons dengan pesan kesalahan
                return response()->json(['success' => false, 'message' => 'Data detail kompetensi tidak ditemukan']);
            }
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan respons dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function exportKompetensi()
    {
        $date = date('d-m-Y');
        $nameFile = 'Kamus kompetensi ' . $date;
        return Excel::download(new ExportKompetensi(), $nameFile . '.xlsx');
    }

    public function importKompetensi(ImportKompetensiRequest $request)
    {
        Excel::import(new ImportKompetensi, $request->file('import_kompetensi'));
        Alert::toast('Kamus kompetensi has been successfully imported.', 'success');
        return back();
    }

    public function formatImport()
    {
        $date = date('d-m-Y');
        $nameFile = 'format_import_kompetensi' . $date;
        return Excel::download(new GenerateKompetensiFormat(), $nameFile . '.xlsx');
    }
}
