<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingLoanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_loan_detail', function (Blueprint $table) {
            $table->integer('building_id')->unsigned();
            $table->integer('loan_id')->unsigned();

            $table->primary(['building_id', 'loan_id']);
            $table->foreign('building_id')->references('id')->on('building')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('loan_id')->references('id')->on('loan')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('building_loan_detail');
    }
}
