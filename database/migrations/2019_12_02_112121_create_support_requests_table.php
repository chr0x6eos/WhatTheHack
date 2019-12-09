<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_requests', function (Blueprint $table) {
            $table->increments('id')->autoIncrement();
            $table->integer('challenge_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('subject');
            $table->longText('message');
            $table->boolean('solved')->default(false);

            //Relation to Challenge
            $table->foreign('challenge_id')
                ->references('id')
                ->on('challenges');

            //Relation to User
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

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
        Schema::dropIfExists('support_requests');
    }
}
