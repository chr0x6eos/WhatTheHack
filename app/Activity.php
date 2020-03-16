<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'challenge_user';

    //relation between challenge and user
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    //relation between challenge and user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //get the last solved challenges, return a list of activities
    static function latest($limit = null)
    {
        $activities = array();
        $result = null;

        if($limit == null)
        {
            $result = Activity::orderby('created_at', 'desc')
                ->get();
        }
        else
        {
            $result = Activity::orderby('created_at', 'desc')
                ->get()
                ->take($limit);
        }

        foreach ($result as $item)
        {
            $user = User::find($item->user_id);
            $challenge = Challenge::find($item->challenge_id);
            $timestamp = $item->created_at;
            $activities[] = $user->username . ' solved ' . $challenge->name . ' on the ' . date('d.m', strtotime($timestamp)) . ' at ' . date('H:i:s', strtotime($timestamp));
        }
        return $activities;
    }


}
