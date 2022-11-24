<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Editproposal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_maintenence_asset', function (Blueprint $table) {
            $table->dropForeign(['inventory_item_id']);
            $table->dropColumn('inventory_item_id');
        });

        Schema::table('request_maintenence_asset', function (Blueprint $table) {
            $table->integer('inventory_item_id')->unsigned()->nullable();
            $table->foreign('inventory_item_id')->references('id')->on('inventory_item')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('building_id')->unsigned()->nullable();
            $table->foreign('building_id')->references('id')->on('building')->onDelete('cascade')->onUpdate('cascade');

            $table->string('status_mt');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_maintenence_asset', function (Blueprint $table) {
            $table->integer('inventory_item_id')->unsigned();
            $table->foreign('inventory_item_id')->references('id')->on('inventory_item')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('request_maintenence_asset', function (Blueprint $table){
            $table->dropColumn('building_id');
            $table->dropColumn('status_mt');

        });
    }
}
