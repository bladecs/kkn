<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_logbook', function (Blueprint $table) {
            $table->string('id_detail_logbook', 50)->primary();
            $table->string('logbook_id', 50);
            $table->string('nama_kegiatan', 255);
            $table->string('kategori_id', 50);
            $table->text('deskripsi_kegiatan');
            $table->integer('jumlah_waktu');
            $table->timestamps();

            $table->foreign('logbook_id')->references('id_logbook')->on('logbook_kegiatan');
            $table->foreign('kategori_id')->references('id_kategori')->on('kategori_kegiatan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_logbook');
    }
};