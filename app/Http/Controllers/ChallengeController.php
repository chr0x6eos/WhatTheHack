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
            return redirect('challenges.index')->withErrors("No DB connection could be established!");
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
                'flag' => 'required',
                'difficulty' => 'required',
                'category' => 'required',
                'active' => 'required'
            ]);

            $challenge->name = $request->name;
            $challenge->description = $request->description;
            $challenge->flag = $request->flag;

            //Check if difficulty is valid value
            if($challenge->validDifficulty($request->difficulty))
            {
                $challenge->difficulty = $request->difficulty;
            }
            else
            {
                return redirect()->route('challenges.create')->withErrors('Invalid difficulty value!');
            }

            //Check if category is valid value
            if($challenge->validCategory($request->category))
            {
                $challenge->category = $request->category;
            }
            else
            {
                return redirect()->route('challenges.create')->withErrors('Invalid category value!');
            }

            //Only admin is allowed to change author
            if(isset($request->author))
            {
                if(Auth::user()->hasRole("admin"))
                {
                    $challenge->author = $request->author;
                }
                else
                {
                    return redirect()->route('challenges.create')->withErrors('You are not authorized to change the author!');
                }
            }
            else //Otherwise author is the current user
            {
                $challenge->author = Auth::user()->username;
            }

            if($request->active == 0 || $request->active == 1)
            {
                $challenge->active = $request->active;
            }
            else
            {
                return redirect()->route('challenges.create')->withErrors('Invalid status value selected!');
            }

            $challenge->imageID = $request->imageID;
            $challenge->targetSolution = $request->targetSolution;
            $challenge->hint = $request->hint;
            $challenge->attachments = $request->attachments;

            $challenge->save();

            //Redirect back to all challenges after creation of new challenge
            return redirect()->route('challenges.index')->with('success','Challenge created!','challenges', Challenge::all());
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
            return view('challenges.index')->withErrors('You are not authorized to edit!');
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
                'flag' => 'required',
                'difficulty' => 'required',
                'category' => 'required',
            ]);

            $challenge->name = $request->name;
            $challenge->description = $request->description;
            $challenge->flag = $request->flag;

            //Check if difficulty is valid value
            if($challenge->validDifficulty($request->difficulty))
            {
                $challenge->difficulty = $request->difficulty;
            }
            else
            {
                return redirect()->route('challenges.edit',$challenge)->withErrors('Invalid difficulty value!');
            }

            if($challenge->validCategory($request->category))
            {
                $challenge->category = $request->category;
            }
            else
            {
                return redirect()->route('challenges.edit',$challenge)->withErrors('Invalid category value!');
            }

            //Only admin is allowed to change author
            if(isset($request->author))
            {
                if(Auth::user()->hasRole("admin"))
                {
                    $challenge->author = $request->author;
                }
                else
                {
                    return redirect()->route('challenges.edit',$challenge)->withErrors('You are not authorized to change the author!');
                }
            }
            else //Otherwise author is the current user
            {
                $challenge->author = Auth::user()->username;
            }

            //Check if active value is a bool
            if($request->active == 0 || $request->active == 1)
            {
                $challenge->active = $request->active;
            }
            else
            {
                return redirect()->route('challenges.edit',$challenge)->withErrors('Invalid status value selected!');
            }

            $challenge->imageID = $request->imageID;
            $challenge->targetSolution = $request->targetSolution;
            $challenge->hint = $request->hint;
            $challenge->attachments = $request->attachments;

            $challenge->save();

            return redirect()->route('challenges.index')->with('success','Challenge successfully edited!');
        }
        catch (Exception $ex)
        {
            return redirect()->route('challenges.edit',$challenge)->withErrors("Cannot edit because of error: " . $ex. "!");
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
        $challenge = Challenge::find($id);

        //Only allow deletion of the challenge if user is admin // or author of the challenge
        if(Auth::user()->hasRole("admin")) //|| Auth::user()->isAuthor($challenge->author))
        {
            if($challenge->active == false) {
                $challenge->delete();
            }
            else
            {
                return redirect()->route('challenges.index')->withErrors('An active challenge cannot be deleted!');
            }
        }
        else
        {
            return redirect()->route('challenges.index')->withErrors('You are not authorized to delete this challenge!');
        }

        return redirect()->route('challenges.index')->with('success','Successfully deleted challenge!');
    }
}
