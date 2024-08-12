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

            $kompetensiIds = $data->pluck('kompetensi_id')->toArray();

            // Construct the full endpoint URL with the API token
            $endpoint = config('stara.map_endpoint') . '/v1/bursa/get-gap-kompetensi-match?api_token=' . config('stara.map_api_token');

            // Send the POST request
            $response = Http::post($endpoint, [
                'id_kompetensi' => [
                    '1',
                    '2'
                ],
                'kode_unit' => $keySortUnit,
            ]);

            if ($response->failed()) {
                return response()->json(['message' => 'Failed to hit the external API'], 500);
            }

            $responseData = $response->json();

            // Extract and process kompetensi_match data
            $kompetensiMatches = collect();

            foreach ($responseData['result'] as $result) {
                foreach ($result['kompetensi_match'] as $match) {
                    $kompetensiMatches->push($match);
                }
            }

            // Group by nama_kompetensi and calculate the average persentase_level_kompetensi
            $groupedData = $kompetensiMatches->groupBy('nama_kompetensi')->map(function ($items) {
                return [
                     'kompetensi_id' => $items->first()['id_kompetensi'],
                    'nama_kompetensi' => $items->first()['nama_kompetensi'],
                    'average_persentase' => number_format($items->avg('persentase_level_kompetensi'), 2)
                ];
            })->values();
            return response()->json([
                'kompetensi_summary' => $groupedData,
            ]);
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
