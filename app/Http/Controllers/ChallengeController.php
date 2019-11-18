<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Challenge;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            $challenges = Challenge::all();
        }
        catch (Exception $ex)
        {
            return redirect('challenges.index')->withErrors("No DB connection!");
        }

        return view('challenges.index')->with('challenges',$challenges);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('challenges.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $challenge = new Challenge();
            $challenge->id = $request->id;

            $this->validate($request,[
                'name' => 'required',
                'description' => 'required',
                'difficulty' => 'required',
            ]);

            $challenge->name = $request->name;
            $challenge->description = $request->description;
            $challenge->difficulty = $request->difficulty;

            //Only admin is allowed to change author
            if(isset($request->author) && Auth::user()->hasRole("admin"))
            {
                $challenge->author = $request->author;
            }
            else //Otherwise author is the current user
            {
                $challenge->author = Auth::user()->username;
            }

            $challenge->targetSolution = $request->targetSolution;
            $challenge->imageID = $request->imageID;
            $challenge->attachments = $request->attachments;

            $challenge->save();

            //Redirect back to all challenges after creation of new challenge
            return redirect()->route('challenges.index')->with('challenges', Challenge::all());
        }
        catch (Exception $ex)
        {
            return redirect()->route('challenges.create')->withErrors("Cannot create because of error: " . $ex. "!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $challenge = Challenge::find($id);

        return view('challenges.show')->with('challenge',$challenge);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $challenge = Challenge::find($id);

        //Only allow editing if the user is admin or author of the challenge
        if(Auth::user()->hasRole("admin") || $challenge->author == Auth::user()->username)
        {
            return view('challenges.edit')->with('challenge', $challenge);
        }
        else
        {
            return view('challenges.index')->withErrors('Unauthorized to edit!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $challenge = Challenge::find($id);

            $this->validate($request,[
                'name' => 'required',
                'description' => 'required',
                'difficulty' => 'required',
            ]);

            $challenge->name = $request->name;
            $challenge->description = $request->description;
            $challenge->difficulty = $request->difficulty;

            //Only admin is allowed to change author
            if(isset($request->author) && Auth::user()->hasRole("admin"))
            {
                $challenge->author = $request->author;
            }
            else //Otherwise author is the current user
            {
                $challenge->author = Auth::user()->username;
            }
            $challenge->active = $request->active;
            $challenge->imageID = $request->imageID;
            $challenge->attachments = $request->attachments;

            $challenge->save();

            return redirect()->route('challenges.index');
        }
        catch (Exception $ex)
        {
            return redirect()->route('challenges.edit')->withErrors("Cannot edit because of error: " . $ex. "!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO: Only allow deletion of the user is either admin or author of the challenge
        $challenge = Challenge::find($id);
        $challenge->delete();

        return redirect()->route('challenges.index');
    }
}
