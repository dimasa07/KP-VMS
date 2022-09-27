<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permintaan_bertamu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tamu')->unsigned();
            $table->integer('id_admin')->unsigned()->nullable();
            $table->integer('id_pegawai')->unsigned();
            $table->foreign('id_tamu')->references('id')->on('user');
            $table->foreign('id_admin')->references('id')->on('user');
            $table->foreign('id_pegawai')->references('id')->on('pegawai');
            $table->string('keperluan')->nullable();
            $table->dateTime('waktu_bertamu')->nullable();
            $table->enum('disetujui', ['YA', 'TIDAK'])->default('TIDAK');
            $table->string('pesan_ditolak')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permintaan_bertamu');
    }
};
