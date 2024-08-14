<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gap_kompetensi_pengajuan_kap', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_kap_id');
            $table->integer('total_pegawai');
            $table->integer('pegawai_kompeten');
            $table->integer('pegawai_belum_kompeten');
            $table->integer('persentase_kompetensi');
            $table->timestamps();
            $table->foreign('pengajuan_kap_id')->references('id')->on('pengajuan_kap')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('gap_kompetensi_pengajuan_kap', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_kap_id']);
        });

        Schema::dropIfExists('gap_kompetensi_pengajuan_kap');
    }
};
