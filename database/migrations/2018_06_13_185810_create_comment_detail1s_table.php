<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentDetail1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_detail1s', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickName')->default('');
            $table->string('userLogo');
            $table->string('content')->default('');
            $table->string('imgId')->default('');
            $table->integer('replyTotal')->default(0);
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
        Schema::dropIfExists('comment_detail1s');
    }
}
