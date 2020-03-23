<?php

use Illuminate\Database\Seeder;
use App\Classroom;
use App\User;
use App\Challenge;


class ClassroomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->tatu();
        Classroom::createClassroom("What The Hack", User::all());
    }

    private function tatu()
    {
        $tatu = User::getUser("TaTü");
        $student = User::getUser("Student");

        $users = array($tatu, $student);
        Classroom::createClassroom("Tatü", $users);
    }
}
