<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('level_evaluasi_instrumen_kap', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_kap_id');
            $table->string('level');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->foreign('pengajuan_kap_id')->references('id')->on('pengajuan_kap')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_evaluasi_instrumen_kap');
    }
};
