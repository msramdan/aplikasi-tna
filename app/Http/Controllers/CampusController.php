<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Http\Requests\{StoreCampusRequest, UpdateCampusRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class CampusController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:campus view')->only('index', 'show');
        $this->middleware('permission:campus create')->only('create', 'store');
        $this->middleware('permission:campus edit')->only('edit', 'update');
        $this->middleware('permission:campus delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $campuses = Campus::query();

            return DataTables::of($campuses)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('action', 'campuses.include.action')
                ->toJson();
        }

        return view('campuses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampusRequest $request)
    {

        Campus::create($request->validated());
        Alert::toast('The kampus was created successfully.', 'success');
        return redirect()->route('campuses.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function show(Campus $campus)
    {
        return view('campuses.show', compact('campus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function edit(Campus $campus)
    {
        return view('campuses.edit', compact('campus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCampusRequest $request, Campus $campus)
    {

        $campus->update($request->validated());
        Alert::toast('The kampus was updated successfully.', 'success');
        return redirect()
            ->route('campuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campus $campus)
    {
        try {
            $campus->delete();
            Alert::toast('The kampus was deleted successfully.', 'success');
            return redirect()->route('campuses.index');
        } catch (\Throwable $th) {
            Alert::toast('The kampus cant be deleted because its related to another table.', 'error');
            return redirect()->route('campuses.index');
        }
    }
}
