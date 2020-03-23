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

    //create a new ticket, return the support index route
    public function create($id)
    {
        try
        {
            $challenge = Challenge::findOrFail($id);
            return view('support.index')->with('challenge', $challenge);
        }
        catch (\Exception $exception)
        {
            return redirect('home')->withErrors('Could not find challenge!');
        }
    }

    //submit a nw request
    public function submit(Request $request)
    {
        try
        {
            $this->validate($request, [
                'message' => 'required'
            ]);

            $supportRequest = new SupportRequest();

            $supportRequest->id = $request->id;
            $supportRequest->challenge_id = $request->challenge;
            $supportRequest->user_id = Auth::user()->id;

            $subject = "Support Request to challenge: ". $request->challenge . " - by user " . Auth::user()->username;
            $supportRequest->subject = $subject;

            $supportRequest->message = $request->get('message');
            $supportRequest->solved = false;

            $supportRequest->save();

            $this->sendMail($supportRequest);

            return redirect()->route('challenges.show', $request->challenge)->with('success', 'Support request has been sent! Check your mail inbox for a confirmation message.');
        }
        catch (Exception $ex)
        {
            return redirect()->route('support.create')->withErrors("Cannot send support request because of error: " . $ex. "!");
        }
    }

    //send a mail to the administrator
    public function sendMail (SupportRequest $supportRequest)
    {
        User::getAdmin()->notify(new SupportEmail($supportRequest));
        Auth::user()->notify(new AckEmail($supportRequest));
    }
}
