<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestMaintenenceAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_maintenence_asset', function (Blueprint $table) {
    
            $table->increments('req_maintenence_id');
            $table->string('problem_description');
            $table->integer('proposal_id')->unsigned();
            $table->foreign('proposal_id')->references('proposal_id')->on('proposal')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('inventory_id')->unsigned();
            $table->foreign('inventory_id')->references('inventory_id')->on('inventory')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('request_maintenence_asset');
    }
}
