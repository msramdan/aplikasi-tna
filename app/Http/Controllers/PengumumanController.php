<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Http\Requests\{StorePengumumanRequest, UpdatePengumumanRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class PengumumanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pengumuman view')->only('index');
        $this->middleware('permission:pengumuman edit')->only('update');
    }

    public function index()
    {
        $pengumuman = Pengumuman::findOrFail(1)->first();
        return view('pengumuman.edit', compact('pengumuman'));
    }
    public function update(UpdatePengumumanRequest $request, Pengumuman $pengumuman)
    {

        $pengumuman->update($request->validated());
        Alert::toast('Pengumuman berhasil diperbarui.', 'success');
        return redirect()
            ->route('pengumuman.index');
    }
}
