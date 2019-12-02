<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table)
        {
            $table->bigIncrements('id');

            $table->string('name',255); //Name of the challenge
            $table->text('description'); //Challenge description
            $table->string('difficulty',255); //Difficulty of the challenge
            $table->string('author',255); //Author of the challenge
            $table->boolean('active')->default(true); //If the challenge is active
            $table->text('targetSolution')->nullable(); //Feasible solution for the challenge
            $table->string('imageID',32)->nullable(); //Docker-Image ID
            $table->string('attachments',255)->nullable(); //Attachments

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
        Schema::dropIfExists('challenges');
    }
}
