<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_id'); //id_pengirim
            $table->string('sender'); //jenis_pengirim(mahasiswa/pj)
            $table->integer('receiver_id')->nullable();
            $table->string('receiver'); //penerima(admin/pj) 
            $table->text('message');
            $table->integer('object_type_id'); 
            $table->string('object_type'); 
            $table->timestamp('read_at')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
