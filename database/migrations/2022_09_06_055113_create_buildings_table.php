<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building', function (Blueprint $table) {
            $table->increments('building_id');
            $table->string('building_name');
            $table->string('building_code')->unique();
            $table->string('condition');
            $table->string('available');
            $table->string('photo')->nullable();;
            $table->integer('asset_id')->unsigned();
            $table->foreign('asset_id')->references('asset_id')->on('asset')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('pic_id')->unsigned();
            $table->foreign('pic_id')->references('pic_id')->on('person_in_charge')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('building');
    }
}
