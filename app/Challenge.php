<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Challenge extends Model
{
        //Check if current user has inputted role
    public function validDifficulty($difficulty)
    {
        $validDiffs = ['easy','medium','hard'];
        if(in_array($difficulty,$validDiffs))
        {
            return true;
        }
        return false;
    }

}
