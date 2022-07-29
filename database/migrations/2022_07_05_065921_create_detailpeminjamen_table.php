<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailpeminjamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->integer('id_aset')->unsigned();
            $table->integer('id_peminjaman')->unsigned();

            $table->primary(['id_aset','id_peminjaman']);
            $table->foreign('id_aset')->references('id_aset')->on('aset')->onDelete('cascade')->onUpdate('cascade');;
            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjaman')->onDelete('cascade')->onUpdate('cascade');;
            $table->string('status');
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
        Schema::dropIfExists('detailpeminjamen');
    }
}
