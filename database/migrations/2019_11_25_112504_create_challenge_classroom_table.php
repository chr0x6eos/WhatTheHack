<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengeClassroomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_classroom', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('challenge_id')->unsigned();

            $table->bigInteger('classroom_id')->unsigned();
            $table->foreign('classroom_id')
                ->references('id')
                ->on('classrooms');

            $table->foreign('challenge_id')->references('id')->on('challenges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challenge_classroom');
    }
}
