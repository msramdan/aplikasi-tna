<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanKap extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_kap';

    protected $fillable = [
        'kode_pembelajaran',
        'institusi_sumber',
        'jenis_program',
        'frekuensi_pelaksanaan',
        'indikator_kinerja',
        'kompetensi_id',
        'topik_id',
        'concern_program_pembelajaran',
        'alokasi_waktu',
        'indikator_dampak_terhadap_kinerja_organisasi',
        'penugasan_yang_terkait_dengan_pembelajaran',
        'skill_group_owner',
        'bentuk_pembelajaran',
        'jalur_pembelajaran',
        'model_pembelajaran',
        'jenis_pembelajaran',
        'metode_pembelajaran',
        'sasaran_peserta',
        'kriteria_peserta',
        'aktivitas_prapembelajaran',
        'penyelenggara_pembelajaran',
        'fasilitator_pembelajaran',
        'sertifikat',
        'tanggal_created',
        'status_pengajuan',
        'user_created',
    ];

    protected $casts = ['kode_pembelajaran' => 'string', 'indikator_kinerja' => 'string', 'concern_program_pembelajaran' => 'string', 'alokasi_waktu' => 'string', 'indikator_dampak_terhadap_kinerja_organisasi' => 'string', 'penugasan_yang_terkait_dengan_pembelajaran' => 'string', 'skill_group_owner' => 'string', 'sasaran_peserta' => 'string', 'kriteria_peserta' => 'string', 'aktivitas_prapembelajaran' => 'string', 'sertifikat' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

    public function kompetensi()
    {
        return $this->belongsTo(\App\Models\Kompetensi::class);
    }
    public function topik()
    {
        return $this->belongsTo(\App\Models\Topik::class);
    }
}
