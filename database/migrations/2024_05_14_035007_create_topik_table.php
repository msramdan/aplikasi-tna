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
        Schema::create('topik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rumpun_pembelajaran_id')->nullable()->constrained('rumpun_pembelajaran')->restrictOnUpdate()->nullOnDelete();
            $table->text('nama_topik');
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
        Schema::dropIfExists('topik');
    }
};
