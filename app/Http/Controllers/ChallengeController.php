<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Challenge;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $challenges = Challenge::all();
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
        $challenge = new Challenge();
        $challenge->id = $request->id;

        if ($challenge->name)
            $challenge->name = $request->name;
        else
            return redirect()->route('challenges.create')->withErrors('Missing Challenge Name!');

        if ($challenge->description)
            $challenge->description = $request->description;
        else
            return redirect()->route('challenges.create')->withErrors('Missing Challenge description!');

        if ($challenge->difficulty)
            $challenge->difficulty = $request->difficulty;
        else
            return redirect()->route('challenges.create')->withErrors('Missing Challenge difficulty!');

        if ($challenge->author)
            $challenge->author = $request->author;
        else
            return redirect()->route('challenges.create')->withErrors('Missing Challenge author!');

        if ($challenge->imageID)
            $challenge->imageID = $request->imageID;
        else
            $challenge->imageID = "";

        if ($challenge->attachments)
            $challenge->attachments = $request->attachments;
        else
            $challenge->attachments = "";

        $challenge->save();

        //Redirect back to all challenges after creation of new challenge
        return redirect()->route('challenges.index')->with('challenges',Challenge::all());
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

        return view('challenges.edit')->with('challenge',$challenge);
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
        $challenge = Challenge::find($id);

        $challenge->name = $request->name;
        $challenge->description = $request->description;
        $challenge->difficulty = $request->difficulty;
        $challenge->author = $request->author;
        $challenge->imageID = $request->imageID;
        $challenge->attachments = $request->attachments;
        $challenge->save();

        return redirect()->route('challenges.index');
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
