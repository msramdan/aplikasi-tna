<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengajuan_kap_gap_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_kap_id');
            $table->foreignId('kompetensi_id')->nullable()->constrained('kompetensi')->cascadeOnUpdate()->nullOnDelete();
            $table->integer('total_pegawai')->nullable();
            $table->integer('pegawai_kompeten')->nullable();
            $table->integer('pegawai_belum_kompeten')->nullable();
            $table->integer('persentase_kompetensi')->nullable();
            $table->timestamps();
            $table->foreign('pengajuan_kap_id')->references('id')->on('pengajuan_kap')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('pengajuan_kap_gap_kompetensi', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_kap_id']);
        });

        Schema::dropIfExists('pengajuan_kap_gap_kompetensi');
    }
};
