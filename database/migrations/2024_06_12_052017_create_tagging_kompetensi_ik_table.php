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
        Schema::create('tagging_kompetensi_ik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kompetensi_id')->constrained('kompetensi')->restrictOnUpdate()->cascadeOnDelete();
            $table->text('indikator_kinerja');
            $table->text('sasaran_kegiatan')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->enum('status_ruang_kelas', ['Renstra', 'APP', 'APEP', 'APIP']);
            $table->string('tahun', 10);
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
        Schema::dropIfExists('tagging_kompetensi_iks');
    }
};
