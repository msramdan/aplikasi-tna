<?php

namespace App\Http\Controllers;

use App\Models\NomenklaturPembelajaran;
use App\Http\Requests\{UpdateNomenklaturPembelajaranRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class NomenklaturPembelajaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:nomenklatur pembelajaran view')->only('index', 'show');
        $this->middleware('permission:nomenklatur pembelajaran edit')->only('edit', 'update');
        $this->middleware('permission:nomenklatur pembelajaran delete')->only('destroy');
    }

    public function index()
    {
        if (request()->ajax()) {
            $nomenklaturPembelajarans = DB::table('nomenklatur_pembelajaran')
                ->leftJoin('rumpun_pembelajaran', 'nomenklatur_pembelajaran.rumpun_pembelajaran_id', '=', 'rumpun_pembelajaran.id')
                ->leftJoin('users as user_created', 'nomenklatur_pembelajaran.user_created', '=', 'user_created.id')
                ->leftJoin('users as user_review', 'nomenklatur_pembelajaran.user_review', '=', 'user_review.id')
                ->select(
                    'nomenklatur_pembelajaran.*',
                    'rumpun_pembelajaran.rumpun_pembelajaran',
                    'user_created.name as user_created_name',
                    'user_review.name as user_review_name'
                );

            return DataTables::of($nomenklaturPembelajarans)
                ->addIndexColumn()
                ->addColumn('rumpun_pembelajaran', function ($row) {
                    return $row->rumpun_pembelajaran ?: '';
                })
                ->addColumn('user_created', function ($row) {
                    return $row->user_created_name ?: '';
                })
                ->addColumn('user_review', function ($row) {
                    return $row->user_review_name ?: '';
                })

                ->addColumn('status', function ($row) {
                    if ($row->status == 'Pending') {
                        return '<button style="width:90px" class="btn btn-gray btn-sm btn-block"><i class="fa fa-clock" aria-hidden="true"></i> Pending</button>';
                    } else if ($row->status == 'Approved') {
                        return '<button style="width:90px" class="btn btn-success btn-sm btn-block"><i class="fa fa-check" aria-hidden="true"></i> Approved</button>';
                    } else if ($row->status == 'Rejected') {
                        return '<button style="width:90px" class="btn btn-danger btn-sm btn-block"><i class="fa fa-times" aria-hidden="true"></i> Rejected</button>';
                    }
                })
                ->addColumn('action', 'nomenklatur-pembelajaran.include.action')
                ->rawColumns(['status', 'action'])
                ->toJson();
        }

        return view('nomenklatur-pembelajaran.index');
    }


    public function show(NomenklaturPembelajaran $nomenklaturPembelajaran)
    {
        $nomenklaturPembelajaran->load('rumpun_pembelajaran:id', 'user:id,user_nip', 'user:id,user_nip',);

        return view('nomenklatur-pembelajaran.show', compact('nomenklaturPembelajaran'));
    }

    public function edit(NomenklaturPembelajaran $nomenklaturPembelajaran)
    {
        $nomenklaturPembelajaran->load('rumpun_pembelajaran:id', 'user:id,user_nip', 'user:id,user_nip',);

        return view('nomenklatur-pembelajaran.edit', compact('nomenklaturPembelajaran'));
    }

    public function update(UpdateNomenklaturPembelajaranRequest $request, NomenklaturPembelajaran $nomenklaturPembelajaran)
    {

        $nomenklaturPembelajaran->update($request->validated());
        Alert::toast('The nomenklaturPembelajaran was updated successfully.', 'success');
        return redirect()
            ->route('nomenklatur-pembelajaran.index');
    }

    public function destroy(NomenklaturPembelajaran $nomenklaturPembelajaran)
    {
        try {
            $nomenklaturPembelajaran->delete();
            Alert::toast('The nomenklaturPembelajaran was deleted successfully.', 'success');
            return redirect()->route('nomenklatur-pembelajaran.index');
        } catch (\Throwable $th) {
            Alert::toast('The nomenklaturPembelajaran cant be deleted because its related to another table.', 'error');
            return redirect()->route('nomenklatur-pembelajaran.index');
        }
    }
}
