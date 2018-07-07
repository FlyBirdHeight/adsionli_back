<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMusicListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('music_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->default("");
            $table->string("path");
            $table->string("artist")->default("");
            $table->string("cover")->default("http://p53z0yfgy.bkt.clouddn.com/music.jpg");
            $table->string("theme")->default("#ffffff");
            $table->string("lrc")->default("");
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
        Schema::dropIfExists('music_lists');
    }
}
