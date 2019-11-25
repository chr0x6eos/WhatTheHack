<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Challenge extends Model
{
    //Check if inputted difficulty is valid
    public function validDifficulty($difficulty)
    {
        $validDiffs = ['tatü','easy','medium','hard','insane'];
        if(in_array($difficulty,$validDiffs))
        {
            return true;
        }
        return false;
    }

    //Check if inputted category is valid
    public function validCategory($category)
    {
        $validCat = ['pwn','web','forensic','reversing','crypto','misc'];
        if(in_array($category,$validCat))
        {
            return true;
        }
        return false;
    }
}
