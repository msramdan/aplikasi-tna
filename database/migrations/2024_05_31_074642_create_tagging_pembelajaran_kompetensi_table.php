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
        Schema::create('tagging_pembelajaran_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topik_id')->constrained('topik')->restrictOnUpdate()->cascadeOnDelete();
			$table->foreignId('kompetensi_id')->constrained('kompetensi')->restrictOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('tagging_pembelajaran_kompetensi');
    }
};
