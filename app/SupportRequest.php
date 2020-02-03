<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function challenge()
    {
        return $this->hasOne('App\Challenge');
    }
}
