<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DetailReturnAsset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('return_asset_detail', function (Blueprint $table) {
            $table->increments('id');   // FK - (id_mahasiswa) peminjaman & pengadaan
            $table->string('status');

            $table->integer('asset_loan_detail_id')->unsigned();
            $table->foreign('asset_loan_detail_id')->references('id')->on('asset_loan_detail')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('returns_id')->unsigned();
            $table->foreign('returns_id')->references('id')->on('returns')->onDelete('cascade')->onUpdate('cascade');
    


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
