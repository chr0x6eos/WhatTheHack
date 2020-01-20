<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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
            return redirect('subpages.ranking')->withErrors("No DB connection could be established!");
        }

        return view('subpages.ranking')->with('ranked', $ranked);
    }
}
