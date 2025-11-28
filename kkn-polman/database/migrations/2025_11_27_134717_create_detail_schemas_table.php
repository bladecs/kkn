<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_schemas', function (Blueprint $table) {
            $table->string('id_detail_schema', 50)->primary();
            $table->string('schema_id', 50);
            $table->string('kategori_id', 50);
            $table->dateTime('tgl_mulai');
            $table->dateTime('tgl_selesai');
            $table->timestamps();

            $table->foreign('schema_id')->references('id_schema')->on('schemas');
            $table->foreign('kategori_id')->references('id_kategori')->on('kategori_schema');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_schemas');
    }
};