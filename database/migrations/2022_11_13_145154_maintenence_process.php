<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MaintenenceProcess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('migration_process', function (Blueprint $table) {
            $table->increments('id');   // FK - (id_mahasiswa) peminjaman & pengadaan
            $table->string('status');

            $table->integer('proposal_id')->unsigned();
            $table->foreign('proposal_id')->references('id')->on('loan')->onDelete('cascade')->onUpdate('cascade');
    


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
        Schema::dropIfExists('migration_process');
    }
}
