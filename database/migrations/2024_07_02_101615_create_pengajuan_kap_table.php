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
            $table->text('indikator_kinerja')->nullable();
            $table->foreignId('kompetensi_id')->nullable()->constrained('kompetensi')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('topik_id')->nullable()->constrained('topik')->cascadeOnUpdate()->nullOnDelete();
            $table->text('judul')->nullable(); // kaldikdesc
            $table->text('arahan_pimpinan');
            $table->string('tahun', 10); // kaldikYear
            $table->string('prioritas_pembelajaran', 50);
            $table->text('tujuan_program_pembelajaran');
            $table->text('indikator_dampak_terhadap_kinerja_organisasi');
            $table->text('penugasan_yang_terkait_dengan_pembelajaran');
            $table->text('skill_group_owner');
            // new
            $table->char('diklatLocID', 5)->nullable();
            $table->text('diklatLocName')->nullable();
            $table->string('detail_lokasi', 255)->nullable(); // tempatName
            $table->integer('kelas')->nullable();
            $table->char('diklatTypeID', 5)->nullable();
            $table->text('diklatTypeName')->nullable();
            $table->char('metodeID', 5)->nullable();
            $table->text('metodeName')->nullable();
            $table->char('biayaID', 5)->nullable();
            $table->text('biayaName')->nullable();
            $table->char('latsar_stat', 5)->nullable();
            $table->enum('bentuk_pembelajaran', ['Klasikal', 'Nonklasikal'])->nullable();
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
            ])->nullable();
            $table->enum('model_pembelajaran', ['Pembelajaran terstruktur', 'Pembelajaran kolaboratif', 'Pembelajaran di tempat kerja', 'Pembelajaran terintegrasi'])->nullable();
            $table->enum('peserta_pembelajaran', ['Internal', 'Eksternal', 'Internal dan Eksternal'])->nullable();
            $table->text('sasaran_peserta')->nullable();
            $table->text('kriteria_peserta')->nullable();
            $table->text('aktivitas_prapembelajaran')->nullable();
            $table->enum('penyelenggara_pembelajaran', ['Pusdiklatwas BPKP', 'Unit kerja', 'Lainnya'])->nullable();
            $table->json('fasilitator_pembelajaran')->nullable();
            $table->text('sertifikat')->nullable();
            $table->datetime('tanggal_created');
            $table->enum('status_pengajuan', ['Pending', 'Process', 'Approved', 'Rejected']);
            $table->enum('status_sync', ['Waiting', 'Success', 'Failed'])->default('Waiting');
            $table->foreignId('user_created')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->tinyInteger('current_step');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengajuan_kap');
    }
};
