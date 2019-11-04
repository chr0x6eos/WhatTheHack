<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(){

        $user = Auth::user();

        if($user != null){
            return view('profile')->with('user', $user);
        }
        else{
            return view('auth.login');
        }
    }

    public function showChangePWForm(){
        return view('auth.passwords.reset');
    }
}
