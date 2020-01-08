<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\Notifications\AckEmail;
use App\Notifications\SupportEmail;
use App\SupportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;
use App\User;

class SupportRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($id){

        $challenge = Challenge::find($id);
        return view('support.index')->with('challenge', $challenge);
    }

    public function submit(Request $request)
    {
        try{
            $supportRequest = new SupportRequest();

            $supportRequest->id = $request->id;

            $supportRequest->challenge_id = $request->challenge;

            $supportRequest->user_id = Auth::user()->id;

            $subject = "Support Request to challenge:". $request->challenge . " - by user " . Auth::user()->username;
            $supportRequest->subject = $subject;

            $this->validate($request, [
                'message' => 'required'
            ]);
            $supportRequest->message = $request->get('message');
            $supportRequest->solved = false;

            $supportRequest->save();

            $this->sendMail($supportRequest);

            return redirect()->route('challenges.show', $request->challenge)->with('success', 'Support request has been sent! Check your mail inbox for a confirmation message.');
            #return redirect()->route('challenges.show')->with('success', 'Support request has been sent! Check your mail inbox for a confirmation message.');
        }
        catch (Exception $ex){
            return redirect()->route('support.create')->withErrors("Cannot send support request because of error: " . $ex. "!");
        }
    }

    public function sendMail (SupportRequest $supportRequest){


        $admin = new User();
        $admin = $admin->getAdmin();

        $admin->notify(new SupportEmail($supportRequest));
        Auth::user()->notify(new AckEmail($supportRequest));
    }
}
