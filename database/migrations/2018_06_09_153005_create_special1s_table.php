<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecial1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special1s', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('imgId');
            $table->string('title');
            $table->string('content');
            $table->integer('commentNum');
            $table->integer('likeNum');
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
        Schema::dropIfExists('special1s');
    }
}
