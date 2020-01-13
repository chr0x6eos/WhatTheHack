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
            $sorted = collect($users)->sortBy('overallPoints', 1, true);
        }
        catch (Exception $ex)
        {
            return redirect('subpages.ranking')->withErrors("No DB connection could be established!");
        }

        return view('subpages.ranking')->with('sorted', $sorted);
    }
}
