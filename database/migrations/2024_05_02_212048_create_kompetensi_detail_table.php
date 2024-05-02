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
        Schema::create('kompetensi_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kompetensi_id')->constrained('kompetensi')->restrictOnUpdate()->cascadeOnDelete();
            $table->integer('level');
            $table->text('deskripsi_level');
            $table->text('indikator_perilaku');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kompetensi_detail');
    }
};
