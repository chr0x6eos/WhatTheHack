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

    //relation between challenges and users
    public function challengeUsers(){
        return $this
            ->belongsToMany('App\User')
            ->withTimestamps();
    }

    //relation between support request and challenges
    public function supportrequest()
    {
        return $this->hasMany('App\SupportRequest');
    }

    //how often has a specific challenge been solved
    public function solves($id)
    {
        return count($this->challengeUsers()->get());
    }

    //how many challenges are active
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

    //how many challenges are disabled
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
