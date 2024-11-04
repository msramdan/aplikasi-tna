<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengajuan_kap_indikator_kinerja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_kap_id');
            $table->text('indikator_kinerja')->nullable();
            $table->timestamps();
            $table->foreign('pengajuan_kap_id')->references('id')->on('pengajuan_kap')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('pengajuan_kap_indikator_kinerja', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_kap_id']);
        });

        Schema::dropIfExists('pengajuan_kap_indikator_kinerja');
    }
};
