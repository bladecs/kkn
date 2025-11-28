<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lokasi_kkn', function (Blueprint $table) {
            $table->string('id_lokasi', 50)->primary();
            $table->string('nama_lokasi', 150);
            $table->text('alamat');
            $table->string('kota', 100);
            $table->string('provinsi', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lokasi_kkn');
    }
};