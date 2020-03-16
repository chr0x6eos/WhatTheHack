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
        User::create(
            [
                'username' => 'Admin',
                'email' => 'email.whatthehack@gmail.com',
                'password' => Hash::make('admin'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'admin',
                'active' => true
            ]
        )->save();

        //Create teacher user
        User::create(
            [
                'username' => 'Teacher',
                'email' => 'teacher@whatthehack.htl',
                'password' => Hash::make('teacher'),
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
                'password' => Hash::make('student'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'TaTü',
                'email' => 'tatü@whatthehack.htl',
                'password' => Hash::make('tatü2020'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'DaWoschbar',
                'email' => 'woschbar@whatthehack.htl',
                'password' => Hash::make('dawoschbar'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'Chronoros',
                'email' => 'chronoros@whatthehack.htl',
                'password' => Hash::make('P@ssw0rd'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'Buschuschnig',
                'email' => 'buschuschnig@whatthehack.htl',
                'password' => Hash::make('buschuschnig'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'Rüschhacker',
                'email' => 'rhacker@whatthehack.htl',
                'password' => Hash::make('rhacker'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'sandmann',
                'email' => 'sandmann@whatthehack.htl',
                'password' => Hash::make('sandmann'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'Oschta',
                'email' => 'oschta@whatthehack.htl',
                'password' => Hash::make('oschta'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'Hehn',
                'email' => 'hehn@whatthehack.htl',
                'password' => Hash::make('hehn'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();

        User::create(
            [
                'username' => 'Prast',
                'email' => 'prast@whatthehack.htl',
                'password' => Hash::make('prast'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'active' => true
            ]
        )->save();
    }
}
