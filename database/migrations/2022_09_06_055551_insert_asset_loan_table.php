<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertAssetLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $loan_type = \App\Models\LoanType::class;

        $loan_type::insert(
            [
                [
                    'type_name' => 'peminjaman barang',
                ],
                [
                    'type_name' => 'peminjaman bangunan',
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
        $loan_type = \App\Models\LoanType::class;

        $loan_type::query()->delete();
    }
}
