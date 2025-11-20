<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengelompokan', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nip');
            $table->string('id_lokasi');
            $table->string('id_project');
            $table->string('nama_kelompok');
            $table->integer('jumlah_anggota');
            $table->string('koordinator');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengelompokan');
    }
};
