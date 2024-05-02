<?php

namespace App\Http\Controllers;

use App\Models\Asrama;
use App\Http\Requests\{StoreAsramaRequest, UpdateAsramaRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class AsramaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:asrama view')->only('index', 'show');
        $this->middleware('permission:asrama create')->only('create', 'store');
        $this->middleware('permission:asrama edit')->only('edit', 'update');
        $this->middleware('permission:asrama delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $asrama = Asrama::with('campus:id,nama_kampus');

            return DataTables::of($asrama)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('campus', function ($row) {
                    return $row->campus ? $row->campus->nama_kampus : '';
                })
                ->addColumn('kuota', function ($row) {
                    return $row->kuota .' Peserta';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 'Available') {
                        return '<span class="badge bg-success">Available</span>';
                    } else {
                        return '<span class="badge bg-danger">Not available</span>';
                    }
                })
                ->rawColumns(['status','action'])
                ->addColumn('action', 'asrama.include.action')
                ->toJson();
        }

        return view('asrama.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('asrama.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAsramaRequest $request)
    {
        Asrama::create($request->validated());
        Alert::toast('The asrama was created successfully.', 'success');
        return redirect()->route('asrama.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asrama  $asrama
     * @return \Illuminate\Http\Response
     */
    public function show(Asrama $asrama)
    {
        $asrama->load('campus:id,nama_kampus');

        return view('asrama.show', compact('asrama'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asrama  $asrama
     * @return \Illuminate\Http\Response
     */
    public function edit(Asrama $asrama)
    {
        $asrama->load('campus:id,nama_kampus');

        return view('asrama.edit', compact('asrama'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asrama  $asrama
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAsramaRequest $request, Asrama $asrama)
    {

        $asrama->update($request->validated());
        Alert::toast('The asrama was updated successfully.', 'success');
        return redirect()
            ->route('asrama.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asrama  $asrama
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asrama $asrama)
    {
        try {
            $asrama->delete();
            Alert::toast('The asrama was deleted successfully.', 'success');
            return redirect()->route('asrama.index');
        } catch (\Throwable $th) {
            Alert::toast('The asrama cant be deleted because its related to another table.', 'error');
            return redirect()->route('asrama.index');
        }
    }
}
