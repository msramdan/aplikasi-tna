<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('log_review_pengajuan_kap', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_kap_id');
            $table->tinyInteger('step');
            $table->string('remark');
            $table->unsignedBigInteger('user_review_id')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected', '']);
            $table->date('tanggal_review');
            $table->text('catatan');
            $table->timestamps();
            $table->foreign('pengajuan_kap_id')->references('id')->on('pengajuan_kap')->onDelete('cascade');
            $table->foreign('user_review_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('log_review_pengajuan_kap', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_kap_id']);
            $table->dropForeign(['user_review_id']);
        });

        Schema::dropIfExists('log_review_pengajuan_kap');
    }
};
