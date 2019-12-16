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
                'email_verified_at' => now()->timestamp,
                'userrole' => 'admin',
                'active' => true
            ]
        );
        $admin->save();

        //Create student user
        $student = User::create(
            [
                'username' => 'Student',
                'email' => 'student@whatthehack.htl',
                'password' => Hash::make('student'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        );
        $student->save();

        $student2 = User::create(
            [
                'username' => 'Heins',
                'email' => 'heins@whatthehack.htl',
                'password' => Hash::make('student'),
                'userrole' => 'student',
                'active' => true
            ]
        );
        $student2->save();

        $student3 = User::create(
            [
                'username' => 'Student3',
                'email' => 'student3@whatthehack.htl',
                'password' => Hash::make('student3'),
                'userrole' => 'student',
                'active' => true
            ]
        );
        $student3->save();

        $student4 = User::create(
            [
                'username' => 'Student4',
                'email' => 'student4@whatthehack.htl',
                'password' => Hash::make('student4'),
                'userrole' => 'student',
                'active' => true
            ]
        );
        $student4->save();

        $student5 = User::create(
            [
                'username' => 'Student5',
                'email' => 'student5@whatthehack.htl',
                'password' => Hash::make('student5'),
                'userrole' => 'student',
                'active' => true
            ]
        );
        $student5->save();

        $student6 = User::create(
            [
                'username' => 'Student6',
                'email' => 'student6@whatthehack.htl',
                'password' => Hash::make('student6'),
                'userrole' => 'student',
                'active' => true
            ]
        );
        $student6->save();

        $student7 = User::create(
            [
                'username' => 'Student7',
                'email' => 'studen7t@whatthehack.htl',
                'password' => Hash::make('student7'),
                'userrole' => 'student',
                'active' => true
            ]
        );
        $student7->save();
        //Create teacher user
        $teacher = User::create(
            [
                'username' => 'Teacher',
                'email' => 'teacher@whatthehack.htl',
                'password' => Hash::make('teacher'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'teacher',
                'active' => true
            ]
        );
        $teacher->save();
    }
}
