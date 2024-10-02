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
        Schema::create('kompetensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_besar_id')->nullable()->constrained('kelompok_besar')->restrictOnUpdate()->nullOnDelete();
            $table->foreignId('kategori_kompetensi_id')->nullable()->constrained('kategori_kompetensi')->restrictOnUpdate()->nullOnDelete();
            $table->foreignId('akademi_id')->nullable()->constrained('akademi')->restrictOnUpdate()->nullOnDelete();
            $table->string('nama_kompetensi', 255);
			$table->text('deskripsi_kompetensi')->nullable();
            $table->enum('is_apip', ['Yes', 'No'])->default('No'); // Tambahan field is_apip
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
        Schema::dropIfExists('kompetensi');
    }
};
