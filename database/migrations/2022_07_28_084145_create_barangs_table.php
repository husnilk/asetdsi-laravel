<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {

            $table->increments('id_barang');
            $table->string('merk_barang');
            $table->string('keterangan');
            $table->string('no_aset');
            $table->date('tgl_perolehan');
            $table->string('asal_perolehan');
            $table->integer('harga_aset');
            $table->string('kondisi_aset');
            $table->string('foto');
            $table->integer('id_aset')->unsigned();
            $table->foreign('id_aset')->references('id_aset')->on('aset')
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
        Schema::dropIfExists('barang');
    }
}
