<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;



class PengajuanKapController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pengajuan kap view')->only('index', 'show');
        $this->middleware('permission:pengajuan kap create')->only('create', 'store');
        $this->middleware('permission:pengajuan kap edit')->only('edit', 'update');
        $this->middleware('permission:pengajuan kap delete')->only('destroy');
    }

    public function index(Request $request, $is_bpkp, $frekuensi)
    {
        if (request()->ajax()) {
            $tahun = $request->query('tahun');
            $topik = intval($request->query('topik'));
            $sumber_dana = $request->query('sumber_dana');
            $current_step = intval($request->query('step'));
            $pengajuanKaps = DB::table('pengajuan_kap')
                ->select(
                    'pengajuan_kap.*',
                    'users.name as user_name',
                    'kompetensi.nama_kompetensi',
                    'topik.nama_topik',
                    'log_review_pengajuan_kap.remark'
                )
                ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
                ->leftJoin('kompetensi', 'pengajuan_kap.kompetensi_id', '=', 'kompetensi.id')
                ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id')
                ->join('log_review_pengajuan_kap', function ($join) {
                    $join->on('pengajuan_kap.id', '=', 'log_review_pengajuan_kap.pengajuan_kap_id')
                        ->whereColumn('log_review_pengajuan_kap.step', 'pengajuan_kap.current_step');
                })
                ->where('pengajuan_kap.institusi_sumber', '=', $is_bpkp)
                ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $frekuensi);

            if (isset($tahun) && !empty($tahun)) {
                if ($tahun != 'All') {
                    $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.tahun', $tahun);
                }
            }

            if (isset($topik) && !empty($topik)) {
                if ($topik != 'All') {
                    $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.topik_id', $topik);
                }
            }

            if (isset($sumber_dana) && !empty($sumber_dana)) {
                if ($sumber_dana != 'All') {
                    $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.biayaName', $sumber_dana);
                }
            }

            if (isset($current_step) && !empty($current_step)) {
                if ($current_step != 'All') {
                    $pengajuanKaps = $pengajuanKaps->where('pengajuan_kap.current_step', $current_step);
                }
            }
            $pengajuanKaps = $pengajuanKaps->orderBy('pengajuan_kap.id', 'DESC');
            return DataTables::of($pengajuanKaps)
                ->addIndexColumn()
                ->addColumn('status_kap', function ($row) {
                    return $row->status_pengajuan;
                })
                ->addColumn('remark', function ($row) {
                    return $row->remark;
                })
                ->addColumn('status_pengajuan', function ($row) {
                    if ($row->status_pengajuan == 'Pending') {
                        return '<button style="width:90px" class="btn btn-gray btn-sm btn-block"><i class="fa fa-clock" aria-hidden="true"></i> Pending</button>';
                    } else if ($row->status_pengajuan == 'Approved') {
                        return '<button style="width:90px" class="btn btn-success btn-sm btn-block"><i class="fa fa-check" aria-hidden="true"></i> Approved</button>';
                    } else if ($row->status_pengajuan == 'Rejected') {
                        return '<button style="width:90px" class="btn btn-danger btn-sm btn-block"><i class="fa fa-times" aria-hidden="true"></i> Rejected</button>';
                    } else if ($row->status_pengajuan == 'Process') {
                        return '<button style="width:90px" class="btn btn-primary btn-sm btn-block"><i class="fa fa-spinner" aria-hidden="true"></i> Process</button>';
                    }
                })
                ->addColumn('action', 'pengajuan-kap.include.action')
                ->rawColumns(['status_pengajuan', 'action'])
                ->toJson();
        }

        $topiks = DB::table('topik')->get();
        $tahun = date('Y');
        $userId = Auth::id();
        $reviewRemarks = DB::table('config_step_review')
            ->where('user_review_id', $userId)
            ->pluck('remark')
            ->toArray();
        $topik = intval($request->query('topik'))  ?? 'All';
        $sumber_dana = $request->query('sumber_dana') ?? 'All';
        $curretnStep = intval($request->query('step'))  ?? 'All';
        return view('pengajuan-kap.index', [
            'year' => $tahun,
            'is_bpkp' => $is_bpkp,
            'frekuensi' => $frekuensi,
            'reviewRemarks' => $reviewRemarks,
            'topiks' => $topiks,
            'topik_id' => $topik,
            'sumberDana' => $sumber_dana,
            'curretnStep' => $curretnStep
        ]);
    }

    public function create($is_bpkp, $frekuensi)
    {
        if ($frekuensi === 'Tahunan') {
            $today = now()->toDateString();
            $jadwalKapTahunan = DB::table('jadwal_kap_tahunan')
                ->whereDate('tanggal_mulai', '<=', $today)
                ->whereDate('tanggal_selesai', '>=', $today)
                ->orderBy('id', 'desc')
                ->first();

            if (!$jadwalKapTahunan) {
                Alert::info('Informasi', 'Jadwal pengajuan KAP tahunan telah berakhir / belum dibuka oleh admin.');
                return redirect()->back();
            }
        }

        if ($is_bpkp === 'BPKP') {
            $jenis_program = ['Renstra', 'APP', 'APEP'];
        } elseif ($is_bpkp === 'Non BPKP') {
            $jenis_program = ['APIP'];
        } else {
            $jenis_program = [];
        }

        $jalur_pembelajaran = [
            'Pelatihan',
            'Seminar/konferensi/sarasehan',
            'Kursus',
            'Lokakarya (workshop)',
            'Belajar mandiri',
            'Coaching',
            'Mentoring',
            'Bimbingan teknis',
            'Sosialisasi',
            'Detasering (secondment)',
            'Job shadowing',
            'Outbond',
            'Benchmarking',
            'Pertukaran PNS',
            'Community of practices',
            'Pelatihan di kantor sendiri',
            'Library cafe',
            'Magang/praktik kerja'
        ];

        $endpoint_pusdiklatwap = config('stara.endpoint_pusdiklatwap');
        $api_key_pusdiklatwap = config('stara.api_token_pusdiklatwap');

        // Call API for metode
        $metode_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/metode', [
            'api_key' => $api_key_pusdiklatwap
        ]);

        if (isset($metode_data['error'])) {
            Alert::error('Error', $metode_data['error']);
            return redirect()->back();
        }

        // Call API for diklatType
        $diklatType_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/diklatType', [
            'api_key' => $api_key_pusdiklatwap
        ]);

        if (isset($diklatType_data['error'])) {
            Alert::error('Error', $diklatType_data['error']);
            return redirect()->back();
        }

        // Call API for diklatLocation
        $diklatLocation_data = callApiPusdiklatwas($endpoint_pusdiklatwap . '/diklatLocation', [
            'api_key' => $api_key_pusdiklatwap
        ]);

        if (isset($diklatLocation_data['error'])) {
            Alert::error('Error', $diklatLocation_data['error']);
            return redirect()->back();
        }

        return view('pengajuan-kap.create', [
            'is_bpkp' => $is_bpkp,
            'frekuensi' => $frekuensi,
            'jenis_program' => $jenis_program,
            'jalur_pembelajaran' => $jalur_pembelajaran,
            'metode_data' => $metode_data,
            'diklatType_data' => $diklatType_data,
            'diklatLocation_data' => $diklatLocation_data, // Menambahkan data lokasi
        ]);
    }

    public function edit($id, $is_bpkp, $frekuensi)
    {
        if ($is_bpkp === 'BPKP') {
            $jenis_program = ['Renstra', 'APP', 'APEP'];
        } elseif ($is_bpkp === 'Non BPKP') {
            $jenis_program = ['APIP'];
        } else {
            $jenis_program = [];
        }

        $jalur_pembelajaran = [
            'Pelatihan',
            'Seminar/konferensi/sarasehan',
            'Kursus',
            'Lokakarya (workshop)',
            'Belajar mandiri',
            'Coaching',
            'Mentoring',
            'Bimbingan teknis',
            'Sosialisasi',
            'Detasering (secondment)',
            'Job shadowing',
            'Outbond',
            'Benchmarking',
            'Pertukaran PNS',
            'Community of practices',
            'Pelatihan di kantor sendiri',
            'Library cafe',
            'Magang/praktik kerja'
        ];

        $pengajuanKap = DB::table('pengajuan_kap')
            ->select(
                'pengajuan_kap.*',
                'users.name as user_name',
                'kompetensi.nama_kompetensi',
                'topik.nama_topik'
            )
            ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
            ->leftJoin('kompetensi', 'pengajuan_kap.kompetensi_id', '=', 'kompetensi.id')
            ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id')
            ->where('pengajuan_kap.id', '=', $id)
            ->where('pengajuan_kap.institusi_sumber', '=', $is_bpkp)
            ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $frekuensi)
            ->first();
        $lokasiData = DB::table('lokasi')->get();

        $level_evaluasi_instrumen_kap = DB::table('level_evaluasi_instrumen_kap')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $indikator_keberhasilan_kap = DB::table('indikator_keberhasilan_kap')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $waktu_tempat = DB::table('waktu_tempat')
            ->join('lokasi', 'waktu_tempat.lokasi_id', '=', 'lokasi.id')
            ->where('waktu_tempat.pengajuan_kap_id', $id)
            ->select('waktu_tempat.*', 'lokasi.nama_lokasi')
            ->get();

        return view('pengajuan-kap.edit', [
            'pengajuanKap' => $pengajuanKap,
            'is_bpkp' => $is_bpkp,
            'frekuensi' => $frekuensi,
            'jenis_program' => $jenis_program,
            'jalur_pembelajaran' => $jalur_pembelajaran,
            'lokasiData' => $lokasiData,
            'level_evaluasi_instrumen_kap' => $level_evaluasi_instrumen_kap,
            'indikator_keberhasilan_kap' => $indikator_keberhasilan_kap,
            'waktu_tempat' => $waktu_tempat,
        ]);
    }

    public function store(Request $request, $is_bpkp, $frekuensi)
    {
        $validatedData = $request->validate([
            'jenis_program' => 'required|in:Renstra,APP,APEP,APIP',
            'indikator_kinerja' => 'required|string',
            'kompetensi_id' => 'nullable|exists:kompetensi,id',
            'topik_id' => 'nullable|exists:topik,id',
            'judul' => 'required|string',
            'indikator_keberhasilan' => 'required|array',
            'arahan_pimpinan' => 'required|string',
            'prioritas_pembelajaran' => 'required|string',
            'tujuan_program_pembelajaran' => 'required|string',
            'indikator_dampak_terhadap_kinerja_organisasi' => 'required|string',
            'penugasan_yang_terkait_dengan_pembelajaran' => 'required|string',
            'skill_group_owner' => 'required|string',
            'diklatLocID' => 'nullable|string',
            'diklatLocName' => 'nullable|string',
            'detail_lokasi' => 'nullable|string',
            'kelas' => 'nullable',
            'diklatTypeID' => 'nullable|string',
            'diklatTypeName' => 'nullable|string',
            'metodeID' => 'nullable|string',
            'metodeName' => 'nullable|string',
            'biayaID' => 'nullable|string',
            'biayaName' => 'nullable|string',
            'bentuk_pembelajaran' => 'nullable|string',
            'jalur_pembelajaran' => 'nullable|string',
            'jenjang_pembelajaran' => 'nullable|string',
            'model_pembelajaran' => 'nullable|string',
            'peserta_pembelajaran' => 'nullable|string',
            'sasaran_peserta' => 'nullable|string',
            'kriteria_peserta' => 'nullable|string',
            'aktivitas_prapembelajaran' => 'nullable|string',
            'penyelenggara_pembelajaran' => 'nullable|string',
            'fasilitator_pembelajaran' => 'nullable|array',
            'fasilitator_pembelajaran.*' => 'nullable|string',
            'sertifikat' => 'nullable|string',
            'level_evaluasi_instrumen' => 'nullable|array',
            'no_level' => 'nullable|array',
            'tatap_muka_start' => 'nullable|string',
            'tatap_muka_end' => 'nullable|string',
            'hybrid_tatap_muka_start' => 'nullable|string',
            'hybrid_tatap_muka_end' => 'nullable|string',
            'hybrid_elearning_start' => 'nullable|string',
            'hybrid_elearning_end' => 'nullable|string',
            'elearning_start' => 'nullable|string',
            'elearning_end' => 'nullable|string',
            'remark_1' => 'nullable|string',
            'remark_2' => 'nullable|string',
            'remark_3' => 'nullable|string',
            'remark_4' => 'nullable|string',
        ]);

        $year = date('y');
        $topikId = sprintf('%03d', $validatedData['topik_id']);
        $lastPengajuan = DB::table('pengajuan_kap')
            ->where('tahun', date('Y'))
            ->orderBy('kode_pembelajaran', 'desc')
            ->first();
        if ($lastPengajuan) {
            $lastKodePembelajaran = substr($lastPengajuan->kode_pembelajaran, -3);
            $newNoUrut = sprintf('%03d', (int)$lastKodePembelajaran + 1);
        } else {
            $newNoUrut = '001';
        }

        $kodePembelajaran = $year . $topikId . $newNoUrut;

        // DB::beginTransaction();
        // try {
        $fasilitator_pembelajaran = $request->input('fasilitator_pembelajaran');
        $fasilitator_pembelajaran_json = empty($fasilitator_pembelajaran) ? null : json_encode($fasilitator_pembelajaran);
        foreach ($validatedData as $key => $value) {
            if ($value === 'null') {
                $validatedData[$key] = null;
            }
        }
        if ($is_bpkp == 'BPKP') {
            $biayaID = "1";
            $biayaName = "RM";
        } else {
            $biayaID = "3";
            $biayaName = "PNBP";
        }

        $pengajuanKapId = DB::table('pengajuan_kap')->insertGetId([
            'kode_pembelajaran' => $kodePembelajaran,
            'institusi_sumber' => $is_bpkp,
            'jenis_program' => $validatedData['jenis_program'],
            'frekuensi_pelaksanaan' => $frekuensi,
            'indikator_kinerja' => $validatedData['indikator_kinerja'],
            'kompetensi_id' => $validatedData['kompetensi_id'],
            'topik_id' => $validatedData['topik_id'],
            'judul' => $validatedData['judul'],
            'arahan_pimpinan' => $validatedData['arahan_pimpinan'],
            'tahun' => date('Y'),
            'prioritas_pembelajaran' => $validatedData['prioritas_pembelajaran'],
            'tujuan_program_pembelajaran' => $validatedData['tujuan_program_pembelajaran'],
            'indikator_dampak_terhadap_kinerja_organisasi' => $validatedData['indikator_dampak_terhadap_kinerja_organisasi'],
            'penugasan_yang_terkait_dengan_pembelajaran' => $validatedData['penugasan_yang_terkait_dengan_pembelajaran'],
            'skill_group_owner' => $validatedData['skill_group_owner'],
            'diklatLocID' => $validatedData['diklatLocID'],
            'diklatLocName' => $validatedData['diklatLocName'],
            'detail_lokasi' => $validatedData['detail_lokasi'],
            'kelas' => $validatedData['kelas'],
            'diklatTypeID' => $validatedData['diklatTypeID'],
            'diklatTypeName' => $validatedData['diklatTypeName'],
            'metodeID' => $validatedData['metodeID'],
            'metodeName' => $validatedData['metodeName'],
            'biayaID' =>  $biayaID,
            'biayaName' =>  $biayaName,
            'latsar_stat' => '0',
            'bentuk_pembelajaran' => $validatedData['bentuk_pembelajaran'],
            'jalur_pembelajaran' => $validatedData['jalur_pembelajaran'],
            'jenjang_pembelajaran' => $validatedData['jenjang_pembelajaran'],
            'model_pembelajaran' => $validatedData['model_pembelajaran'],
            'peserta_pembelajaran' => $validatedData['peserta_pembelajaran'],
            'sasaran_peserta' => $validatedData['sasaran_peserta'],
            'kriteria_peserta' => $validatedData['kriteria_peserta'],
            'aktivitas_prapembelajaran' => $validatedData['aktivitas_prapembelajaran'],
            'penyelenggara_pembelajaran' => $validatedData['penyelenggara_pembelajaran'],
            'fasilitator_pembelajaran' => $fasilitator_pembelajaran_json,
            'sertifikat' => $validatedData['sertifikat'],
            'tanggal_created' => date('Y-m-d H:i:s'),
            'status_pengajuan' => 'Pending',
            'user_created' => Auth::id(),
            'current_step' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $metodeID = $validatedData['metodeID'];
        if ($metodeID === '1') {
            DB::table('waktu_pelaksanaan')->insert([
                'pengajuan_kap_id' => $pengajuanKapId,
                'remarkMetodeName' => $validatedData['remark_1'],
                'tanggal_mulai' => $validatedData['tatap_muka_start'],
                'tanggal_selesai' => $validatedData['tatap_muka_end'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($metodeID === '2') {
            // Insert Tatap Muka data
            DB::table('waktu_pelaksanaan')->insert([
                'pengajuan_kap_id' => $pengajuanKapId,
                'remarkMetodeName' => $validatedData['remark_2'],
                'tanggal_mulai' => $validatedData['hybrid_tatap_muka_start'],
                'tanggal_selesai' => $validatedData['hybrid_tatap_muka_end'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert E-Learning data
            DB::table('waktu_pelaksanaan')->insert([
                'pengajuan_kap_id' => $pengajuanKapId,
                'remarkMetodeName' => $validatedData['remark_3'],
                'tanggal_mulai' => $validatedData['hybrid_elearning_start'],
                'tanggal_selesai' => $validatedData['hybrid_elearning_end'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('waktu_pelaksanaan')->insert([
                'pengajuan_kap_id' => $pengajuanKapId,
                'remarkMetodeName' => $validatedData['remark_4'],
                'tanggal_mulai' => $validatedData['elearning_start'],
                'tanggal_selesai' => $validatedData['elearning_end'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        // insert table gap_kompetensi_pengajuan_kap
        DB::table('gap_kompetensi_pengajuan_kap')->insert([
            'pengajuan_kap_id' => $pengajuanKapId,
            'total_pegawai' => $request->total_pegawai,
            'pegawai_kompeten' => $request->pegawai_kompeten,
            'pegawai_belum_kompeten' => $request->pegawai_belum_kompeten,
            'persentase_kompetensi' => $request->persentase_kompetensi,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($validatedData['indikator_keberhasilan'] as $index => $row) {
            DB::table('indikator_keberhasilan_kap')->insert([
                'pengajuan_kap_id' => $pengajuanKapId,
                'indikator_keberhasilan' => $row,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($validatedData['level_evaluasi_instrumen'] as $index => $x) {
            DB::table('level_evaluasi_instrumen_kap')->insert([
                'pengajuan_kap_id' => $pengajuanKapId,
                'level' => $validatedData['no_level'][$index],
                'keterangan' => $x,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $remarks = [
            'Biro SDM',
            'Tim Unit Pengelola Pembelajaran',
            'Penjaminan Mutu',
            'Subkoordinator',
            'Koordinator',
            'Kepala Unit Pengelola Pembelajaran'
        ];

        foreach ($remarks as $index => $remark) {
            DB::table('log_review_pengajuan_kap')->insert([
                'pengajuan_kap_id' => $pengajuanKapId,
                'step' => $index + 1,
                'remark' => $remark,
                'user_review_id' => null,
                'status' => 'Pending',
                'tanggal_review' => null,
                'catatan' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //     DB::commit();
        //     Alert::toast('Pengajuan KAP berhasil disimpan.', 'success');
        //     return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]);
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     \Log::error('Error: ' . $e->getMessage());
        //     Alert::toast('Pengajuan KAP gagal disimpan.', 'error');
        //     return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]);
        // }
    }

    public function update(Request $request, $id, $is_bpkp, $frekuensi)
    {
        $validatedData = $request->validate([
            'jenis_program' => 'required|in:Renstra,APP,APEP,APIP',
            'indikator_kinerja' => 'required|string',
            'kompetensi_id' => 'nullable|exists:kompetensi,id',
            'topik_id' => 'nullable|exists:topik,id',
            'judul' => 'required|string',
            'indikator_keberhasilan' => 'required|array',
            'arahan_pimpinan' => 'required|string',
            'prioritas_pembelajaran' => 'required|string',
            'tujuan_program_pembelajaran' => 'required|string',
            'alokasi_waktu' => 'required|string|max:10',
            'indikator_dampak_terhadap_kinerja_organisasi' => 'required|string',
            'penugasan_yang_terkait_dengan_pembelajaran' => 'required|string',
            'skill_group_owner' => 'required|string',
            'bentuk_pembelajaran' => 'nullable',
            'jalur_pembelajaran' => 'nullable',
            'model_pembelajaran' => 'nullable',
            'jenjang_pembelajaran' => 'nullable',
            'jenis_pembelajaran' => 'nullable',
            'metode_pembelajaran' => 'nullable',
            'peserta_pembelajaran' => 'nullable|string',
            'sasaran_peserta' => 'nullable|string',
            'kriteria_peserta' => 'nullable|string',
            'aktivitas_prapembelajaran' => 'nullable|string',
            'penyelenggara_pembelajaran' => 'nullable',
            'fasilitator_pembelajaran' => 'nullable|array',
            'fasilitator_pembelajaran.*' => 'nullable|string|in:Widyaiswara,Instruktur,Praktisi,Pakar,Tutor,Coach,Mentor,Narasumber lainnya',
            'sertifikat' => 'nullable|string',
            'user_created' => 'nullable|exists:users,id',
            'level_evaluasi_instrumen' => 'nullable|array',
            'no_level' => 'nullable|array',
            'lokasi' => 'required|array',
            'tanggal_mulai' => 'required|array',
            'tanggal_selesai' => 'required|array',
        ]);
        $fasilitator_pembelajaran = json_encode($validatedData['fasilitator_pembelajaran']);

        DB::table('pengajuan_kap')
            ->where('id', $id)
            ->update([
                'jenis_program' => $validatedData['jenis_program'],
                'indikator_kinerja' => $validatedData['indikator_kinerja'],
                'kompetensi_id' => $validatedData['kompetensi_id'],
                'topik_id' => $validatedData['topik_id'],
                'judul' => $validatedData['judul'],
                'arahan_pimpinan' => $validatedData['arahan_pimpinan'],
                'prioritas_pembelajaran' => $validatedData['prioritas_pembelajaran'],
                'alokasi_waktu' => $validatedData['alokasi_waktu'],
                'indikator_dampak_terhadap_kinerja_organisasi' => $validatedData['indikator_dampak_terhadap_kinerja_organisasi'],
                'penugasan_yang_terkait_dengan_pembelajaran' => $validatedData['penugasan_yang_terkait_dengan_pembelajaran'],
                'skill_group_owner' => $validatedData['skill_group_owner'],
                'bentuk_pembelajaran' => $validatedData['bentuk_pembelajaran'],
                'tujuan_program_pembelajaran' => $validatedData['tujuan_program_pembelajaran'],
                'jalur_pembelajaran' => $validatedData['jalur_pembelajaran'],
                'model_pembelajaran' => $validatedData['model_pembelajaran'],
                'jenis_pembelajaran' => $validatedData['jenis_pembelajaran'],
                'metode_pembelajaran' => $validatedData['metode_pembelajaran'],
                'sasaran_peserta' => $validatedData['sasaran_peserta'],
                'kriteria_peserta' => $validatedData['kriteria_peserta'],
                'aktivitas_prapembelajaran' => $validatedData['aktivitas_prapembelajaran'],
                'penyelenggara_pembelajaran' => $validatedData['penyelenggara_pembelajaran'],
                'fasilitator_pembelajaran' => $fasilitator_pembelajaran,
                'sertifikat' => $validatedData['sertifikat'],
                'sertifikat' => $validatedData['level_evaluasi_instrumen'],
                'updated_at' => now(),

            ]);
        Alert::toast('Pengajuan KAP berhasil diperbarui.', 'success');
        return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]);
    }

    public function destroy($id, $is_bpkp, $frekuensi)
    {
        try {
            $pengajuanKap = DB::table('pengajuan_kap')->find($id);
            if (!$pengajuanKap) {
                Alert::toast('Pengajuan KAP tidak ditemukan.', 'error');
                return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]);
            }
            DB::table('pengajuan_kap')->where('id', $id)->delete();
            Alert::toast('Pengajuan KAP berhasil dihapus.', 'success');
        } catch (\Exception $e) {
            Alert::toast('Terjadi kesalahan saat menghapus Pengajuan KAP', 'error');
            return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]);
        }
        return redirect()->route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]);
    }

    public function show($id, $is_bpkp, $frekuensi)
    {
        $pengajuanKap = DB::table('pengajuan_kap')
            ->select(
                'pengajuan_kap.*',
                'users.name as user_name',
                'kompetensi.nama_kompetensi',
                'topik.nama_topik'
            )
            ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
            ->leftJoin('kompetensi', 'pengajuan_kap.kompetensi_id', '=', 'kompetensi.id')
            ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id')
            ->where('pengajuan_kap.id', '=', $id)
            ->where('pengajuan_kap.institusi_sumber', '=', $is_bpkp)
            ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $frekuensi)
            ->first();

        $logReviews = DB::table('log_review_pengajuan_kap')
            ->select(
                'log_review_pengajuan_kap.*',
                'users.name as user_name'
            )
            ->leftJoin('users', 'log_review_pengajuan_kap.user_review_id', '=', 'users.id')
            ->where('log_review_pengajuan_kap.pengajuan_kap_id', '=', $id)
            ->orderBy('log_review_pengajuan_kap.step')
            ->get();

        $level_evaluasi_instrumen_kap = DB::table('level_evaluasi_instrumen_kap')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $indikator_keberhasilan_kap = DB::table('indikator_keberhasilan_kap')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $waktu_pelaksanaan = DB::table('waktu_pelaksanaan')
            ->where('waktu_pelaksanaan.pengajuan_kap_id', $id)
            ->select('waktu_pelaksanaan.*')
            ->get();
        $steps = [
            'Biro SDM',
            'Tim Unit Pengelola Pembelajaran',
            'Penjaminan Mutu',
            'Subkoordinator',
            'Koordinator',
            'Kepala Unit Pengelola Pembelajaran'
        ];

        $currentStepRemark = isset($pengajuanKap->current_step) && $pengajuanKap->current_step > 0 && $pengajuanKap->current_step <= count($steps)
            ? $steps[$pengajuanKap->current_step - 1]
            : '-';
        $userHasAccess = DB::table('config_step_review')
            ->where('remark', $currentStepRemark)
            ->where('user_review_id', Auth::id())
            ->exists();
        $gap_kompetensi_pengajuan_kap = DB::table('gap_kompetensi_pengajuan_kap')
            ->where('pengajuan_kap_id', $id)
            ->first();

        return view('pengajuan-kap.show', [
            'pengajuanKap' => $pengajuanKap,
            'logReviews' => $logReviews,
            'level_evaluasi_instrumen_kap' => $level_evaluasi_instrumen_kap,
            'indikator_keberhasilan_kap' => $indikator_keberhasilan_kap,
            'waktu_pelaksanaan' => $waktu_pelaksanaan,
            'is_bpkp' => $is_bpkp,
            'frekuensi' => $frekuensi,
            'currentStepRemark' => $currentStepRemark,
            'userHasAccess' => $userHasAccess,
            'gap_kompetensi_pengajuan_kap' => $gap_kompetensi_pengajuan_kap
        ]);
    }

    public function approve(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Retrieve the PengajuanKap record by its ID
            $pengajuanKap = DB::table('pengajuan_kap')->find($id);

            // Check for the current_step in PengajuanKap
            $currentStep = $pengajuanKap->current_step;

            // Query the log_review_pengajuan_kap table for the first matching record
            $logReview = DB::table('log_review_pengajuan_kap')
                ->where('pengajuan_kap_id', $id)
                ->where('step', $currentStep)
                ->first();

            // If a matching log review is found, update its fields
            if ($logReview) {
                DB::table('log_review_pengajuan_kap')
                    ->where('id', $logReview->id)
                    ->update([
                        'status' => 'Approved',
                        'tanggal_review' => Carbon::now(),
                        'catatan' => $request->approveNotes,
                        'user_review_id' => Auth::id(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                // After updating log review, get the maximum step from log_review_pengajuan_kap
                $maxStep = DB::table('log_review_pengajuan_kap')
                    ->where('pengajuan_kap_id', $id)
                    ->max('step');

                // Update logic based on the maximum step found
                if ($maxStep === $currentStep) {
                    // If the current step matches the max step, update pengajuan_kap status
                    DB::table('pengajuan_kap')
                        ->where('id', $id)
                        ->update([
                            'status_pengajuan' => 'Approved',
                            'updated_at' => Carbon::now(),
                        ]);
                    if (env('OTOMATIS_SYNC_INFO_DIKLAT', false)) {
                        $syncResult = syncData($pengajuanKap);
                        if (!$syncResult) {
                            DB::rollBack();
                            Alert::toast('Failed to sync data with the external API.', 'error');
                            return redirect()->back();
                        }
                    }
                } else {
                    // Otherwise, increment the current step in the pengajuan_kap table
                    DB::table('pengajuan_kap')
                        ->where('id', $id)
                        ->update([
                            'current_step' => $currentStep + 1,
                            'status_pengajuan' => 'Process',
                            'updated_at' => Carbon::now(),
                        ]);
                }
            }

            DB::commit();
            Alert::toast('Pengajuan Kap approved successfully.', 'success');
            // Redirect with success message
            return redirect()->route('pengajuan-kap.index', [
                'is_bpkp' => $pengajuanKap->institusi_sumber,
                'frekuensi' => $pengajuanKap->frekuensi_pelaksanaan,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('Failed to approve Pengajuan Kap. Please try again', 'error');

            // Handle the exception, optionally log it or notify the user
            return redirect()->back();
        }
    }

    public function reject(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Retrieve the PengajuanKap record by its ID
            $pengajuanKap = DB::table('pengajuan_kap')->find($id);

            // Check for the current_step in PengajuanKap
            $currentStep = $pengajuanKap->current_step;

            // Query the log_review_pengajuan_kap table for the first matching record
            $logReview = DB::table('log_review_pengajuan_kap')
                ->where('pengajuan_kap_id', $id)
                ->where('step', $currentStep)
                ->first();

            // If a matching log review is found, update its fields
            if ($logReview) {
                DB::table('log_review_pengajuan_kap')
                    ->where('id', $logReview->id)
                    ->update([
                        'status' => 'Rejected',
                        'tanggal_review' => Carbon::now(),
                        'catatan' => $request->rejectNotes,
                        'user_review_id' => Auth::id(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                // Update pengajuan_kap status to 'Rejected'
                DB::table('pengajuan_kap')
                    ->where('id', $id)
                    ->update([
                        'status_pengajuan' => 'Rejected',
                        'updated_at' => Carbon::now(),
                    ]);
            }

            DB::commit();
            Alert::toast('Pengajuan Kap rejected successfully.', 'success');

            // Redirect with success message
            return redirect()->route('pengajuan-kap.index', [
                'is_bpkp' => $pengajuanKap->institusi_sumber,
                'frekuensi' => $pengajuanKap->frekuensi_pelaksanaan,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('Failed to reject Pengajuan Kap. Please try again', 'error');

            // Handle the exception, optionally log it or notify the user
            return redirect()->back();
        }
    }

    public function cetak_pdf($id, $is_bpkp, $frekuensi)
    {
        $pengajuanKap = DB::table('pengajuan_kap')
            ->select(
                'pengajuan_kap.*',
                'users.name as user_name',
                'kompetensi.nama_kompetensi',
                'topik.nama_topik'
            )
            ->leftJoin('users', 'pengajuan_kap.user_created', '=', 'users.id')
            ->leftJoin('kompetensi', 'pengajuan_kap.kompetensi_id', '=', 'kompetensi.id')
            ->leftJoin('topik', 'pengajuan_kap.topik_id', '=', 'topik.id')
            ->where('pengajuan_kap.id', '=', $id)
            ->where('pengajuan_kap.institusi_sumber', '=', $is_bpkp)
            ->where('pengajuan_kap.frekuensi_pelaksanaan', '=', $frekuensi)
            ->first();

        $logReviews = DB::table('log_review_pengajuan_kap')
            ->select(
                'log_review_pengajuan_kap.*',
                'users.name as user_name'
            )
            ->leftJoin('users', 'log_review_pengajuan_kap.user_review_id', '=', 'users.id')
            ->where('log_review_pengajuan_kap.pengajuan_kap_id', '=', $id)
            ->orderBy('log_review_pengajuan_kap.step')
            ->get();

        $level_evaluasi_instrumen_kap = DB::table('level_evaluasi_instrumen_kap')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $indikator_keberhasilan_kap = DB::table('indikator_keberhasilan_kap')
            ->where('pengajuan_kap_id', $id)
            ->get();
        $waktu_pelaksanaan = DB::table('waktu_pelaksanaan')
            ->where('waktu_pelaksanaan.pengajuan_kap_id', $id)
            ->select('waktu_pelaksanaan.*')
            ->get();
        $gap_kompetensi_pengajuan_kap = DB::table('gap_kompetensi_pengajuan_kap')
            ->where('pengajuan_kap_id', $id)
            ->first();

        $pdf = PDF::loadview('pengajuan-kap.pdf', [
            'pengajuanKap' => $pengajuanKap,
            'logReviews' => $logReviews,
            'level_evaluasi_instrumen_kap' => $level_evaluasi_instrumen_kap,
            'indikator_keberhasilan_kap' => $indikator_keberhasilan_kap,
            'waktu_pelaksanaan' => $waktu_pelaksanaan,
            'is_bpkp' => $is_bpkp,
            'frekuensi' => $frekuensi,
            'gap_kompetensi_pengajuan_kap' => $gap_kompetensi_pengajuan_kap
        ]);
        return $pdf->stream('pengajuan-kap.pdf');
    }

    public function approveSelected(Request $request)
    {
        $ids = $request->ids;
        $approvalNote = $request->note;

        DB::beginTransaction();

        try {
            foreach ($ids as $id) {
                // Retrieve the PengajuanKap record by its ID
                $pengajuanKap = DB::table('pengajuan_kap')->find($id);

                // Check for the current_step in PengajuanKap
                $currentStep = $pengajuanKap->current_step;

                // Query the log_review_pengajuan_kap table for the first matching record
                $logReview = DB::table('log_review_pengajuan_kap')
                    ->where('pengajuan_kap_id', $id)
                    ->where('step', $currentStep)
                    ->first();

                // If a matching log review is found, update its fields
                if ($logReview) {
                    DB::table('log_review_pengajuan_kap')
                        ->where('id', $logReview->id)
                        ->update([
                            'status' => 'Approved',
                            'tanggal_review' => Carbon::now(),
                            'catatan' => $approvalNote,
                            'user_review_id' => Auth::id(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    // After updating log review, get the maximum step from log_review_pengajuan_kap
                    $maxStep = DB::table('log_review_pengajuan_kap')
                        ->where('pengajuan_kap_id', $id)
                        ->max('step');

                    // Update logic based on the maximum step found
                    if ($maxStep === $currentStep) {
                        // If the current step matches the max step, update pengajuan_kap status
                        DB::table('pengajuan_kap')
                            ->where('id', $id)
                            ->update([
                                'status_pengajuan' => 'Approved',
                                'updated_at' => Carbon::now(),
                            ]);
                        if (env('OTOMATIS_SYNC_INFO_DIKLAT', false)) {
                            $syncResult = syncData($pengajuanKap);
                            if (!$syncResult) {
                                DB::rollBack();
                                Alert::toast('Failed to sync data with the external API.', 'error');
                                return redirect()->back();
                            }
                        }
                    } else {
                        // Otherwise, increment the current step in the pengajuan_kap table
                        DB::table('pengajuan_kap')
                            ->where('id', $id)
                            ->update([
                                'current_step' => $currentStep + 1,
                                'status_pengajuan' => 'Process',
                                'updated_at' => Carbon::now(),
                            ]);
                    }
                }
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pengajuan Kap approved successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Failed to approve Pengajuan Kap. Please try again.']);
        }
    }

    public function rejectSelected(Request $request)
    {
        $ids = $request->ids;
        $rejectionNote = $request->note;

        DB::beginTransaction();

        try {
            foreach ($ids as $id) {
                // Retrieve the PengajuanKap record by its ID
                $pengajuanKap = DB::table('pengajuan_kap')->find($id);

                // Check for the current_step in PengajuanKap
                $currentStep = $pengajuanKap->current_step;

                // Query the log_review_pengajuan_kap table for the first matching record
                $logReview = DB::table('log_review_pengajuan_kap')
                    ->where('pengajuan_kap_id', $id)
                    ->where('step', $currentStep)
                    ->first();

                // If a matching log review is found, update its fields
                if ($logReview) {
                    DB::table('log_review_pengajuan_kap')
                        ->where('id', $logReview->id)
                        ->update([
                            'status' => 'Rejected',
                            'tanggal_review' => Carbon::now(),
                            'catatan' => $rejectionNote,
                            'user_review_id' => Auth::id(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    // Update pengajuan_kap status to 'Rejected'
                    DB::table('pengajuan_kap')
                        ->where('id', $id)
                        ->update([
                            'status_pengajuan' => 'Rejected',
                            'updated_at' => Carbon::now(),
                        ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pengajuan Kap rejected successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Failed to reject Pengajuan Kap. Please try again.']);
        }
    }

    public function skipSelected(Request $request)
    {
        $ids = $request->ids;
        $approvalNote = $request->note;

        DB::beginTransaction();

        try {
            foreach ($ids as $id) {
                // Retrieve the PengajuanKap record by its ID
                $pengajuanKap = DB::table('pengajuan_kap')->find($id);

                // Check for the current_step in PengajuanKap
                $currentStep = $pengajuanKap->current_step;

                // Query the log_review_pengajuan_kap table for the first matching record
                $logReview = DB::table('log_review_pengajuan_kap')
                    ->where('pengajuan_kap_id', $id)
                    ->where('step', $currentStep)
                    ->first();

                // If a matching log review is found, update its fields
                if ($logReview) {
                    DB::table('log_review_pengajuan_kap')
                        ->where('id', $logReview->id)
                        ->update([
                            'status' => 'Skiped',
                            'tanggal_review' => Carbon::now(),
                            'catatan' => $approvalNote,
                            'user_review_id' => Auth::id(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    // After updating log review, get the maximum step from log_review_pengajuan_kap
                    $maxStep = DB::table('log_review_pengajuan_kap')
                        ->where('pengajuan_kap_id', $id)
                        ->max('step');

                    // Update logic based on the maximum step found
                    if ($maxStep === $currentStep) {
                        DB::table('pengajuan_kap')
                            ->where('id', $id)
                            ->update([
                                'status_pengajuan' => 'Approved',
                                'updated_at' => Carbon::now(),
                            ]);
                        if (env('OTOMATIS_SYNC_INFO_DIKLAT', false)) {
                            $syncResult = syncData($pengajuanKap);
                            if (!$syncResult) {
                                DB::rollBack();
                                Alert::toast('Failed to sync data with the external API.', 'error');
                                return redirect()->back();
                            }
                        }
                    } else {
                        // Otherwise, increment the current step in the pengajuan_kap table
                        DB::table('pengajuan_kap')
                            ->where('id', $id)
                            ->update([
                                'current_step' => $currentStep + 1,
                                'status_pengajuan' => 'Process',
                                'updated_at' => Carbon::now(),
                            ]);
                    }
                }
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pengajuan Kap skiped successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Failed to approve Pengajuan Kap. Please try again.']);
        }
    }
}
