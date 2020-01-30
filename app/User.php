<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'userrole',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Check if the user object is assigned the requested role
    public function hasRole($role)
    {
        if ($this->userrole == $role)
            return true;
        else
            return false;
    }

    public function isVerified()
    {
        if (is_null($this->email_verified_at))
            return false;
        else
            return true;
    }
    //Check if current user is author of challenge
    public function isAuthor($author)
    {
        if ($this->username == $author)
        {
            return true;
        }
        return false;
    }

    public function challenges()
    {
        return $this
            ->belongsToMany('App\Challenge')
            ->withTimestamps();
    }

    public function hasChallenge($id){
        foreach (Auth::user()->classrooms as $c){
            foreach ($c->challenges as $challenge){
                if($challenge==$id){
                return true;
                }
            }
        }
        return false;
    }


    public function classrooms(){
        return $this
            ->belongsToMany('App\Classroom')
            ->withTimestamps();
    }

    //Add points to user and update db
    public function addPoints($points)
    {
        if ($points > 0)
        {
            $this->points += $points;
            $this->save();
        }
    }

    public function getAdmin()
    {
        return User::where('userrole', 'admin')->first();
    }

    static function countActiveUsers(){
        $counter = 0;
        $users = User::all();
        foreach ($users as $user){
            if ($user->active == 1){
                $counter++;
            }
        }
        return $counter;
    }
    static function countDisabledUsers(){
        $counter = 0;
        $users = User::all();
        foreach ($users as $user){
            if ($user->active == 0){
                $counter++;
            }
        }
        return $counter;
    }

    public function solvedChallenge($id){
        foreach ($this->challenges as $challenge){
            if ($challenge->id == $id)
                return true;
        }
        return false;
    }

    static function calculateLevel($points){
        $levels = Level::all();
        foreach($levels as $l){
            if($points >= $l->levelFrom && $points <= $l->levelTo){
                $userLevel = $l->level;
            }
        }
        return $userLevel;
    }
    static function calculateRank($points){
        $levels = Level::all();
        foreach($levels as $l){
            if($points >= $l->levelFrom && $points <= $l->levelTo){
                $userLevel = $l->levelName;
            }
        }
        return $userLevel;
    }

    static function calculateProgress1($points){
        $levels = Level::all();
        foreach($levels as $l){
            if($points >= $l->levelFrom && $points <= $l->levelTo){
                $currentpoints = $points - $l->levelFrom;
                $currentpoints = ceil($currentpoints);
                $userLevel = $currentpoints;
            }
        }
        return $userLevel;
    }

    static function calculateProgress2($points){
        $levels = Level::all();
        foreach($levels as $l){
            if($points >= $l->levelFrom && $points <= $l->levelTo){
                $neededpoints = $l->levelTo - $l->levelFrom;
                $neededpoints = ceil($neededpoints);
            }
        }
        return $neededpoints;
    }
}
