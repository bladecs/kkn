<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schemas', function (Blueprint $table) {
            $table->string('id_schema', 50)->primary();
            $table->string('approved_by', 50)->nullable();
            $table->string('created_by', 50);
            $table->timestamps();

            $table->foreign('approved_by')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('schemas');
    }
};