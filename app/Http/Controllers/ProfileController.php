<?php

namespace App\Http\Controllers;

use App\User;
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

        $user = Auth::user();
        return view('auth.passwords.change')->with('user', $user);
    }

    public function changePW(Request $request){

        $this->validate($request,
            [
                'current-password' => 'required|max:50',
                'password' => 'required|max:50',
                'confirm-password' => 'required|max:50'
            ]
        );

        $user = Auth::user();

        if($user == null){
            return redirect()->route('home')
                ->withErrors('User not found! Please log in!');
        }
        else{
            try{
                $user->password = $request->password;
                $user->save();
            }
            catch (Exception $ex){
                return redirect()->route('profile.show')
                    ->withErrors('Cannot change password!');
            }
            return redirect()->route('home');
        }
    }

    public function deleteAccount($id){
        $user = User::find($id);
        if ($user != null) {
            $user->delete();
            return redirect()->route('home');
        }
        else {
            redirect()->route('profile.show')
                ->withErrors('Not able to delete account!');
        }
    }
}
