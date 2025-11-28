<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_kelompok_kkn', function (Blueprint $table) {
            $table->string('id_detail_kelompok', 50)->primary();
            $table->string('kelompok_id', 50);
            $table->string('project_id', 50);
            $table->integer('jumlah_anggota');
            $table->dateTime('tgl_mulai');
            $table->dateTime('tgl_selesai');
            $table->timestamps();

            $table->foreign('kelompok_id')->references('id_kelompok')->on('kelompok_kkn');
            $table->foreign('project_id')->references('id_project')->on('project_kkn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_kelompok_kkn');
    }
};