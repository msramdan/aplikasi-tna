<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaktuPelaksanaanTable extends Migration
{
    public function up()
    {
        Schema::create('waktu_pelaksanaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_kap_id');
            $table->string('remarkMetodeName', 255);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->timestamps();
            $table->foreign('pengajuan_kap_id')->references('id')->on('pengajuan_kap')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('waktu_pelaksanaan', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_kap_id']);
        });

        Schema::dropIfExists('waktu_pelaksanaan');
    }
}
