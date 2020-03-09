<?php

namespace App\Http\Controllers;

use App\EMCTokens;
use App\Notifications\ChangeEmail;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //show details of a specific user
    public function show()
    {
        $user = Auth::user();

        if($user != null)
        {
            return view('profile.profile')->with('user', $user);
        }
        else
        {
            return view('auth.login');
        }
    }

    //show a form that is used to change the password
    public function showChangePWForm()
    {
        $user = Auth::user();
        return view('auth.passwords.change')->with('user', $user);
    }

    public function changePW(Request $request)
    {
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

        if($user == null)
        {
            return redirect()->route('auth.login')
                ->withErrors('User not found! Please log in!');
        }
        else
        {
            try
            {
                if(!Hash::check($currentPW, $user->password))
                {
                    return redirect()->route('profile.showChangePWForm')
                        ->withErrors('Wrong current password!');
                }
                elseif($password != $confirmPassword)
                {
                    return redirect()->route('profile.showChangePWForm')
                        ->withErrors('Passwords do not match!');
                }
                else
                {
                    $request->user()->fill([
                        'password' => Hash::make($password)
                    ])->save();
                }
                return redirect()->route('profile.show')->with('success','Password changed!');
            }
            catch (Exception $ex)
            {
                return redirect()->route('profile.show')
                    ->withErrors($ex->getMessage());
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

        if($user == null)
        {
            return redirect()->route('auth.login')
                ->withErrors('User not found! Please log in!');
        }
        else
        {
            try
            {
                if($email != $user->email)
                {
                    return redirect()->route('profile.showChangeEMForm')
                        ->withErrors('Wrong current E-Mail!');
                }
                else
                {
                    ###Generate token and save it to database###
                    $token = Str::random(32);
                    $emctoken = new EMCTokens();
                    $emctoken->user_id = $user->id;
                    $emctoken->token = $token;
                    $emctoken->email = $newEmail;
                    $emctoken->valid_until = now()->addMinutes(30);
                    $emctoken->save();

                    //send notification with the token to the users new email
                    Notification::route('mail', $newEmail)->notify(new ChangeEmail($user->id, $token));
                }
                return redirect()->route('profile.show')
                    ->with('success','An e-mail change request was sent to your new e-mail!');
            }
            catch (Exception $ex)
            {
                return redirect()->route('profile.show')
                    ->withErrors($ex->getMessage());
            }
        }
    }

    public function changeEmail(Request $request)
    {
        // Get user_id and token from the request
        $user_id = $request->route('id');
        $token = $request->route('token');
        try
        {
            //get all tokens and the user who wants to change the email from database
            $emctokens = EMCTokens::all();
            $user = User::find($user_id);

            foreach ($emctokens as $emctoken)
            {
                if($emctoken->user_id == $user_id && $emctoken->token == $token)
                {
                    //check if token is expired or not
                    $currentTS = now();
                    //parse valid_until to carbon datetime
                    $tokenTS = Carbon::parse($emctoken->valid_until);
                    if($tokenTS->lt($currentTS))
                    {
                        $emctoken->delete();
                        return redirect()->route('profile.show')->withErrors('E-Mail change verification expired!');
                    }
                    else
                    {
                        //change the email
                        $user->email = $emctoken->email;
                        $user->save();
                        //delete the token
                        $emctoken->delete();
                        return redirect()->route('profile.show')->with('success', 'E-Mail changed!');
                    }
                }
                else
                {
                    return redirect()->route('profile.show')
                        ->withErrors('Could not change E-Mail!');
                }
            }
        }
        catch(Exception $ex)
        {
            return redirect()->route('profile.show')
                ->withErrors($ex->getMessage());
        }
    }

    public function deleteAccount($id){
        try
        {
            $user = User::find($id);
            if($user->hasRole('Admin'))
            {
                return redirect()->route('profile.show')
                    ->withErrors('Admins can not delete their account!!');
            }
            if ($user != null) {

                if($user->classrooms == null){
                    $user->delete();
                    return redirect()->route('/')
                        ->withErrors('Account deleted!');
                }
                else{
                    return redirect()->route('profile.show')
                        ->withErrors('Can not delete account. User is still in a classroom!');
                }
            }
            else
            {
                return redirect()->route('profile.show')
                    ->withErrors('Not able to delete account!');
            }
        }
        catch (Exception $ex)
        {
            return redirect()->route('profile.show')
                ->withErrors($ex->getMessage());
        }
    }
}
