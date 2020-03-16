<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    //one to many relation: user and support request
    public function user()
    {
        return $this->hasOne('App\User');
    }

    //one to many relation: challenge and support request
    public function challenge()
    {
        return $this->hasOne('App\Challenge');
    }
}
