<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan', function (Blueprint $table){
            $table->string('status')->nullable();

        });

        Schema::table('asset_loan_detail', function (Blueprint $table){
            $table->dropColumn('status');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('loan', function (Blueprint $table){
            $table->dropColumn('status');

        });

        Schema::table('asset_loan_detail', function (Blueprint $table){
            $table->string('status')->nullable();

        });
        
    }
}
