<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->unsignedBigInteger('user_id'); // Foreign key untuk user
            $table->unsignedBigInteger('pengajuan_kap_id');
            $table->string('message'); // Pesan notifikasi
            $table->boolean('is_read')->default(false); // Status dibaca
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
            $table->foreign('pengajuan_kap_id')->references('id')->on('pengajuan_kap')->onDelete('cascade');
            // Menambahkan foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_review_pengajuan_kap', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_kap_id']);
        });
        Schema::dropIfExists('notifications');
    }
}
