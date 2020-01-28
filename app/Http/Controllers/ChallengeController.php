<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Challenge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;

class ChallengeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

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
        $displayGIF = null; //no GIF should be displayed

        if(Auth::user()->hasRole('admin') || Auth::user()->hasChallenge($challenge->id))
        {
            return view('challenges.show')->with(['challenge' => $challenge, 'displayGIF' => $displayGIF]);
        }
        else
        {
            return view('challenges.index')->with('challenges',Challenge::all( ))->withErrors('You are not allowed to view this challenge!');
        }
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

    public function files($id)
    {
        try
        {
            $challenge = Challenge::find($id);

            return view('challenges.files')->with('challenge',$challenge);
        }
        catch (\Exception $ex)
        {
            return redirect('challenges.index')->withErrors("Could not find challenge!");
        }
    }

    public function download($id)
    {
        try
        {
            $challenge = Challenge::find($id);
            if(Auth::User()->hasChallenge($challenge->id))
            {
                if (Storage::disk('local')->exists($challenge->files))
                {
                    return Storage::download($challenge->files);
                }
                else
                {
                    return redirect()->route('challenges.show')->with('challenge', $challenge)->withErrors('This challenge has no files!');
                }
            }
        }
        catch (\Exception $ex)
        {
            return redirect()->route('challenges.index')->withErrors("Could not prepare download!");
        }
    }

    public function upload(Request $request, $id)
    {
        //Only allow zip files with max of 100 MB
        $this->validate($request, [
            'file' => 'required|file|mimes:zip|max:100000',
        ]);

        try
        {
            $challenge = Challenge::find($id);

            if ($challenge)
            {
                //Upload path
                $path =  'files/' . $challenge->id;

                // Get file extension
                $extension = $request->file('file')->clientExtension();

                // Check valid extensions
                $valid = array("zip");

                // Check extension
                if (in_array(strtolower($extension), $valid))
                {
                    // Rename file
                    $fileName = time() . rand(11111, 99999) . '.' . $extension;

                    // Uploading file to given path
                    $request->file('file')->storeAs($path, $fileName);

                    //Delete old file if challenge had one
                    if($challenge->files != "")
                        Storage::delete($challenge->files);

                    $challenge->files = $path . '/' . $fileName;
                    $challenge->save();

                    return view('challenges.show')->with('challenge',$challenge)->with('success','File successfully uploaded!');
                }
                else
                {
                    throw new \Exception("Invalid file type!");
                }
            }
            else
            {
                throw new \Exception("Challenge does not exist!");
            }
        }
        catch (\Exception $ex)
        {
            return redirect()->route('challenges.index')->withErrors('Could not upload because of error: ' . $ex->getMessage());
        }
    }

    public function flag(Request $request, $id)
    {
        $this->validate($request, [
            'flag' => 'required'
        ]);

        $challenge = null;

        try
        {
            $challenge = Challenge::find($id);
            $displayGIF = null;   //parameter to now what gif should be displayed

            //Make flag case insensitive
            if (strtolower($challenge->flag) == strtolower($request->flag))
            {
                //Add points to user
                Auth::user()->addPoints($challenge->getPoints());
                $displayGIF = true;

                //Save that user has solved challenge
                $challenge->challengeUsers()->attach(Auth::user());
                return view('challenges.show')->with(['challenge' => $challenge, 'displayGIF' => $displayGIF, 'success' => 'Congratulation! You solved the challenge!']);
            }
            else
            {
                $displayGIF = false;
                return view('challenges.show')->with(['challenge' => $challenge, 'displayGIF' => $displayGIF])->withErrors('Sorry this is not the right flag! Please try again!');
            }
        }
        catch (\Exception $ex)
        {
            if($challenge == null)
            {
               return redirect()->route('challenges.index')->withErrors('Could not submit because of error: ' . $ex->getMessage());
            }
            else
            {

               return redirect()->route('challenges.show')->with('challenge',$challenge->id)->withErrors('Could not submit because of error: ' . $ex->getMessage());
            }
        }
    }
}
