<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_pendaftaran_kkn', function (Blueprint $table) {
            $table->string('id_detail_pendaftaran', 50)->primary();
            $table->string('no_pendaftaran', 50);
            $table->string('kloter', 50);
            $table->dateTime('tgl');
            $table->integer('semester');
            $table->timestamps();

            $table->foreign('no_pendaftaran')->references('id_pendaftaran')->on('pendaftaran_kkn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_pendaftaran_kkn');
    }
};