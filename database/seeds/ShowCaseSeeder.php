<?php

use Illuminate\Database\Seeder;
use App\Classroom;
use App\User;
use App\Challenge;

class ShowCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try
        {
            $this->createUsers();
            $this->setupClassrooms();
            $this->genSolves();
        }
        catch (Exception $ex) {}
    }

    //Create additional users for showcase
    private function createUsers()
    {
        User::create(
            [
                'username' => 'RAM',
                'email' => 'ram@htl-villach.at',
                'password' => Hash::make('ram'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'teacher',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'GAM',
                'email' => 'gam@htl-villach.at',
                'password' => Hash::make('gam'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'teacher',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'WOH',
                'email' => 'woh@htl-villach.at',
                'password' => Hash::make('woh'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'teacher',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'posseggs',
                'email' => 'posseggs@edu.htl-villach.at',
                'password' => Hash::make('posseggs'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'skiddie',
                'email' => 'skiddie@edu.htl-villach.at',
                'password' => Hash::make('skiddie'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => false
            ]
        )->save();
    }

    //Create users and classrooms
    private function setupClassrooms()
    {
        $u1 = User::getUser("posseggs");
        $u2 = User::getUser("RAM");
        $u3 = User::getUser("Chronoros");
        $u4 = User::getUser("Buschuschnig");
        $u5 = User::getUser("sandmann");

        $users = array($u1,$u2,$u3,$u4,$u5);
        Classroom::createClassroom("5AHITN", $users, true);
    }

    //Function to solve challenges
    private function solveChallenges($challenges, $u)
    {
        try
        {
            if ($challenges != null && sizeof($challenges) > 0)
            {
                foreach ($challenges as $c)
                {
                    //Check if valid challenge
                    if($c instanceof Challenge)
                    {
                        $c->solveChallenge($u);
                    }
                }
            }
        }
        catch (Exception $exception){}
    }

    //Solve a random amount of challenges
    private function solveRandom($u)
    {
        //Take a random number of challenges
        $random = rand(0,count(DB::table('challenges')->get()));

        $challenges = Challenge::inRandomOrder()->limit($random)->get();

        $this->solveChallenges($challenges, $u);
    }

    //Generate solves foreach user
    private function genSolves()
    {
        $users = User::all();
        foreach ($users as $u)
        {
            $this->solveRandom($u);
        }
    }
}
