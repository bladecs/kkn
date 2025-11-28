<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('logbook_kegiatan', function (Blueprint $table) {
            $table->string('id_logbook', 50)->primary();
            $table->string('anggota_id', 50);
            $table->integer('nilai')->nullable();
            $table->string('status', 50);
            $table->integer('week');
            $table->timestamps();

            $table->foreign('anggota_id')->references('id_anggota')->on('anggota_kelompok');
        });
    }

    public function down()
    {
        Schema::dropIfExists('logbook_kegiatan');
    }
};