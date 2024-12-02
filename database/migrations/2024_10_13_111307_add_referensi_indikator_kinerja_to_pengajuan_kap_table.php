<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferensiIndikatorKinerjaToPengajuanKapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan_kap', function (Blueprint $table) {
            $table->string('referensi_indikator_kinerja')->nullable()->after('frekuensi_pelaksanaan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_kap', function (Blueprint $table) {
            $table->dropColumn('referensi_indikator_kinerja');
        });
    }
}
