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
        $this->call(AdminUserSeeder::class);

        //Add test data
        $this->call(ChallengesTableSeeder::class); //Add test challenges to DB
        $this->call(UsersTableSeeder::class); //Add test users to DB
        $this->call(ShowCaseSeeder::class); //Add showcase users, classrooms and solve challenges
        $this->call(ClassroomTableSeeder::class); //Add WTH classroom

        //$this->call(DeploymentTableSeeder::class);
    }
}
