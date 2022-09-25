<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetLoanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_loan_detail', function (Blueprint $table) {
            $table->integer('inventory_item_id')->unsigned();
            $table->integer('loan_id')->unsigned();

            $table->primary(['inventory_item_id', 'loan_id']);
            $table->foreign('inventory_item_id')->references('inventory_item_id')->on('inventory_item')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('loan_id')->references('loan_id')->on('loan')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('return_id')->unsigned();
            $table->foreign('return_id')->references('return_id')->on('returns')->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('asset_loan_detail');
    }
}
