<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Activity extends Model
{
    protected $table = 'challenge_user';

    public function challenge() {
        return $this->belongsTo(Challenge::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    static function latest($limit){
        $activities = array();
       $result= Activity::orderby('created_at','desc')
           ->get()
           ->take($limit);
       foreach ($result as $item){
           $user = User::find($item->user_id);
           $challenge=Challenge::find($item->challenge_id);
           $timestamp=$item->created_at;
           $activities[]=$user->username.' solved '.$challenge->name.' at '.date('d.m h:i',strtotime($timestamp));
       }
       return $activities;
    }
}
