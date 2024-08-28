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
        Schema::create('nomenklatur_pembelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rumpun_pembelajaran_id')->constrained('rumpun_pembelajaran')->restrictOnUpdate()->cascadeOnDelete();
			$table->string('nama_topik', 255);
			$table->enum('status', ['Pendding', 'Approved', 'Rejected']);
			$table->foreignId('user_created')->constrained('users')->restrictOnUpdate()->cascadeOnDelete();
			$table->dateTime('tanggal_pengajuan');
			$table->text('catatan_user_created');
			$table->foreignId('user_review')->constrained('users')->restrictOnUpdate()->cascadeOnDelete();
			$table->dateTime('tanggal_review');
			$table->text('catatan_user_review');
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
        Schema::dropIfExists('nomenklatur_pembelajaran');
    }
};
