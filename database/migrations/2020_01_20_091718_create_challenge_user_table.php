<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            //reference to users table
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            //reference to challenge table
            $table->bigInteger('challenge_id')->unsigned();
            $table->foreign('challenge_id')
                ->references('id')
                ->on('challenges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challenge_user');
    }
}
