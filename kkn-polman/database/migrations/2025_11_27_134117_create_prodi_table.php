<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prodi', function (Blueprint $table) {
            $table->string('id_prodi', 50)->primary();
            $table->string('jurusan_id', 50);
            $table->string('nama_prodi', 150);
            $table->timestamps();

            $table->foreign('jurusan_id')->references('id_jurusan')->on('jurusan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prodi');
    }
};