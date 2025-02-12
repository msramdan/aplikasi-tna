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

            $tahun = '2024';
            switch ($jenisProgram) {
                case 'Renstra':
                    $endpoint = config('stara.endpoint') . '/simaren/indikator-kinerja/es2';
                    $parameter = 'unit_kerja';
                    $value = Auth::user()->kode_unit;
                    break;
                case 'APP':
                    $endpoint = config('stara.endpoint') . '/simaren/topik-app-pjtopik';
                    $parameter = 'id_unit_pj';
                    $value = Auth::user()->kode_unit;
                    break;
                case 'APEP':
                    $endpoint = config('stara.endpoint') . '/simaren/topik-apep-pjtopik';
                    $parameter = 'id_unit_pj';
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
                return response()->json(['message' => 'Gagal mengambil data dari API'], $response->status());
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
            // Receive indikator values as an array
            $indikator = $request->input('indikator');

            // Check if indikator is present and is an array
            if (!is_array($indikator) || empty($indikator)) {
                return response()->json(['message' => 'Indikator tidak valid atau hilang'], 400);
            }

            // Query to find competencies shared across selected IK
            $data = DB::table('tagging_kompetensi_ik')
                ->join('kompetensi', 'tagging_kompetensi_ik.kompetensi_id', '=', 'kompetensi.id')
                ->whereIn('tagging_kompetensi_ik.indikator_kinerja', $indikator)
                ->select('kompetensi.id as kompetensi_id', 'kompetensi.nama_kompetensi')
                ->groupBy('kompetensi.id', 'kompetensi.nama_kompetensi')
                ->havingRaw('COUNT(DISTINCT tagging_kompetensi_ik.indikator_kinerja) = ?', [count($indikator)])
                ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'kompetensi_summary' => [],
                ]);
            }

            $kompetensiIds = $data->pluck('kompetensi_id')->map(function ($id) {
                return (string) $id; // Cast to string
            })->toArray();

            // Construct the API endpoint
            $endpoint = config('stara.map_endpoint') . '/v1/bursa/get-gap-kompetensi-match?api_token=' . config('stara.map_api_token');

            // Send the POST request
            $response = Http::post($endpoint, [
                'id_kompetensi' => $kompetensiIds,
                'kode_unit' => $keySortUnit,
            ]);
            // Check API response
            if ($response->failed()) {
                \Log::error('API call failed', ['response' => $response->body()]);
                return response()->json(['message' => 'Gagal mencapai API eksternal'], 500);
            }

            $responseData = $response->json();
            $kompetensiMatches = collect();

            // Process kompetensi_match data
            foreach ($responseData['result'] as $result) {
                foreach ($result['kompetensi_match'] as $match) {
                    $kompetensiMatches->push([
                        'id_kompetensi' => $match['id_kompetensi'],
                        'nama_kompetensi' => $match['nama_kompetensi'],
                        'persentase_level_kompetensi' => $match['persentase_level_kompetensi'],
                        'nama' => $result['nama'],
                    ]);
                }
            }

            // Group by kompetensi_id and calculate required data
            $groupedData = $kompetensiMatches->groupBy('id_kompetensi')->map(function ($items) {
                return [
                    'kompetensi_id' => $items->first()['id_kompetensi'],
                    'nama_kompetensi' => $items->first()['nama_kompetensi'],
                    'average_persentase' => number_format($items->avg('persentase_level_kompetensi'), 2),
                    'total_employees' => $items->unique('nama')->count(),
                    'count_100' => $items->where('persentase_level_kompetensi', 100)->count(),
                    'count_less_than_100' => $items->where('persentase_level_kompetensi', '<', 100)->count(),
                ];
            })->values();
            return response()->json(['kompetensi_summary' => $groupedData]);
        } catch (\Exception $e) {
            \Log::error('Error in getKompetensiSupportIK', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'An error occurred while processing your request.'], 500);
        }
    }


    public function getTopikSupportKompetensi(Request $request)
    {
        $kompetensiIds = $request->input('kompetensi_id'); // Accepting array of kompetensi_ids
        if (empty($kompetensiIds) || !is_array($kompetensiIds)) {
            return response()->json(['message' => 'Parameter kompetensi_id tidak valid'], 400);
        }

        try {
            $data = DB::table('tagging_pembelajaran_kompetensi')
                ->join('topik', 'tagging_pembelajaran_kompetensi.topik_id', '=', 'topik.id')
                ->whereIn('tagging_pembelajaran_kompetensi.kompetensi_id', $kompetensiIds)
                ->select('topik.id as topik_id', 'topik.nama_topik')
                ->groupBy('topik.id', 'topik.nama_topik')
                ->havingRaw('COUNT(DISTINCT tagging_pembelajaran_kompetensi.kompetensi_id) = ?', [count($kompetensiIds)])
                ->get();

            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getKompetensiApip(Request $request)
    {
        try {
            $apiToken = env('API_TOKEN_SIBIJAK');
            $baseEndpoint = env('ENDPOINT_SIBIJAK');

            // Ambil nilai frekuensi dari request
            $frekuensi = $request->input('frekuensi');

            // Tentukan URL berdasarkan nilai frekuensi
            if ($frekuensi === 'Tahunan') {
                $url = "{$baseEndpoint}/integrasi/pemenuhan-kompetensi-summary";
                $response = Http::get($url, [
                    'api_token' => $apiToken,
                ]);

            } else {
                $ukerId = auth()->user()->kode_unit;
                $url = "{$baseEndpoint}/integrasi/pemenuhan-kompetensi";
                $response = Http::get($url, [
                    'api_token' => $apiToken,
                    'ukerId' => $ukerId,
                ]);

            }

            if (!$response->successful()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to fetch data from external API.',
                ], $response->status());
            }

            $apiData = $response->json();
            $kompetensiApi = $apiData['data'] ?? [];

            // Step 2: Query kompetensi table using API data
            $result = [];

            foreach ($kompetensiApi as $item) {
                $kompetensi = DB::table('kompetensi')
                    ->select('id as id_kompetensi')
                    ->where('nama_kompetensi', $item['nama_kompetensi'])
                    ->where('is_apip', 'Yes')
                    ->first();

                if ($kompetensi) {
                    $result[] = [
                        'id_kompetensi' => $kompetensi->id_kompetensi,
                        'nama_kompetensi' => $item['nama_kompetensi'],
                        'total_pegawai' => $item['total_pegawai'],
                        'memenuhi' => $item['memenuhi'],
                        'belum_memenuhi' => $item['belum_memenuhi'],
                        'persentase_capaian' => $item['persentase_capaian'],
                    ];
                }
            }

            return response()->json([
                'status' => true,
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
