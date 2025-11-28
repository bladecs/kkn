<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kelompok_kkn', function (Blueprint $table) {
            $table->string('id_kelompok', 50)->primary();
            $table->string('pembimbing', 150);
            $table->string('created_by', 50);
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelompok_kkn');
    }
};