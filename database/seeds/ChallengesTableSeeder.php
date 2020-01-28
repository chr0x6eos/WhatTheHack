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

        for ($i = 1; $i <= 20; $i++)
        {
            $challenge = new Challenge();
            $challenge->name = "Challenge" . $i;
            $challenge->description = $faker->text;
            if($i % 2 == 0)
            {
                $challenge->difficulty = "easy";
                $challenge->targetSolution = $faker->text;
                $challenge->category = "misc";
                $challenge->hint = $faker->text;
            }
            else if($i % 3 == 0)
            {
                $challenge->difficulty = "medium";
                $challenge->category = "web";
            }
            else
            {
                $challenge->difficulty = "hard";
                $challenge->targetSolution = $faker->text;
                $challenge->active=false;
                $challenge->hint = "You have to haxx0r the binary.";
                $challenge->category = "pwn";
            }

            $challenge->flag = "WTH{" . $faker->md5 . "}";
            $challenge->author = $faker->name;
            $challenge->imageID = $faker->bankAccountNumber;
            $challenge->save();
        }
    }
}
