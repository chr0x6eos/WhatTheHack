<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create admin user
        $admin = User::create(
            [
                'username' => 'Admin',
                'email' => 'admin@whatthehack.htl',
                'password' => Hash::make('admin'),
                'userrole' => 'admin'
            ]
        );
        $admin->save();

        //Create student user
        $student = User::create(
            [
                'username' => 'Student',
                'email' => 'student@whatthehack.htl',
                'password' => Hash::make('student'),
                'userrole' => 'student'
            ]
        );
        $student->save();

        //Create teacher user
        $teacher = User::create(
            [
                'username' => 'Teacher',
                'email' => 'teacher@whatthehack.htl',
                'password' => Hash::make('teacher'),
                'userrole' => 'teacher'
            ]
        );
        $teacher->save();
    }
}
