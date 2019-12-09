<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    public function users()
    {
        return $this
            ->belongsToMany('App\User')
            ->withTimestamps();
    }

    public function challenges()
    {
        return $this
            ->belongsToMany('App\Challenge')
            ->withTimestamps();
    }

    public function getMembers($id){
       foreach ($this->users as $u){
           if($u->id == $id)
               return true;
       }
        return false;
    }
}
