<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan', function (Blueprint $table) {
            $table->increments('id');
            $table->date('loan_date');
            $table->string('loan_description');
            $table->time('loan_time');
            
            
            $table->integer('mahasiswa_id')->unsigned();
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('pic_id')->unsigned();
            $table->foreign('pic_id')->references('id')->on('person_in_charge')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('loan');
    }
}
