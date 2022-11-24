<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tambahstatuspermintaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_proposal_asset', function (Blueprint $table) {
            $table->string('status_pr');
        });

        Schema::table('asset_loan_detail', function (Blueprint $table) {
            $table->string('status_pj');
        });

        Schema::table('building_loan_detail', function (Blueprint $table) {
            $table->string('status_pj');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('request_proposal_asset', function (Blueprint $table){
            $table->dropColumn('status_pr');
        });

        Schema::table('asset_loan_detail', function (Blueprint $table) {
            $table->dropColumn('status_pj');
        });

        Schema::table('building_loan_detail', function (Blueprint $table) {
            $table->dropColumn('status_pj');
        });
    }
}
