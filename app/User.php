<?php

namespace App;

use Faker\Provider\DateTime;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use function Sodium\add;

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

    //check if the user is already verified
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

    //function that is used for the relation between users and challenges
    public function challenges()
    {
        return $this
            ->belongsToMany('App\Challenge')
            ->withTimestamps();
    }

    public function challengeWithTimestamps()
    {
        return $this
            ->belongsToMany('App\Challenge')
            ->withPivot('created_at');

    }

    //check if a specific user is allowed to do a challenge
    public function hasChallenge($id)
    {
        foreach (Auth::user()->classrooms as $c)
        {
            foreach ($c->challenges as $challenge)
            {
                if ($challenge->id == $id)
                {
                    return true;
                }
            }
        }
        return false;
    }

    //relation between classrooms and users
    public function classrooms()
    {
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

    //get admin
    public static function getAdmin()
    {
        return User::where('userrole', 'admin')->first();
    }

    //get username
    public static function getUser($username)
    {
        return User::where('username', $username)->first();
    }

    //get a number of all active users
    static function countActiveUsers()
    {
        $counter = 0;
        $users = User::all();
        foreach ($users as $user)
        {
            if ($user->active == 1)
            {
                $counter++;
            }
        }
        return $counter;
    }

    //get a number of all disabled users
    static function countDisabledUsers()
    {
        $counter = 0;
        $users = User::all();
        foreach ($users as $user)
        {
            if ($user->active == 0)
            {
                $counter++;
            }
        }
        return $counter;
    }

    //check if a specific challenge has already been done
    public function solvedChallenge($id)
    {
        foreach ($this->challenges as $challenge)
        {
            if ($challenge->id == $id)
                return true;
        }
        return false;
    }

    //calculate a level for the user
    static function calculateLevel($points)
    {
        $levels = Level::all();
        $userLevel = "";

        foreach($levels as $l)
        {
            if($points >= $l->levelFrom && $points <= $l->levelTo)
            {
                $userLevel = $l->level;
            }
        }
        return $userLevel;
    }

    //with the calculated level, get a user rank
    static function calculateRank($points
    ){
        $levels = Level::all();
        $userLevel = "";

        foreach($levels as $l)
        {
            if($points >= $l->levelFrom && $points <= $l->levelTo)
            {
                $userLevel = $l->levelName;
            }
        }
        return $userLevel;
    }

    //calculate the min value for the progress
    static function calculateProgress1($points){
        $levels = Level::all();
        $userLevel = "";

        foreach($levels as $l)
        {
            if($points >= $l->levelFrom && $points <= $l->levelTo)
            {
                $currentPoints = $points - $l->levelFrom;
                $currentPoints = ceil($currentPoints);
                $userLevel = $currentPoints;
            }
        }
        return $userLevel;
    }

    //calculate the max value for the progress
    static function calculateProgress2($points)
    {
        $levels = Level::all();
        $neededPoints = 0;

        foreach($levels as $l)
        {
            if($points >= $l->levelFrom && $points <= $l->levelTo)
            {
                $neededPoints = $l->levelTo - $l->levelFrom;
                $neededPoints = ceil($neededPoints);
            }
        }
        return $neededPoints;
    }

    public function progress($cat,$id)
    {
        $user = User::findorFail($id);
        $result = [];
        $count = 0;
        //get the date when the user was created to get a point zero
        $dateOld = $user->created_at->format('Y-m-d');
        //add it to the result array
        array_push($result,$pointZero = array('label'=>$dateOld, 'y'=>$count));
       //get all challenges a user has solved with the timestamps from the pivot table
        foreach ($user->challengeWithTimestamps as $c)
        {
            if($c->category == $cat)
            {
                //get the date of the first entry
                $dateNew = $c['pivot']->created_at->format('Y-m-d');
                //get the difference between the two dates in days
                $days = (strtotime($dateNew)-strtotime($dateOld))/(60*60*24);
                //add a point for every day between the two dates
                for($i = 1; $i < $days; $i++ )
                {
                    $label = array('label'=>date('Y-m-d', strtotime($dateOld. '+ '.$i.' days')),'y'=>$count);
                    array_push($result,$label);
                }
                $count += $c->getPoints();
                $label = array('label'=>$c['pivot']->created_at->format('Y-m-d'), 'y'=>$count);
                array_push($result,$label);
                //set a new old date
                $dateOld = $dateNew;
            }
        }
        return $result;
    }
}
