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
        Schema::create('asrama', function (Blueprint $table) {
            $table->id();
            $table->string('nama_asrama', 150);
			$table->foreignId('lokasi_id')->nullable()->constrained('lokasi')->restrictOnUpdate()->nullOnDelete();
			$table->integer('kuota');
			$table->enum('starus_asrama', ['Available', 'Not available']);
			$table->text('keterangan');
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
        Schema::dropIfExists('asrama');
    }
};
