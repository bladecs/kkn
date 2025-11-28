<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('anggota_kelompok', function (Blueprint $table) {
            $table->string('id_anggota', 50)->primary();
            $table->string('nim', 50);
            $table->string('kelompok_id', 50);
            $table->string('role_anggota', 50);
            $table->timestamps();

            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->foreign('kelompok_id')->references('id_kelompok')->on('kelompok_kkn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggota_kelompok');
    }
};