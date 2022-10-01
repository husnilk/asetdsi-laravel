<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->increments('id');   // FK - (id_mahasiswa) peminjaman & pengadaan
            $table->string('status');

            $table->integer('ad_id')->unsigned();
            $table->foreign('ad_id')->references('id')->on('asset_loan_detail')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('bd_id')->unsigned();
            $table->foreign('bd_id')->references('id')->on('building_loan_detail')->onDelete('cascade')->onUpdate('cascade');


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
        Schema::dropIfExists('returns');
    }
}
