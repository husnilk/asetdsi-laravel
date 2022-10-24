<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertProposalTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $proposal_type = \App\Models\ProposalType::class;

        $proposal_type::insert(
            [
                [
                    'type_name' => 'pengusulan barang',
                ],
                [
                    'type_name' => 'pengusulan maintenence',
                ]

            ]
    );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $proposal_type = \App\Models\ProposalType::class;

        $proposal_type::query()->delete();
    }
}
