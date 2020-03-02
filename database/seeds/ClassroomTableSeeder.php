<?php

use App\Challenge;
use Illuminate\Database\Seeder;
use App\Classroom;
use App\User;

class ClassroomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->tatu();
    }

    private function createClassroom($name,$users)
    {
        $admin = User::getUser("Admin");

        $classroom = new Classroom();
        $classroom->classroom_name = $name;
        $classroom->classroom_owner = $admin->id;
        $classroom->save();

        //Creator of a classroom is automatically a member
        $classroom->users()->attach($admin->id);

        //Add specified users to classroom
        if (is_array($users))
        {
            foreach ($users as $user)
            {
                $classroom->users()->attach($user);
            }
        }

        //Add all challenges to classroom
        foreach (Challenge::all() as $c)
        {
            if($c->active == true)
                $classroom->challenges()->attach($c);
        }
    }

    private function tatu()
    {
        $tatu = User::getUser("TaTü");
        $student = User::getUser("Student");

        $users = array($tatu,$student);
        $this->createClassroom("Tatü",$users);
    }
}
