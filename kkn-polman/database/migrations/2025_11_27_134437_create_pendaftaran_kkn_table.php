<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pendaftaran_kkn', function (Blueprint $table) {
            $table->string('id_pendaftaran', 50)->primary();
            $table->string('nim', 50);
            $table->string('status', 50);
            $table->timestamps();

            $table->foreign('nim')->references('nim')->on('mahasiswa');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftaran_kkn');
    }
};