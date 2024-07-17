<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

            $tahun = 2023;
            $unit_kerja = '07001500001900';

            if ($jenisProgram === 'Renstra') {
                $endpoint = config('stara.endpoint') . '/simaren/indikator-kinerja/es2';
            } elseif ($jenisProgram === 'APP') {
                $endpoint = config('stara.endpoint') . '/simaren/topik-app';
            } elseif ($jenisProgram === 'APEP') {
                $endpoint = config('stara.endpoint') . '/simaren/topik-apep';
            } else {
                return response()->json(['message' => 'Coming soon'], 501);
            }

            // Append query parameters
            $endpoint .= '?tahun=' . urlencode($tahun) . '&unit_kerja=' . urlencode($unit_kerja);

            // Make the API call
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
}
