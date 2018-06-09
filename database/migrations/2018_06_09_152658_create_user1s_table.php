<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUser1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user1s', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name');
            $table->string('user_passwork');
            $table->string('wechat_name');
            $table->string('wechat_openid');
            $table->string('qq_name');
            $table->string('qq_openid');
            $table->string('weibo_name');
            $table->string('weibo_openid');
            $table->string('image');
            $table->string('phone');
            $table->string('height');
            $table->string('weight');
            $table->string('sex');
            $table->string('birthday');
            $table->string('alterDate');
            $table->string('m_major');
            $table->string('m_class');
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
        Schema::dropIfExists('user1s');
    }
}
