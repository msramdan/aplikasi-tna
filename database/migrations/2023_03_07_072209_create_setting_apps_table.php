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
        Schema::create('setting_apps', function (Blueprint $table) {
            $table->id();
            $table->string('aplication_name', 150);
            $table->string('logo', 200);
            $table->string('favicon', 200);
            $table->enum('is_maintenance', ['Yes', 'No']);
            $table->enum('otomatis_sync_info_diklat', ['Yes', 'No']);
            $table->enum('reverse_atur_tagging', ['Yes', 'No']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('setting_apps');
    }
};
