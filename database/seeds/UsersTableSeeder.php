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
                'email' => 'email.whatthehack@gmail.com',
                'password' => Hash::make('admin'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'admin',
                'active' => true
            ]
        );
        $admin->save();

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

        //Create student user
        $student = User::create(
            [
                'username' => 'Student',
                'email' => 'student@whatthehack.htl',
                'password' => Hash::make('student'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'points' => 10,
                'active' => true
            ]
        );
        $student->save();

        $tatu = User::create(
            [
                'username' => 'TaTü',
                'email' => 'tatü@whatthehack.htl',
                'password' => Hash::make('tatü2020'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'points' => 0,
                'active' => true
            ]
        );
        $tatu->save();

        $ruehl = User::create(
            [
                'username' => 'Rühl',
                'email' => 'ruehl@whatthehack.htl',
                'password' => Hash::make('ruehl24'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'points' => 24,
                'active' => true
            ]
        );
        $ruehl->save();

        $woschbar = User::create(
            [
                'username' => 'DaWoschbar',
                'email' => 'woschbar@whatthehack.htl',
                'password' => Hash::make('dawoschbar'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'points' => 1,
                'active' => true
            ]
        );
        $woschbar->save();

        $chronoros = User::create(
            [
                'username' => 'Chronoros',
                'email' => 'chronoros@whatthehack.htl',
                'password' => Hash::make('chronoros'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'points' => 100,
                'active' => true
            ]
        );
        $chronoros->save();

        $busche = User::create(
            [
                'username' => 'Buschuschnig',
                'email' => 'buschuschnig@whatthehack.htl',
                'password' => Hash::make('buschuschnig'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'points' => 60,
                'active' => true
            ]
        );
        $busche->save();

        $rueschhacker = User::create(
            [
                'username' => 'Rüschhacker',
                'email' => 'rhacker@whatthehack.htl',
                'password' => Hash::make('rhacker'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'points' => 1000,
                'active' => true
            ]
        );
        $rueschhacker->save();

        $sandmann = User::create(
            [
                'username' => 'sandmann',
                'email' => 'sandmann@whatthehack.htl',
                'password' => Hash::make('sandmann'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'points' => 999,
                'active' => true
            ]
        );
        $sandmann->save();

        $oschta = User::create(
            [
                'username' => 'Oschta',
                'email' => 'oschta@whatthehack.htl',
                'password' => Hash::make('oschta'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'points' => 20,
                'active' => true
            ]
        );
        $oschta->save();

        $hehn = User::create(
            [
                'username' => 'Hehn',
                'email' => 'hehn@whatthehack.htl',
                'password' => Hash::make('hehn'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'points' => 10,
                'active' => true
            ]
        );
        $hehn->save();

        $prast = User::create(
            [
                'username' => 'Prast',
                'email' => 'prast@whatthehack.htl',
                'password' => Hash::make('prast'),
                'email_verified_at' => now()->timestamp,
                'userrole' => 'student',
                'points' => 20,
                'active' => true
            ]
        );
        $hehn->save();
    }
}
