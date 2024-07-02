<?php

namespace App\Http\Controllers;

use App\Models\PengajuanKap;
use App\Http\Requests\{StorePengajuanKapRequest, UpdatePengajuanKapRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanKapController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pengajuan kap view')->only('index', 'show');
        $this->middleware('permission:pengajuan kap create')->only('create', 'store');
        $this->middleware('permission:pengajuan kap edit')->only('edit', 'update');
        $this->middleware('permission:pengajuan kap delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($is_bpkp, $frekuensi)
    {
        if (request()->ajax()) {
            $pengajuanKaps = DB::table('pengajuan_kap')
                ->select(
                    'pengajuan_kap.id',
                    'pengajuan_kap.kode_pembelajaran',
                    'pengajuan_kap.institusi_sumber',
                    'pengajuan_kap.jenis_program',
                    'pengajuan_kap.frekuensi_pelaksanaan',
                    'pengajuan_kap.indikator_kinerja',
                    'pengajuan_kap.concern_program_pembelajaran',
                    'pengajuan_kap.alokasi_waktu',
                    'pengajuan_kap.indikator_dampak_terhadap_kinerja_organisasi',
                    'pengajuan_kap.penugasan_yang_terkait_dengan_pembelajaran',
                    'pengajuan_kap.skill_group_owner',
                    'pengajuan_kap.bentuk_pembelajaran',
                    'pengajuan_kap.jalur_pembelajaran',
                    'pengajuan_kap.model_pembelajaran',
                    'pengajuan_kap.jenis_pembelajaran',
                    'pengajuan_kap.metode_pembelajaran',
                    'pengajuan_kap.sasaran_peserta',
                    'pengajuan_kap.kriteria_peserta',
                    'pengajuan_kap.aktivitas_prapembelajaran',
                    'pengajuan_kap.penyelenggara_pembelajaran',
                    'pengajuan_kap.fasilitator_pembelajaran',
                    'pengajuan_kap.sertifikat',
                    'pengajuan_kap.tanggal_created',
                    'pengajuan_kap.status_pengajuan',
                    'pengajuan_kap.user_created',
                    'pengajuan_kap.created_at',
                    'pengajuan_kap.updated_at',
                    'users.name as user_name',
                    'kompetensi.nama_kompetensi',
                    'topik.nama_topik'
                )
                ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id') // Left join dengan tabel users
                ->leftJoin('kompetensi', 'pengajuan_kap.kompetensi_id', '=', 'kompetensi.id') // Left join dengan tabel kompetensi
                ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id') // Left join dengan tabel topik
                ->get();

            return DataTables::of($pengajuanKaps)
                ->addIndexColumn()
                ->addColumn('action', 'pengajuan-kap.include.action')
                ->toJson();
        }
        return view('pengajuan-kap.index', [
            'is_bpkp' => $is_bpkp,
            'frekuensi' => $frekuensi,
        ]);
    }

    public function create($is_bpkp, $frekuensi)
    {
        if ($is_bpkp === 'BPKP') {
            $jenis_program = ['Renstra', 'APP', 'APEP'];
        } elseif ($is_bpkp === 'Non BPKP') {
            $jenis_program = ['APIP'];
        } else {
            $jenis_program = [];
        }

        return view('pengajuan-kap.create', [
            'is_bpkp' => $is_bpkp,
            'frekuensi' => $frekuensi,
            'jenis_program' => $jenis_program,
        ]);
    }

    public function store(Request $request, $is_bpkp, $frekuensi)
    {
        $validatedData = $request->validate([
            'institusi_sumber' => 'required|in:BPKP,Non BPKP',
            'jenis_program' => 'required|in:Renstra,APP,APEP,APIP',
            'frekuensi_pelaksanaan' => 'required|in:Tahunan,Insidentil',
            'indikator_kinerja' => 'required|string|max:255',
            'kompetensi_id' => 'nullable|exists:kompetensi,id',
            'topik_id' => 'nullable|exists:topik,id',
            'concern_program_pembelajaran' => 'required|string|max:255',
            'alokasi_waktu' => 'required|string|max:10',
            'indikator_dampak_terhadap_kinerja_organisasi' => 'required|string|max:255',
            'penugasan_yang_terkait_dengan_pembelajaran' => 'required|string|max:255',
            'skill_group_owner' => 'required|string|max:255',
            'bentuk_pembelajaran' => 'required|in:Klasikal,Nonklasikal',
            'jalur_pembelajaran' => 'required|in:Pelatihan,Seminar/konferensi/sarasehan,Kursus,Lokakarya (workshop),Belajar mandiri,Coaching,Mentoring,Bimbingan teknis,Sosialisasi,Detasering (secondment),Job shadowing,Outbond,Benchmarking,Pertukaran PNS,Community of practices,Pelatihan di kantor sendiri,Library café,Magang/praktik kerja',
            'model_pembelajaran' => 'required|in:Pembelajaran terstruktur,Pembelajaran kolaboratif,Pembelajaran di tempat kerja,Pembelajaran terintegrasi',
            'jenis_pembelajaran' => 'required|in:Kedinasan,Fungsional auditor,Teknis substansi,Sertifikasi non JFA',
            'metode_pembelajaran' => 'required|in:Synchronous learning,Asynchronous learning,Blended learning',
            'sasaran_peserta' => 'required|string|max:255',
            'kriteria_peserta' => 'required|string|max:255',
            'aktivitas_prapembelajaran' => 'required|string|max:255',
            'penyelenggara_pembelajaran' => 'required|in:Pusdiklatwas BPKP,Unit kerja,Lainnya',
            'fasilitator_pembelajaran' => 'required|in:Widyaiswara,Instruktur,Praktisi,Pakar,Tutor,Coach,Mentor,Narasumber lainnya',
            'sertifikat' => 'required|string|max:255',
        ]);

        DB::table('pengajuan_kap')->insert([
            'kode_pembelajaran' => $validatedData['kode_pembelajaran'],
            'institusi_sumber' => $validatedData['institusi_sumber'],
            'jenis_program' => $validatedData['jenis_program'],
            'frekuensi_pelaksanaan' => $validatedData['frekuensi_pelaksanaan'],
            'indikator_kinerja' => $validatedData['indikator_kinerja'],
            'kompetensi_id' => $validatedData['kompetensi_id'],
            'topik_id' => $validatedData['topik_id'],
            'concern_program_pembelajaran' => $validatedData['concern_program_pembelajaran'],
            'alokasi_waktu' => $validatedData['alokasi_waktu'],
            'indikator_dampak_terhadap_kinerja_organisasi' => $validatedData['indikator_dampak_terhadap_kinerja_organisasi'],
            'penugasan_yang_terkait_dengan_pembelajaran' => $validatedData['penugasan_yang_terkait_dengan_pembelajaran'],
            'skill_group_owner' => $validatedData['skill_group_owner'],
            'bentuk_pembelajaran' => $validatedData['bentuk_pembelajaran'],
            'jalur_pembelajaran' => $validatedData['jalur_pembelajaran'],
            'model_pembelajaran' => $validatedData['model_pembelajaran'],
            'jenis_pembelajaran' => $validatedData['jenis_pembelajaran'],
            'metode_pembelajaran' => $validatedData['metode_pembelajaran'],
            'sasaran_peserta' => $validatedData['sasaran_peserta'],
            'kriteria_peserta' => $validatedData['kriteria_peserta'],
            'aktivitas_prapembelajaran' => $validatedData['aktivitas_prapembelajaran'],
            'penyelenggara_pembelajaran' => $validatedData['penyelenggara_pembelajaran'],
            'fasilitator_pembelajaran' => $validatedData['fasilitator_pembelajaran'],
            'sertifikat' => $validatedData['sertifikat'],
            'tanggal_created' => date('Y-m-d H:i:s'),
            'status_pengajuan' => 'Pending',
            'user_created' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi])->with('success', 'Pengajuan KAP berhasil disimpan.');
    }

    public function update(Request $request, $id, $is_bpkp, $frekuensi)
    {
        $validatedData = $request->validate([
            'kode_pembelajaran' => 'required|string|max:50',
            'institusi_sumber' => 'required|in:BPKP,Non BPKP',
            'jenis_program' => 'required|in:Renstra,APP,APEP,APIP',
            'frekuensi_pelaksanaan' => 'required|in:Tahunan,Insidentil',
            'indikator_kinerja' => 'required|string|max:255',
            'kompetensi_id' => 'nullable|exists:kompetensi,id',
            'topik_id' => 'nullable|exists:topik,id',
            'concern_program_pembelajaran' => 'required|string|max:255',
            'alokasi_waktu' => 'required|string|max:10',
            'indikator_dampak_terhadap_kinerja_organisasi' => 'required|string|max:255',
            'penugasan_yang_terkait_dengan_pembelajaran' => 'required|string|max:255',
            'skill_group_owner' => 'required|string|max:255',
            'bentuk_pembelajaran' => 'required|in:Klasikal,Nonklasikal',
            'jalur_pembelajaran' => 'required|in:Pelatihan,Seminar/konferensi/sarasehan,Kursus,Lokakarya (workshop),Belajar mandiri,Coaching,Mentoring,Bimbingan teknis,Sosialisasi,Detasering (secondment),Job shadowing,Outbond,Benchmarking,Pertukaran PNS,Community of practices,Pelatihan di kantor sendiri,Library café,Magang/praktik kerja',
            'model_pembelajaran' => 'required|in:Pembelajaran terstruktur,Pembelajaran kolaboratif,Pembelajaran di tempat kerja,Pembelajaran terintegrasi',
            'jenis_pembelajaran' => 'required|in:Kedinasan,Fungsional auditor,Teknis substansi,Sertifikasi non JFA',
            'metode_pembelajaran' => 'required|in:Synchronous learning,Asynchronous learning,Blended learning',
            'sasaran_peserta' => 'required|string|max:255',
            'kriteria_peserta' => 'required|string|max:255',
            'aktivitas_prapembelajaran' => 'required|string|max:255',
            'penyelenggara_pembelajaran' => 'required|in:Pusdiklatwas BPKP,Unit kerja,Lainnya',
            'fasilitator_pembelajaran' => 'required|in:Widyaiswara,Instruktur,Praktisi,Pakar,Tutor,Coach,Mentor,Narasumber lainnya',
            'sertifikat' => 'required|string|max:255',
            'tanggal_created' => 'required|date',
            'status_pengajuan' => 'required|in:Pending,Approved,Rejected',
            'user_created' => 'nullable|exists:users,id',
        ]);

        DB::table('pengajuan_kap')
            ->where('id', $id)
            ->update([
                'kode_pembelajaran' => $validatedData['kode_pembelajaran'],
                'institusi_sumber' => $validatedData['institusi_sumber'],
                'jenis_program' => $validatedData['jenis_program'],
                'frekuensi_pelaksanaan' => $validatedData['frekuensi_pelaksanaan'],
                'indikator_kinerja' => $validatedData['indikator_kinerja'],
                'kompetensi_id' => $validatedData['kompetensi_id'],
                'topik_id' => $validatedData['topik_id'],
                'concern_program_pembelajaran' => $validatedData['concern_program_pembelajaran'],
                'alokasi_waktu' => $validatedData['alokasi_waktu'],
                'indikator_dampak_terhadap_kinerja_organisasi' => $validatedData['indikator_dampak_terhadap_kinerja_organisasi'],
                'penugasan_yang_terkait_dengan_pembelajaran' => $validatedData['penugasan_yang_terkait_dengan_pembelajaran'],
                'skill_group_owner' => $validatedData['skill_group_owner'],
                'bentuk_pembelajaran' => $validatedData['bentuk_pembelajaran'],
                'jalur_pembelajaran' => $validatedData['jalur_pembelajaran'],
                'model_pembelajaran' => $validatedData['model_pembelajaran'],
                'jenis_pembelajaran' => $validatedData['jenis_pembelajaran'],
                'metode_pembelajaran' => $validatedData['metode_pembelajaran'],
                'sasaran_peserta' => $validatedData['sasaran_peserta'],
                'kriteria_peserta' => $validatedData['kriteria_peserta'],
                'aktivitas_prapembelajaran' => $validatedData['aktivitas_prapembelajaran'],
                'penyelenggara_pembelajaran' => $validatedData['penyelenggara_pembelajaran'],
                'fasilitator_pembelajaran' => $validatedData['fasilitator_pembelajaran'],
                'sertifikat' => $validatedData['sertifikat'],
                'tanggal_created' => $validatedData['tanggal_created'],
                'status_pengajuan' => $validatedData['status_pengajuan'],
                'user_created' => $validatedData['user_created'],
                'updated_at' => now(),
            ]);

        return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi])->with('success', 'Pengajuan KAP berhasil diperbarui.');
    }

    public function destroy($id, $is_bpkp, $frekuensi)
    {
        DB::table('pengajuan_kap')->where('id', $id)->delete();

        return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi])->with('success', 'Pengajuan KAP berhasil dihapus.');
    }
}
