<?php

use Illuminate\Database\Seeder;
use App\Deployment;

class DeploymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Deployment::create(
        [
            'name' => 'WTH_Kioptrix'
        ]
        )->save();
    }
}
