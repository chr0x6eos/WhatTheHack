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



    public function isTeacher($userrole)
    {
        if ($userrole == 'teacher') {
            return true;
        }
        return false;
    }

    // Check if the user object is assigned the requested role
    public function hasRole($role)
    {
        if($this->userrole == $role)
        {
            return true;
        }
        else
            return false;
    }


    public function isAdmin($userrole){
        if($userrole=='admin'){
            return true;
        }
        else
            return false;
    }

    public function isStudent($userrole){
        if($userrole=='student'){
            return true;
        }
        else
            return false;
    }

    //Check if current user is author of challenge
    public function isAuthor($author)
    {
        if($this->username == $author)
        {
            return true;
        }
        return false;
    }

    public function hasChallenge($id){
        foreach (Auth::user()->classrooms as $c){
            foreach ($c->challenges as $challenge){
                if($challenge=$id){
                return true;
                }
            }
        }
        return false;
    }

    public function challenges(){
        return $this
            ->belongsToMany('App\Challenges')
            ->withTimestamps();
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
            //TODO: RENAME POINTS TO RIGHT NAME OF MODEL
            $this->points += $points;
            $this->save();
        }
    }

    public function getAdmin()
    {
        return User::where('userrole', 'admin')->first();
    }
}
