<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //IMPORTANT: ALWAYS NEEDS TO BE RUN IF DB IS REFRESHED
        $this->call(LevelTableSeeder::class); //Add levels to DB

        //Add test data
        $this->call(ChallengesTableSeeder::class); //Add test challenges to DB
        $this->call(UsersTableSeeder::class); //Add test users to DB
        $this->call(ClassroomTableSeeder::class);

        $this->call(ShowCaseSeeder::class);

        //$this->call(DeploymentTableSeeder::class);

    }
}
