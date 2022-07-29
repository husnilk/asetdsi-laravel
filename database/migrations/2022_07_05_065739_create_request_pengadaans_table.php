<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestPengadaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_pengadaan', function (Blueprint $table) {
            $table->increments('id_request');
            $table->string('nama_barang');
            $table->string('jumlah_barang');
            $table->integer('id_pengadaan')->unsigned();
            $table->foreign('id_pengadaan')->references('id_pengadaan')->on('pengadaan')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_pengadaan');
    }
}
