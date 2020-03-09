<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //constructor
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }


    //return the home view
    public function index()
    {
        return view('home');
    }
}
