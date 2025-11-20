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
        Schema::create('pendaftaran_kkn', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique();
            $table->string('name');
            $tablea->string('id_pengelompokan');
            $table->decimal('ipk', 3, 2);
            $table->integer('sks');
            $table->integer('semester');
            $table->string('jurusan');
            $table->string('study_program');
            $table->string('ktm_path');
            $table->string('photo_path');
            $table->string('proposal_path');
            $table->string('rab_path')->nullable();
            $table->string('project_kkn')->nullable();
            $table->string('no_tlp')->nullable();
            $table->string('status_mhs');
            $table->string('status')->default('verifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_kkn');
    }
};
