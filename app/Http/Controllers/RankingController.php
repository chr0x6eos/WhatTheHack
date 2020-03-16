<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RankingController extends Controller
{
    //get a list of all users, sorted by their points
    public function index()
    {
        try
        {
            $users = User::all();
            $currentUser = Auth::user();
            $sorted = collect($users)->sortBy('points', 1, true);
            $ranked = array();
            $rank = 1;

            foreach ($sorted as $value)
            {
                $ranked[$rank] = $value;
                $rank++;
            }
        }
        catch (Exception $ex)
        {
            return redirect()->route('home')->withErrors('Error occurred: ' . $ex->getMessage());
        }
        return view('ranking.ranking')->with(['ranked' => $ranked, 'currentUser' => $currentUser]);
    }

    //get a list of the top 5 users
    static function getTopFive()
    {
        try
        {
            $users = User::all();
            $sorted = collect($users)->sortBy('points', 1, true);
            $ranked = array();
            $rank = 1;

            foreach($sorted as $value)
            {
                $ranked[$rank] = $value;
                $rank++;
                if($rank > 5)
                {
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
            return redirect()->route('home')->withErrors($ex->getMessage());
        }
        return view('home')->with('ranked', $ranked);
    }

    //user ranking of a specific classroom
    public function classroomRanking()
    {
        try
        {
            $currentUser = Auth::user();
            $classrooms = $currentUser->classrooms;
        }
        catch(Exception $ex)
        {
            return redirect()->route('home')->withErrors($ex->getMessage());
        }
        return view('ranking.classroomRanking')->with(['classrooms' => $classrooms, 'currentUser' => $currentUser]);
    }
}
