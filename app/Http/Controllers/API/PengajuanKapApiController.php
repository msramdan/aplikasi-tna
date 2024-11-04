<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengajuanKapApiController extends Controller
{
    public function detailPengajuanKap(Request $request)
    {
        // Ambil parameter kode_pembelajaran dari query
        $kodePembelajaran = $request->query('kode_pembelajaran');

        // Validasi jika kode_pembelajaran tidak diisi
        if (empty($kodePembelajaran)) {
            return response()->json([
                'status' => false,
                'message' => 'Parameter kode_pembelajaran is required.'
            ], 400);
        }

        try {
            // Fetch the main pengajuan_kap record with related users, kompetensi, and topik
            $pengajuanKap = $this->fetchPengajuanKap($kodePembelajaran);

            // Check if pengajuanKap is found
            if (!$pengajuanKap) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found.',
                    'data' => []
                ], 404);
            }

            // Prepare response data
            $data = [
                'pengajuanKap' => $pengajuanKap,
                'logReviews' => $this->fetchLogReviews($pengajuanKap->id),
                'levelEvaluasiInstrumenKap' => $this->fetchLevelEvaluasi($pengajuanKap->id),
                'indikatorKeberhasilanKap' => $this->fetchIndikatorKeberhasilan($pengajuanKap->id),
                'waktuPelaksanaan' => $this->fetchWaktuPelaksanaan($pengajuanKap->id),
                'gapKompetensiPengajuanKap' => $this->fetchGapKompetensi($pengajuanKap->id),
            ];

            // Return as JSON response
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            // Log the exception message for debugging purposes
            Log::error('Error fetching data: ' . $e->getMessage());

            // Return a generic error response
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching data.',
                'data' => []
            ], 500);
        }
    }

    // Helper method to fetch pengajuan_kap
    private function fetchPengajuanKap($kodePembelajaran)
    {
        return DB::table('pengajuan_kap')
            ->select(
                'pengajuan_kap.*',
                'users.name as user_name',
                'kompetensi.nama_kompetensi',
                'topik.nama_topik'
            )
            ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
            ->leftJoin('kompetensi', 'pengajuan_kap.kompetensi_id', '=', 'kompetensi.id')
            ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id')
            ->where('pengajuan_kap.kode_pembelajaran', '=', $kodePembelajaran)
            ->first();
    }

    // Helper method to fetch log reviews
    private function fetchLogReviews($pengajuanKapId)
    {
        return DB::table('log_review_pengajuan_kap')
            ->select(
                'log_review_pengajuan_kap.*',
                'users.name as user_name'
            )
            ->leftJoin('users', 'log_review_pengajuan_kap.user_review_id', '=', 'users.id')
            ->where('log_review_pengajuan_kap.pengajuan_kap_id', '=', $pengajuanKapId)
            ->orderBy('log_review_pengajuan_kap.step')
            ->get();
    }

    // Helper method to fetch level evaluasi instrumen kap
    private function fetchLevelEvaluasi($pengajuanKapId)
    {
        return DB::table('level_evaluasi_instrumen_kap')
            ->where('pengajuan_kap_id', $pengajuanKapId)
            ->get();
    }

    // Helper method to fetch indikator keberhasilan kap
    private function fetchIndikatorKeberhasilan($pengajuanKapId)
    {
        return DB::table('indikator_keberhasilan_kap')
            ->where('pengajuan_kap_id', $pengajuanKapId)
            ->get();
    }

    // Helper method to fetch waktu pelaksanaan
    private function fetchWaktuPelaksanaan($pengajuanKapId)
    {
        return DB::table('waktu_pelaksanaan')
            ->where('pengajuan_kap_id', $pengajuanKapId)
            ->select('waktu_pelaksanaan.*')
            ->get();
    }

    // Helper method to fetch gap kompetensi pengajuan kap
    private function fetchGapKompetensi($pengajuanKapId)
    {
        return DB::table('pengajuan_kap_gap_kompetensi')
            ->where('pengajuan_kap_id', $pengajuanKapId)
            ->first();
    }
}
