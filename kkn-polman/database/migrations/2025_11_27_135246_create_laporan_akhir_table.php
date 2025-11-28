<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laporan_akhir', function (Blueprint $table) {
            $table->string('id_laporan_akhir', 50)->primary();
            $table->string('anggota_id', 50);
            $table->string('path', 255);
            $table->integer('nilai')->nullable();
            $table->string('status', 50);
            $table->timestamps();

            $table->foreign('anggota_id')->references('id_anggota')->on('anggota_kelompok');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_akhir');
    }
};