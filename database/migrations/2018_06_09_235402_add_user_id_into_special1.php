<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdIntoSpecial1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('special1s', function (Blueprint $table) {
            $table->integer('user_id');
        });
        Schema::table('user1s', function (Blueprint $table) {
            $table->integer('special_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('special1s', function (Blueprint $table) {
            //
        });
    }
}
