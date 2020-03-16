<?php

use Illuminate\Database\Seeder;
use App\User;

class AdminUserSeeder extends Seeder
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
    }
}
