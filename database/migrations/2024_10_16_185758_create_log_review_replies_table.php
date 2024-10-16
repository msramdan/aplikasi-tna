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
        Schema::create('log_review_pengajuan_kap_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('log_review_pengajuan_kap_id');
            $table->string('user_name');
            $table->text('message');
            $table->timestamps();

            // Tambahkan foreign key dengan nama yang lebih pendek
            $table->foreign('log_review_pengajuan_kap_id', 'fk_log_review_kap_id')
                ->references('id')->on('log_review_pengajuan_kap')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_review_pengajuan_kap_replies');
    }
};
