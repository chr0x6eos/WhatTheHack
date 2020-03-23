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
        //Create teacher user
        User::create(
            [
                'username' => 'Teacher',
                'email' => 'teacher@whatthehack.htl',
                'password' => Hash::make(env('PW_TEACHER')),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'teacher',
                'active' => true
            ]
        )->save();

        //Create student user
        User::create(
            [
                'username' => 'Student',
                'email' => 'student@whatthehack.htl',
                'password' => Hash::make(env('PW_STUDENT')),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'TaTü',
                'email' => 'tatü@whatthehack.htl',
                'password' => Hash::make(env('PW_USER_1')),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'DaWoschbar',
                'email' => 'woschbar@whatthehack.htl',
                'password' => Hash::make(env('PW_USER_2')),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'Chronoros',
                'email' => 'chronoros@whatthehack.htl',
                'password' => Hash::make(env('PW_USER_3')),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'Buschuschnig',
                'email' => 'buschuschnig@whatthehack.htl',
                'password' => Hash::make(env('PW_USER_4')),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'Rüschhacker',
                'email' => 'rhacker@whatthehack.htl',
                'password' => Hash::make(env('PW_USER_5')),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'sandmann',
                'email' => 'sandmann@whatthehack.htl',
                'password' => Hash::make(env('PW_USER_6')),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'Oschta',
                'email' => 'oschta@whatthehack.htl',
                'password' => Hash::make(env('PW_USER_7')),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'Hehn',
                'email' => 'hehn@whatthehack.htl',
                'password' => Hash::make(env('PW_USER_8')),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'Prast',
                'email' => 'prast@whatthehack.htl',
                'password' => Hash::make(env('PW_USER_9')),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();
    }
}
