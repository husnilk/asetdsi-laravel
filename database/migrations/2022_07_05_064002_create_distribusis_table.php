<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistribusisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribusi', function (Blueprint $table) {
            $table->increments('id_distribusi');
            $table->string('nama_barang');
            $table->string('pihak_pertama');
            $table->string('pihak_kedua');
            $table->integer('jumlah');
            $table->string('nomor_kontrak');
            $table->string('nama_kontrak');
            $table->date('tgl_kontrak');
            $table->integer('tahun_perolehan');
            $table->integer('id_aset')->unsigned();
            $table->foreign('id_aset')->references('id_aset')->on('aset')->onDelete('cascade')->onUpdate('cascade');;
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
        Schema::dropIfExists('distribusi');
    }
}
