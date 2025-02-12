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
                ->addColumn('nama_kelompok_besar', function ($row) {
                    return $row->nama_kelompok_besar ? $row->nama_kelompok_besar : '-';
                })
                ->addColumn('nama_kategori_kompetensi', function ($row) {
                    return $row->nama_kategori_kompetensi ? $row->nama_kategori_kompetensi : '-';
                })
                ->addColumn('nama_akademi', function ($row) {
                    return $row->nama_akademi ? $row->nama_akademi : '-';
                })
                ->addColumn('deskripsi_kompetensi', function ($row) {
                    return $row->deskripsi_kompetensi ? str($row->deskripsi_kompetensi)->limit(100) : '-';
                })

                ->addColumn('action', 'kompetensi.include.action')
                ->toJson();
        }

        return view('kompetensi.index');
    }

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

    public function store(StoreKompetensiRequest $request)
    {
        DB::beginTransaction();

        try {
            $kompetensi = Kompetensi::create($request->validated());
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
            DB::commit();
            Alert::toast('Kompetensi berhasil dibuat.', 'success');
            return redirect()->route('kompetensi.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Gagal membuat kompetensi. Silakan coba lagi nanti.');
            return redirect()->back()->withInput();
        }
    }

    public function show(Kompetensi $kompetensi)
    {
        return view('kompetensi.show', compact('kompetensi'));
    }

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

    public function update(UpdateKompetensiRequest $request, Kompetensi $kompetensi)
    {

        $kompetensi = $kompetensi->update($request->validated());

        foreach ($request->kompetensi_detail_id as $index => $detailId) {
            DB::table('kompetensi_detail')
                ->where('id', $detailId)
                ->update([
                    'deskripsi_level' => $request->deskripsi_level[$index],
                    'indikator_perilaku' => $request->indikator_perilaku[$index],
                ]);
        }

        Alert::toast('Kompetensi berhasil diperbarui.', 'success');
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
            Alert::toast('Kompetensi berhasil dihapus.', 'success');
            return redirect()->route('kompetensi.index');
        } catch (\Throwable $th) {
            Alert::toast('Kompetensi tidak dapat dihapus karena masih terhubung dengan tabel lain.', 'error');
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

    public function getKompetensiById($id)
    {
        $kompetensi = Kompetensi::find($id);
        if ($kompetensi) {
            return response()->json($kompetensi);
        } else {
            return response()->json(['error' => 'Kompetensi not found'], 404);
        }
    }
}
