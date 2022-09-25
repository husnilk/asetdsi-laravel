<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_item', function (Blueprint $table) {
            $table->increments('inventory_item_id');
            $table->string('item_code')->unique();
            $table->string('condition');
            $table->string('available');
            $table->integer('inventory_id')->unsigned();
            $table->foreign('inventory_id')->references('inventory_id')->on('inventory')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('location_id')->on('asset_location')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('inventory_item');
    }
}
