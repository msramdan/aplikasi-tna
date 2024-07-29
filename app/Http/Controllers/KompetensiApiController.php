<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class KompetensiApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kompetensi view')->only('index', 'show');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $endpoint = config('stara.map_endpoint') . '/v1/bursa/ref-kamus-kompetensi';
                $response = Http::get($endpoint, [
                    'api_token' => config('stara.map_api_token')
                ]);
                $data = $response->json();
                $data = $data['result'] ?? [];
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('deskripsi_kompetensi', function ($row) {
                        return str($row['deskripsi_kompetensi'])->limit(100);
                    })
                    ->addColumn('action', 'kompetensi-api.include.action')
                    ->toJson();
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Unable to fetch data from the API',
                    'message' => $e->getMessage()
                ], 500);
            }
        }
        return view('kompetensi-api.index');
    }
}
