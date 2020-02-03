<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Challenge extends Model
{
    private $validDiffs = array(
        'tatu' => 5,
        'easy' => 10,
        'medium' => 25,
        'hard' => 50,
        'insane' => 100);

    // Check if inputted difficulty is valid
    public function validDifficulty($difficulty)
    {
        if(array_key_exists($difficulty,$this->validDiffs))
        {
            return true;
        }
        return false;
    }

    // Get points for difficulty
    public function getPoints()
    {
        if($this->validDifficulty($this->difficulty))
        {
            //Return points for the difficulty
            return $this->validDiffs[$this->difficulty];
        }
    }

    // Check if inputted category is valid
    public function validCategory($category)
    {
        $validCat = ['pwn','web','forensic','reverse-engineering','cryptography','miscellaneous'];
        if(in_array($category, $validCat))
        {
            return true;
        }
        return false;
    }

    public function challengeUsers(){
        return $this
            ->belongsToMany('App\User')
            ->withTimestamps();
    }

    public function supportrequest()
    {
        return $this->hasMany('App\SupportRequest');
    }

    public function solves($id)
    {
        return count($this->challengeUsers()->get());
    }

    static function countActiveChallenges()
    {
        $challenges = Challenge::all();
        $counter = 0;
        foreach ($challenges as $challenge){
            if($challenge->active == 1){
                $counter++;
            }
        }
        return $counter;
    }

    static function countDisabledChallenges()
    {
        $challenges = Challenge::all();
        $counter = 0;
        foreach ($challenges as $challenge){
            if(!$challenge->active){
                $counter++;
            }
        }
        return $counter;
    }
}
