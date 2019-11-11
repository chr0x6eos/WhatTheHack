<?php

use Illuminate\Database\Seeder;
use App\Challenge;


class ChallengesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 1; $i <= 10; $i++)
        {
            $challenge = new Challenge();
            $challenge->name = "Challenge" . $i;
            $challenge->description = $faker->text;
            if($i % 2 == 0) {
                $challenge->difficulty = "easy allah";
            }
            else
            {
                $challenge->difficulty = "hard unnormal ey";
            }
            $challenge->author = $faker->name;
            $challenge->imageID = $faker->bankAccountNumber;
            $challenge->attachments = "/var/data/somedata.txt";
            $challenge->save();
        }
    }
}
