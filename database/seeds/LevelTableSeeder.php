<?php

use Illuminate\Database\Seeder;
use App\Level;

class LevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levelRange = 50;
        $experienceValue = 0;
        $rankValue = 1;
        $rankNameCounter = 5;
        for($i = 0; $i < 25; $i++) {
            $level = new Level();
            $level->level = $rankValue;
            $level->levelFrom = $experienceValue;
            $experienceValue = $experienceValue + $levelRange;
            $level->levelTo = $experienceValue;
            $levelRange = $levelRange * 1.1;

            if($rankNameCounter == 0){
                $rankNameCounter = 5;
            }

            if($rankValue > 0 && $rankValue < 6){
                $level->levelName = "Bronze ".$rankNameCounter;
                $rankNameCounter--;
            }
            if($rankValue > 5 && $rankValue < 11){
                $level->levelName = "Silver ".$rankNameCounter;
                $rankNameCounter--;
            }
            if($rankValue > 10 && $rankValue < 16){
                $level->levelName = "Gold ".$rankNameCounter;
                $rankNameCounter--;
            }
            if($rankValue > 15 && $rankValue < 21){
                $level->levelName = "Platin ".$rankNameCounter;
                $rankNameCounter--;
            }
            if($rankValue > 20 && $rankValue <= 25){
                $level->levelName = "Diamond ".$rankNameCounter;
                $rankNameCounter--;
            }
            $level->save();
            $rankValue++;
        }
    }
}
