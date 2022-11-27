<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StatusFaculty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposal', function (Blueprint $table) {
            $table->string('status_confirm_faculty')->nullable();
        });

        Schema::table('request_proposal_asset', function (Blueprint $table) {
            $table->string('status_confirm_faculty')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proposal', function (Blueprint $table) {
            $table->dropColumn('status_confirm_faculty');
        });

        Schema::table('request_proposal_asset', function (Blueprint $table) {
            $table->dropColumn('status_confirm_faculty');
        });
    }
}
