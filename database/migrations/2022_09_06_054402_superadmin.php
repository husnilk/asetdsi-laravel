<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Superadmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $user = \App\Models\Admin::class;

        $user::create([
                'nip' => '',
                'name' => 'superadmin',
                'email' => 'superadmin@mail.com',
                'phone_number' => '082285265855',
                'username' => 'superadmin',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        $user = \App\Models\Admin::class;

        $user::where('name', 'superadmin')->delete();
    }
}
