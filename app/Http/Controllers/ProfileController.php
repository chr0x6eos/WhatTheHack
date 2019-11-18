<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            return view('profile.profile')->with('user', $user);
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
                'currentPassword' => 'required|max:50',
                'password' => 'required|max:50',
                'confirmPassword' => 'required|max:50'
            ]
        );

        $currentPW = $request->currentPassword;
        $password = $request->password;
        $confirmPassword = $request->confirmPassword;

        $user = Auth::user();

        if($user == null){
            return redirect()->route('auth.login')
                ->withErrors('User not found! Please log in!');
        }
        else{
            try{
                if(!Hash::check($currentPW, $user->password)){
                    return redirect()->route('profile.showChangePWForm')
                        ->withErrors('Wrong current password!');
                }
                elseif($password != $confirmPassword){
                    return redirect()->route('profile.showChangePWForm')
                        ->withErrors('Passwords do not match!');
                }
                else{
                    $request->user()->fill([
                        'password' => Hash::make($password)
                    ])->save();
                }
                return redirect()->route('profile.show')->with('success','Password changed!');
            }
            catch (Exception $ex){
                return redirect()->route('profile.show')
                    ->withErrors('Cannot change password!');
            }
        }
    }

    public function showChangeEMForm(){

        $user = Auth::user();
        return view('profile.changeEM')->with('user', $user);
    }

    public function changeEM(Request $request){
        $this->validate($request,
            [
                'email' => 'required|max:100',
                'newEmail' => 'required|max:100',
            ]
        );

        $user = Auth::user();
        $email = $request->email;
        $newEmail = $request->newEmail;

        if($user == null){
            return redirect()->route('auth.login')
                ->withErrors('User not found! Please log in!');
        }
        else{
            try{
                if($email != $user->email){
                    return redirect()->route('profile.showChangeEMForm')
                        ->withErrors('Wrong current E-Mail!');
                }
                else{
                    $request->user()->fill([
                        'email' => $newEmail
                    ])->save();
                }
                return redirect()->route('profile.show')->with('success','E-Mail changed!');
            }
            catch (Exception $ex){
                return redirect()->route('profile.show')
                    ->withErrors('Cannot change E-Mail!');
            }
        }
    }

    public function deleteAccount($id){
        $user = User::find($id);
        if ($user != null) {
            $user->delete();
            return redirect()->route('home')
                ->withErrors('Account deleted!');
        }
        else {
            redirect()->route('profile.show')
                ->withErrors('Not able to delete account!');
        }
    }
}
