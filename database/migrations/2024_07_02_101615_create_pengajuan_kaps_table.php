<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('pengajuan_kap', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembelajaran', 50);
            $table->enum('institusi_sumber', ['BPKP', 'Non BPKP']);
            $table->enum('jenis_program', ['Renstra', 'APP', 'APEP', 'APIP']);
            $table->enum('frekuensi_pelaksanaan', ['Tahunan', 'Insidentil']);
            $table->text('indikator_kinerja');
            $table->foreignId('kompetensi_id')->nullable()->constrained('kompetensi')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('topik_id')->nullable()->constrained('topik')->cascadeOnUpdate()->nullOnDelete();
            $table->text('arahan_pimpinan');
            $table->string('tahun', 10);
            $table->string('prioritas_pembelajaran', 50);
            $table->text('tujuan_program_pembelajaran');
            $table->string('alokasi_waktu', 50);
            $table->text('indikator_dampak_terhadap_kinerja_organisasi');
            $table->text('penugasan_yang_terkait_dengan_pembelajaran');
            $table->text('skill_group_owner');
            $table->enum('bentuk_pembelajaran', ['Klasikal', 'Nonklasikal']);
            $table->enum('jalur_pembelajaran', [
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
            ]);
            $table->enum('model_pembelajaran', ['Pembelajaran terstruktur', 'Pembelajaran kolaboratif', 'Pembelajaran di tempat kerja', 'Pembelajaran terintegrasi']);
            $table->enum('jenis_pembelajaran', ['Kedinasan', 'Fungsional auditor', 'Teknis substansi', 'Sertifikasi non JFA']);
            $table->enum('metode_pembelajaran', ['Synchronous learning', 'Asynchronous learning', 'Blended learning']);
            $table->text('sasaran_peserta');
            $table->text('kriteria_peserta');
            $table->text('aktivitas_prapembelajaran');
            $table->enum('penyelenggara_pembelajaran', ['Pusdiklatwas BPKP', 'Unit kerja', 'Lainnya']);
            $table->json('fasilitator_pembelajaran')->nullable();
            $table->text('sertifikat');
            $table->datetime('tanggal_created');
            $table->enum('status_pengajuan', ['Pending', 'Process', 'Approved', 'Rejected']);
            $table->foreignId('user_created')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->tinyInteger('current_step');
            $table->timestamps();
            // $table->json('indikator_keberhasilan')->nullable();
            // $table->json('level_evaluasi_instrumen')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengajuan_kap');
    }
};
