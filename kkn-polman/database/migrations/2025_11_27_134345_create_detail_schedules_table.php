<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_schedules', function (Blueprint $table) {
            $table->string('id_detail_schedule', 50)->primary();
            $table->string('schedule_id', 50);
            $table->string('kloter', 50);
            $table->string('kode_kegiatan', 50);
            $table->text('deskripsi');
            $table->dateTime('tgl_mulai');
            $table->dateTime('tgl_selesai');
            $table->timestamps();

            $table->foreign('schedule_id')->references('id_kegiatan')->on('schedules');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_schedules');
    }
};