<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('config_step_review', function (Blueprint $table) {
            $table->id();
            $table->enum('remark', [
                'Tim Unit Pengelola Pembelajaran',
                'Keuangan',
                'Penjaminan Mutu',
                'Subkoordinator',
                'Koordinator',
                'Kepala Unit Pengelola Pembelajaran'
            ]);
            $table->unsignedBigInteger('user_review_id');
            $table->timestamps();

            $table->foreign('user_review_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_step_review');
    }
};
