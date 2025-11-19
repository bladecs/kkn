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
        Schema::create('project', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nim')->nullable();
            $table->string('nip')->nullable();
            $table->string('judul_project');
            $table->text('deskripsi_project');
            $table->string('lokasi');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('jalan');
            $table->string('alamat')->nullable();
            $table->string('proposal_kkn_path')->nullable();
            $table->string('rab_kkn_path')->nullable();
            $table->string('penyetuju')->nullable();
            $table->string('status')->default('pending');
            $table->integer('jumlah_anggota')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project');
    }
};
