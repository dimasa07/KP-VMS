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
        Schema::create('akun', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('user');
            $table->enum('role', ['TAMU', 'ADMIN', 'FRONT OFFICE']);
            //$table->enum('status', ['AKTIF', 'BELUM AKTIF']);
            $table->string('username')->unique();
            $table->string('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akun');
    }
};
