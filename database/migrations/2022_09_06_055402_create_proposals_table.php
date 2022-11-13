<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('proposal_description')->nullable();
            $table->string('status');

            $table->integer('admins_id')->unsigned()->nullable();
            $table->foreign('admins_id')->nullable()->references('id')->on('admins')->onUpdate('cascade')->onDelete('cascade');
            
            $table->integer('mahasiswa_id')->unsigned()->nullable();
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('pic_id')->unsigned()->nullable();
            $table->foreign('pic_id')->references('id')->on('person_in_charge')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('proposal_type')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('proposal');
    }
}
