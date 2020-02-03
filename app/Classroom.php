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

    public function getMembers($id)
    {
       foreach ($this->users as $u)
       {
           if($u->id == $id)
               return true;
       }
        return false;
    }

   public function getClassroomChallenges($id)
   {
        foreach ($this->challenges as $challenge)
        {
            if($challenge->id == $id)
                return true;
        }
        return false;
    }

    public function isOwner($id)
    {
        if($this->classroom_owner == $id)
            return true;
        return false;
    }

    public function getRankedUsers()
    {
        $users = $this->users;
        $ranked = array();
        $rank = 1;
        $sorted = collect($users)->sortBy('points', 1, true);
        foreach ($sorted as $value){
            $ranked[$rank] = $value;
            $rank++;
        }
        return $ranked;
    }

    static function countActiveClassrooms()
    {
        $classrooms = Classroom::all();
        $counter = 0;
        foreach ($classrooms as $classroom)
        {
            if($classroom->active == 1)
            {
                $counter++;
            }
        }
        return $counter;
    }

    static function countDisabledClassrooms()
    {
        $classrooms = Classroom::all();
        $counter = 0;
        foreach ($classrooms as $classroom)
        {
            if($classroom->active == 0)
            {
                $counter++;
            }
        }
        return $counter;
    }
}
