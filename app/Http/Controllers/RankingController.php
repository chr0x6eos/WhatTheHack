<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RankingController extends Controller
{
    public function index()
    {
        try
        {
            $users = User::all();
            $currentUser = Auth::user();
            $sorted = collect($users)->sortBy('points', 1, true);
            $ranked = array();
            $rank = 1;

            foreach ($sorted as $value){
                $ranked[$rank] = $value;
                $rank++;
            }
        }
        catch (Exception $ex)
        {
            return redirect(route('home'))->withErrors($ex->getMessage());
        }
        return view('ranking.ranking')->with(['ranked' => $ranked, 'currentUser' => $currentUser]);
    }

    static function getTopFive()
    {
        try
        {
            $users = User::all();
            $sorted = collect($users)->sortBy('points', 1, true);
            $ranked = array();
            $rank = 1;
            foreach($sorted as $value) {
                $ranked[$rank] = $value ;
                $rank++;
                if($rank > 5){
                    break;
                }
            }

            //foreach ($sorted as $value){
            //    $ranked[$rank] = $value;
            //    $rank++;
            //}
        }
        catch (Exception $ex)
        {
            return redirect(route('home'))->withErrors($ex->getMessage());
        }
        return view('home')->with('ranked', $ranked);
    }

    public function classroomRanking()
    {
        try{
            $currentUser = Auth::user();
            $classrooms = $currentUser->classrooms;
        }
        catch(Exception $ex)
        {
            return redirect(route('home'))->withErrors($ex->getMessage());
        }
        return view('ranking.classroomRanking')->with(['classrooms' => $classrooms, 'currentUser' => $currentUser]);
    }
}
