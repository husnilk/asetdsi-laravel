<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->increments('inventory_id');
            $table->string('inventory_brand');
            $table->string('inventory_code')->unique();
            $table->string('condition');
            $table->string('available');
            $table->string('photo')->nullable();;
            $table->integer('asset_id')->unsigned();
            $table->foreign('asset_id')->references('asset_id')->on('asset')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('inventory');
    }
}
