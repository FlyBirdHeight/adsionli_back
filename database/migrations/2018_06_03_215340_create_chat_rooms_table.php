<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('user_count')->default(0);
            $table->integer('max_user_count')->default(2000);
            $table->timestamps();
        });
        Schema::create('user_chatRoom',function (Blueprint $table){
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('chatRoom_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('chatRoom_id')->references('id')->on('chat_rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_rooms');
    }
}
