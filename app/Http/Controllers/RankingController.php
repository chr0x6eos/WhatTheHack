<?php

namespace App\Http\Controllers;

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
        return view('ranking.ranking')->with('ranked', $ranked);
    }

    public function classroomRanking()
    {
        try{
            $user = Auth::user();
            $classrooms = $user->classrooms;
        }
        catch(Exception $ex)
        {
            return redirect(route('home'))->withErrors($ex->getMessage());
        }
        return view('ranking.classroomRanking')->with('classrooms', $classrooms);
    }
}
