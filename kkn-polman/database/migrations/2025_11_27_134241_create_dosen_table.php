<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->string('nip', 50)->primary();
            $table->string('name', 150);
            $table->string('prodi_id', 50)->nullable();
            $table->string('jurusan_id', 50)->nullable();
            $table->timestamps();

            $table->foreign('prodi_id')->references('id_prodi')->on('prodi');
            $table->foreign('jurusan_id')->references('id_jurusan')->on('jurusan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dosen');
    }
};