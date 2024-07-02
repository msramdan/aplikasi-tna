<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_kap', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembelajaran', 50);
			$table->enum('type_pembelajaran', ['Tahunan', 'Insidentil']);
			$table->string('indikator_kinerja', 255);
			$table->foreignId('kompetensi_id')->nullable()->constrained('kompetensi')->cascadeOnUpdate()->nullOnDelete();
			$table->foreignId('topik_id')->nullable()->constrained('topik')->cascadeOnUpdate()->nullOnDelete();
			$table->string('concern_program_pembelajaran', 255);
			$table->string('alokasi_waktu', 10);
			$table->string('indikator_dampak_terhadap_kinerja_organisasi', 255);
			$table->string('penugasan_yang_terkait_dengan_pembelajaran', 255);
			$table->string('skill_group_owner', 255);
			$table->enum('jalur_pembelajaran', ['Pelatihan', 'Sertifikasi', 'Pelatihan di kantor sendiri', 'Belajar mandiri']);
			$table->enum('model_pembelajaran', ['Terstruktur', 'Social learning', 'Experiential learning']);
			$table->enum('jenis_pembelajaran', ['Fungsional', 'Teknis substansi', 'Kedinasan', 'Sertifikasi non JFA']);
			$table->enum('metode_pembelajaran', ['Tatap muka', 'PJJ', 'E-learning', 'Blended']);
			$table->string('sasaran_peserta', 255);
			$table->string('kriteria_peserta', 255);
			$table->string('aktivitas_prapembelajaran', 255);
			$table->enum('penyelenggara_pembelajaran', ['Pusdiklatwas BPKP', 'Unit kerja', 'Lainnya']);
			$table->enum('fasilitator_pembelajaran', ['Widyaiswara', 'Instruktur', 'Praktisi', 'Pakar', 'Tutor', 'Coach', 'Mentor', 'Narasumber lainnya']);
			$table->string('sertifikat', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan_kap');
    }
};
