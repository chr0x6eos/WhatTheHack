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
    //constructor
    public function __construct()
    {
        $this->middleware('auth');
    }

    //show details of a specific user
    public function show()
    {
        $user = Auth::user();

        if ($user != null)
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

    //change the password of a specific user
    public function changePW(Request $request)
    {
        $this->validate($request,
                        [
                            'currentPassword' => 'required|max:50',
                            'password' => 'required|max:50',
                            'confirmPassword' => 'required|max:50'
                        ]
        );
        $user = Auth::user();

        $currentPW = $request->currentPassword;
        $password = $request->password;
        $confirmPassword = $request->confirmPassword;

        if ($user == null)
        {
            return redirect()->route('auth.login')
                ->withErrors('User not found! Please log in!');
        }
        else
        {
            try
            {
                //check if the entered current password is right and check if the new passwords are the same
                if (!Hash::check($currentPW, $user->password))
                {
                    return redirect()->route('profile.showChangePWForm')
                        ->withErrors('Wrong current password!');
                }
                elseif ($password != $confirmPassword)
                {
                    return redirect()->route('profile.showChangePWForm')
                        ->withErrors('Passwords do not match!');
                }
                else
                {
                    //change the password and save it in the database
                    $request->user()->fill([
                                               'password' => Hash::make($password)
                                           ])->save();
                }
                return redirect()->route('profile.show')->with('success', 'Password changed!');
            }
            catch (Exception $ex)
            {
                return redirect()->route('profile.show')
                    ->withErrors($ex->getMessage());
            }
        }
    }

    //how the view for the change email form
    public function showChangeEMForm()
    {
        $user = Auth::user();
        return view('profile.changeEM')->with('user', $user);
    }

    //create token and send an email to the user when user wants to change email
    public function changeEM(Request $request)
    {
        $this->validate($request,
            [
                'email' => ['required', 'max:100'],
                'newEmail' => ['required', 'max:100', 'regex:/^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z]+\.)?(edu.htl-villach|htl-villach)\.at$/'],
            ],
            [
                'newEmail.regex' => 'Invalid email domain! Valid domains: edu.htl-villach.at or htl-villach.at'
            ]
        );

        $user = Auth::user();
        $email = $request->email;
        $newEmail = $request->newEmail;

        if ($user == null)
        {
            return redirect()->route('auth.login')
                ->withErrors('User not found! Please log in!');
        }
        else
        {
            try
            {
                //check if entered current email is correct
                if ($email != $user->email)
                {
                    return redirect()->route('profile.showChangeEMForm')
                        ->withErrors('Wrong current E-Mail!');
                }
                else
                {
                    //check if user already requested a token
                    $allTokens = EMCTokens::all();
                    foreach ($allTokens as $emc){
                        if($user->id == $emc->user_id){
                          if(Carbon::parse($emc->valid_until)->gt(now())){ //check if token is valid
                              return redirect()->route('profile.show')
                                  ->withErrors('Request to change email is possible every 30min!');
                          }
                          else{
                              //delete invalid token
                              $emc->delete();
                              //after deletion of the invalid token create a new one
                          }
                        }
                    }

                    //Generate token and save it to database
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
                    ->with('success', 'An e-mail change request was sent to your new e-mail!');
            }
            catch (Exception $ex)
            {
                return redirect()->route('profile.show')
                    ->withErrors($ex->getMessage());
            }
        }
    }

    //change email after user clicked on the link in the verification email
    public function changeEmail(Request $request)
    {
        // Get user_id and token from the request
        $user_id = $request->route('id');
        $token = $request->route('token');
        try
        {
            //get all tokens and the user who wants to change the email from database
            $emctokens = EMCTokens::all();
            $user = User::findOrFail($user_id);

            foreach ($emctokens as $emctoken)
            {
                if ($emctoken->user_id == $user_id && $emctoken->token == $token)
                {
                    $currentTS = now();
                    //parse valid_until to carbon datetime
                    $tokenTS = Carbon::parse($emctoken->valid_until);
                    //check if token is expired or not
                    if ($tokenTS->lt($currentTS))
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
        catch (Exception $ex)
        {
            return redirect()->route('profile.show')
                ->withErrors($ex->getMessage());
        }
    }

    //delete user account of logged-in user
    public function deleteAccount($id)
    {
        try
        {
            $user = User::findOrFail($id);
            if ($user->hasRole('Admin'))
            {
                return redirect()->route('profile.show')
                    ->withErrors('Admins can not delete their account!!');
            }
            if ($user != null)
            {

                if ($user->classrooms == null)
                {
                    $user->delete();
                    return redirect()->route('/')
                        ->withErrors('Account deleted!');
                }
                else
                {
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

    //search for a profile of a specified user
    public function searchProfile(Request $request)
    {

        $this->validate($request, [
            'username' => 'required|max:50',
        ]);

        try
        {
            //get all users and the username from the POST request
            $users = User::all();
            $username = $request->username;

            //search for the user and return the user if found
            if ($username != "" || $username != null)
            {
                foreach ($users as $user)
                {
                    if ($user->username == $username)
                    {
                        return view('profile.visitProfile')->with('user', $user);
                    }
                }
                return redirect()->route('home')
                    ->withErrors('Can not find this user!');
            }
            else
            {
                return redirect()->route('home')
                    ->withErrors('Search field is empty! Please enter a username!');
            }
        }
        catch (Exception $ex)
        {
            return redirect()->route('home')
                ->withErrors($ex->getMessage());
        }
    }
}
