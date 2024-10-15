<?php

namespace App\Http\Controllers;

use App\Models\NomenklaturPembelajaran;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NomenklaturPembelajaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:nomenklatur pembelajaran view')->only('index', 'show');
        $this->middleware('permission:nomenklatur pembelajaran edit')->only('update');
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
                    'users.nama_unit',
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

    public function edit(NomenklaturPembelajaran $nomenklaturPembelajaran)
    {
        // Retrieve the specific Nomenklatur Pembelajaran with joins
        $nomenklaturPembelajaran = DB::table('nomenklatur_pembelajaran')
            ->leftJoin('rumpun_pembelajaran', 'nomenklatur_pembelajaran.rumpun_pembelajaran_id', '=', 'rumpun_pembelajaran.id')
            ->leftJoin('users as user_created', 'nomenklatur_pembelajaran.user_created', '=', 'user_created.id')
            ->leftJoin('users as user_review', 'nomenklatur_pembelajaran.user_review', '=', 'user_review.id')
            ->select(
                'nomenklatur_pembelajaran.*',
                'rumpun_pembelajaran.rumpun_pembelajaran',
                'user_created.name as user_created_name',
                'user_review.name as user_review_name'
            )
            ->where('nomenklatur_pembelajaran.id', $nomenklaturPembelajaran->id)
            ->first();

        // Retrieve all available Rumpun Pembelajaran
        $rumpunPembelajaranList = DB::table('rumpun_pembelajaran')->get();

        // Pass the data to the view
        return view('nomenklatur-pembelajaran.edit', compact('nomenklaturPembelajaran', 'rumpunPembelajaranList'));
    }


    public function approve(Request $request, $id)
    {
        // Check if the record exists
        $nomenklatur = DB::table('nomenklatur_pembelajaran')->where('id', $id)->first();

        if ($nomenklatur && $nomenklatur->status == 'Pending') {
            // Update the nomenklatur_pembelajaran record
            DB::table('nomenklatur_pembelajaran')
                ->where('id', $id)
                ->update([
                    'status' => 'Approved',
                    'rumpun_pembelajaran_id' =>  $request->input('rumpun_pembelajaran_id'),
                    'nama_topik' =>  $request->input('nama_topik'),
                    'user_review' => Auth::id(),
                    'tanggal_review' => now(),
                    'catatan_user_review' => $request->input('catatan_user_review')
                ]);

            $dataNew = DB::table('nomenklatur_pembelajaran')->where('id', $id)->first();

            // Insert into the topik table
            DB::table('topik')->insert([
                'rumpun_pembelajaran_id' => $dataNew->rumpun_pembelajaran_id,
                'nama_topik' => $dataNew->nama_topik,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Alert::toast('Usulan Nomenklatur Pembelajaran telah disetujui.', 'success');
        } else {
            Alert::toast('Usulan Nomenklatur Pembelajaran tidak dapat disetujui.', 'error');
        }

        return redirect()->route('nomenklatur-pembelajaran.index');
    }


    public function reject(Request $request, $id)
    {
        // Check if the record exists
        $nomenklatur = DB::table('nomenklatur_pembelajaran')->where('id', $id)->first();

        if ($nomenklatur && $nomenklatur->status == 'Pending') {
            DB::table('nomenklatur_pembelajaran')
                ->where('id', $id)
                ->update([
                    'status' => 'Rejected',
                    'user_review' => Auth::id(),
                    'tanggal_review' => now(),
                    'catatan_user_review' => $request->input('catatan_user_review')
                ]);
        }
        Alert::toast('Usulan Nomenklatur Pembelajaran telah ditolak.', 'success');
        return redirect()->route('nomenklatur-pembelajaran.index');
    }
}
