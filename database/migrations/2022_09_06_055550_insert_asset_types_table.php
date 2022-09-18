<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertAssetTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $asset_type = \App\Models\AssetType::class;

        $asset_type::insert(
            [
                [
                    'type_name' => 'aset barang',
                ],
                [
                    'type_name' => 'aset bangunan',
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
        $asset_type = \App\Models\AssetType::class;

        $asset_type::query()->delete();
    }
}
