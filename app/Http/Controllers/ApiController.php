<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function getIndikator($jenisProgram = null)
    {
        try {
            if (!$jenisProgram) {
                return response()->json(['message' => 'Parameter jenisProgram tidak valid'], 400);
            }

            $token = session('api_token');
            if (!$token) {
                return response()->json(['message' => 'User is not authenticated.'], 400);
            }

            $tahun = date('Y');
            switch ($jenisProgram) {
                case 'Renstra':
                    $endpoint = config('stara.endpoint') . '/simaren/indikator-kinerja/es2';
                    $parameter = 'unit_kerja';
                    $value = Auth::user()->kode_unit;
                    break;
                case 'APP':
                    $endpoint = config('stara.endpoint') . '/simaren/topik-app';
                    $parameter = 'id_unit_kontributor';
                    $value = Auth::user()->kode_unit;
                    break;
                case 'APEP':
                    $endpoint = config('stara.endpoint') . '/simaren/topik-apep';
                    $parameter = 'id_unit_kontributor';
                    $value = Auth::user()->kode_unit;
                    break;
                default:
                    return response()->json(['message' => 'Coming soon'], 501);
            }

            $endpoint .= '?tahun=' . urlencode($tahun) . '&' . urlencode($parameter) . '=' . urlencode($value);

            $response = Http::withToken($token)->get($endpoint);

            // Check if the request was successful
            if ($response->successful()) {
                // Return the API response data
                return response()->json($response->json());
            } else {
                // Return an error response
                return response()->json(['message' => 'Failed to fetch data from API'], $response->status());
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getKompetensiSupportIK(Request $request)
    {
        $keySortUnit = Auth::user()->key_sort_unit;
        try {
            $indikator = $request->input('indikator');
            $data = DB::table('tagging_kompetensi_ik')
                ->join('kompetensi', 'tagging_kompetensi_ik.kompetensi_id', '=', 'kompetensi.id')
                ->where('tagging_kompetensi_ik.indikator_kinerja', $indikator)
                ->select('kompetensi.id as kompetensi_id', 'kompetensi.nama_kompetensi')
                ->get();

            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getTopikSupportKompetensi(Request $request)
    {
        $kompetensiId = $request->input('kompetensi_id');

        if (!$kompetensiId) {
            return response()->json(['message' => 'Parameter kompetensi_id tidak valid'], 400);
        }

        try {
            $data = DB::table('tagging_pembelajaran_kompetensi')
                ->join('topik', 'tagging_pembelajaran_kompetensi.topik_id', '=', 'topik.id')
                ->where('tagging_pembelajaran_kompetensi.kompetensi_id', $kompetensiId)
                ->select('topik.id as topik_id', 'topik.nama_topik')
                ->get();

            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
