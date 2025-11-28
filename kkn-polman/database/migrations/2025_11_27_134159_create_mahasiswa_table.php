<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nim', 50)->primary();
            $table->string('id',50);
            $table->string('name', 150);
            $table->integer('semester');
            $table->string('prodi_id', 50);
            $table->string('jurusan_id', 50);
            $table->timestamps();

            $table->foreign('id')->references('id')->on('users');
            $table->foreign('prodi_id')->references('id_prodi')->on('prodi');
            $table->foreign('jurusan_id')->references('id_jurusan')->on('jurusan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
};