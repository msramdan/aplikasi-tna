<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSumberDanaToPengajuanKapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan_kap', function (Blueprint $table) {
            $table->string('sumber_dana', 10)->nullable()->after('institusi_sumber');
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
            $table->dropColumn('sumber_dana');
        });
    }
}
