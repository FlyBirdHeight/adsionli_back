<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuPo1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_po1s', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("imgId");
            $table->string("dishName");
            $table->string("dishIntro");
            $table->integer("likeNum");
            $table->integer("commentNum");
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
        Schema::dropIfExists('menu_po1s');
    }
}
