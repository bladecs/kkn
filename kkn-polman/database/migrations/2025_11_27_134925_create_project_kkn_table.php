<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('project_kkn', function (Blueprint $table) {
            $table->string('id_project', 50)->primary();
            $table->string('judul', 255);
            $table->text('deskripsi');
            $table->string('lokasi_id', 50);
            $table->string('pengaju', 150);
            $table->string('status', 50);
            $table->string('approved_by', 50)->nullable();
            $table->timestamps();

            $table->foreign('approved_by')->references('id')->on('users');
            $table->foreign('lokasi_id')->references('id_lokasi')->on('lokasi_kkn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_kkn');
    }
};