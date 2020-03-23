<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
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
    //Displays all challenges
    public function index()
    {
        try
        {
            //Only allow admin and teacher to view all challenges
            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('teacher'))
            {
                $challenges = Challenge::all();
                return view('challenges.index')->with('challenges', $challenges);
            }
            else
            {
                return redirect()->route('home')->withErrors('You are not allowed to view all challenges!');
            }
        }
        catch (Exception $ex)
        {
            return redirect()->route('challenges.index')->withErrors("No connection to the database could be established!");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Show the create challenge view
    public function create()
    {
        return view('challenges.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    //Save created challenge
    public function store(Request $request)
    {
        try
        {
            //Validate if request contains all needed data
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
                'flag' => 'required',
                'difficulty' => 'required',
                'category' => 'required',
                'active' => 'required'
            ]);

            $challenge = new Challenge();

            $challenge->id = $request->id;
            $challenge->name = $request->name;
            $challenge->description = $request->description;
            $challenge->flag = $request->flag;

            //Check if difficulty has valid value
            if ($challenge->validDifficulty($request->difficulty))
            {
                $challenge->difficulty = $request->difficulty;
            }
            else
            {
                return redirect()->route('challenges.create')->withErrors('Invalid difficulty value!');
            }

            //Check if category has valid value
            if ($challenge->validCategory($request->category))
            {
                $challenge->category = $request->category;
            }
            else
            {
                return redirect()->route('challenges.create')->withErrors('Invalid category value!');
            }

            //Only admin is allowed to change author
            if (isset($request->author))
            {
                if (Auth::user()->hasRole("admin"))
                {
                    $challenge->author = $request->author;
                }
                else
                {
                    //return redirect()->route('challenges.create')->withErrors('You are not authorized to change the author!');
                    $challenge->author = Auth::user()->username;
                }
            }
            else //Otherwise author is the current user
            {
                $challenge->author = Auth::user()->username;
            }

            if ($request->active == 0 || $request->active == 1)
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
            return redirect()->route('challenges.index')->with('success', 'Challenge created!', 'challenges', Challenge::all());
        }
        catch (Exception $ex)
        {
            return redirect()->route('challenges.create')->withErrors("Cannot create because of error: " . $ex . "!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    //Show detailed view of challenge
    public function show($id)
    {
        try
        {
            $challenge = Challenge::findOrFail($id);
            $gifPath = ""; //No GIF should be displayed

            //Every admin, teacher and authorized students can view challenges
            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('teacher') || Auth::user()->hasChallenge($challenge->id))
            {
                return view('challenges.show')->with(['challenge' => $challenge, 'gifPath' => $gifPath]);
            }
            else
            {
                return view('challenges.index')->with('challenges',Challenge::all())->withErrors('You are not allowed to view this challenge!');
            }
        }
        catch (\Exception $ex)
        {
            return view('challenges.index')->with('challenges',Challenge::all())->withErrors('Could not find challenge!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    //Edit a selected challenge
    public function edit($id)
    {
        try
        {
            $challenge = Challenge::findOrFail($id);

            //Only allow editing if the user is admin or author of the challenge
            if (Auth::user()->hasRole("admin") || $challenge->author == Auth::user()->username)
            {
                return view('challenges.edit')->with('challenge', $challenge);
            }
            else
            {
                return view('home')->withErrors('You are not authorized to edit this challenge!');
            }
        }
        catch (\Exception $exception)
        {
            return view('challenges.index')->with('challenges',Challenge::all())->withErrors('Could not edit because of error: ' . $exception . '!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    //Update a selected challenge
    public function update(Request $request, $id)
    {
        try
        {
            //Validate if send input is valid
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
                'flag' => 'required',
                'difficulty' => 'required',
                'category' => 'required',
            ]);

            $challenge = Challenge::findOrFail($id);

            $challenge->name = $request->name;
            $challenge->description = $request->description;
            $challenge->flag = $request->flag;

            //Check if difficulty has valid value
            if ($challenge->validDifficulty($request->difficulty))
            {
                $challenge->difficulty = $request->difficulty;
            }
            else
            {
                return redirect()->route('challenges.edit', $challenge)->withErrors('Invalid difficulty value!');
            }

            //Check if category has valid value
            if ($challenge->validCategory($request->category))
            {
                $challenge->category = $request->category;
            }
            else
            {
                return redirect()->route('challenges.edit', $challenge)->withErrors('Invalid category value!');
            }

            //Only admin is allowed to change author
            if (isset($request->author))
            {
                if (Auth::user()->hasRole("admin"))
                {
                    $challenge->author = $request->author;
                }
                else
                {
                    //return redirect()->route('challenges.edit',$challenge)->withErrors('You are not authorized to change the author!');
                    $challenge->author = Auth::user()->username;
                }
            }
            else //Otherwise author is the current user
            {
                $challenge->author = Auth::user()->username;
            }

            //Check if active value is a bool
            if ($request->active == 0 || $request->active == 1)
            {
                $challenge->active = $request->active;
            }
            else
            {
                return redirect()->route('challenges.edit', $challenge)->withErrors('Invalid status value selected!');
            }

            $challenge->imageID = $request->imageID;
            $challenge->targetSolution = $request->targetSolution;
            $challenge->hint = $request->hint;

            $challenge->save();

            return redirect()->route('challenges.index')->with('success', 'Challenge successfully edited!');
        }
        catch (Exception $ex)
        {
            if ($challenge != null)
                return redirect()->route('challenges.edit', $challenge)->withErrors('Cannot edit because of error: ' . $ex . '!');
            else
                return redirect()->route('challenges.edit')->withErrors('Cannot edit because of error: ' . $ex . '!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    //Delete a selected challenge
    public function destroy($id)
    {
        try
        {
            $challenge = Challenge::findOrFail($id);

            //Only allow deletion of the challenge if user is admin // or author of the challenge
            if (Auth::user()->hasRole("admin"))               // || Auth::user()->isAuthor($challenge->author))
            {
                //Only allow deletion of disabled challenges
                if (!$challenge->active)
                {
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

            return redirect()->route('challenges.index')->with('success', 'Successfully deleted challenge!');
        }
        catch (\Exception $exception)
        {
            return redirect()->route('challenges.index')->withErrors('Error occurred on deletion!');
        }
    }

    //Get the upload page
    public function files($id)
    {
        try
        {
            $challenge = Challenge::findOrFail($id);

            return view('challenges.files')->with('challenge', $challenge);
        }
        catch (\Exception $ex)
        {
            return redirect()->route('challenges.index')->withErrors("Could not find challenge!");
        }
    }

    //This function handles the download of data of a challenge
    public function download($id)
    {
        try
        {
            $challenge = Challenge::findOrFail($id);

            //Check if user is authorized to download the file
            if (Auth::User()->hasChallenge($challenge->id) || Auth::user()->hasRole('admin') || Auth::user()->hasRole('teacher'))
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

    //This function handles the uploading of files
    public function upload(Request $request, $id)
    {
        //Only allow zip files with max of 100 MB
        $this->validate($request, [
            'file' => 'required|file|mimes:zip|max:100000', //100 000 KB
        ]);

        try
        {
            $challenge = Challenge::findOrFail($id);

            //Define upload path
            $path = 'files/' . $challenge->id;

            //Get file extension
            $extension = $request->file('file')->clientExtension();

            //Check valid extensions
            $valid = array("zip");

            //Check extension
            if (in_array(strtolower($extension), $valid))
            {
                //Create random filename
                $fileName = time() . rand(11111, 99999) . '.' . $extension;

                //Delete old file, if challenge had one
                if ($challenge->files != "")
                    Storage::delete($challenge->files);

                //Upload file to given path
                $request->file('file')->storeAs($path, $fileName);

                $challenge->files = $path . '/' . $fileName;
                $challenge->save();

                return view('challenges.show')->with('challenge', $challenge)->with('success', 'File successfully uploaded!');
            }
            else
            {
                return redirect()->route('challenges.show')->with('challenge', $challenge)->withErrors('Invalid file type');
            }
        }
        catch (\Exception $ex)
        {
            return redirect()->route('challenges.index')->withErrors('Could not upload because of error: ' . $ex->getMessage());
        }
    }

    //This function handles flag-submission
    public function flag(Request $request, $id)
    {
        $this->validate($request, [
            'flag' => 'required'
        ]);

        $challenge = null;

        try
        {
            $challenge = Challenge::find($id);

            //Choose random GIF
            $gifName = random_int(1, 6);

            if (!$challenge->active)
            {
                return redirect()->route('challenges.index')->withErrors('You should not have been there... Please report this issue!');
            }

            //Make flag case-insensitive
            if (strtolower($challenge->flag) == strtolower($request->flag))
            {
                $challenge->solveChallenge(Auth::user());

                //Path to the randomly selected GIF
                $gifPath = '/images/GIFs/WIN/' . $gifName . '.gif';

                $success = 'Congratulation, you solved the challenge!';
                return view('challenges.show')->with(['challenge' => $challenge, 'success' => $success, 'gifPath' => $gifPath]);
            }
            else
            {
                //Path to the randomly selected GIF
                $gifPath = '/images/GIFs/FAIL/' . $gifName . '.gif';

                return view('challenges.show')->with(['challenge' => $challenge, 'gifPath' => $gifPath])->withErrors('Sorry this is not the right flag! Please try again!');
            }
        }
        catch (QueryException $queryException)
        {
            //If this exception occurs, the challenge was already solved
            if ($queryException->errorInfo[1] == 1062)
            {
                $gifPath = "";
                return redirect()->route('challenges.show', $challenge->id)->with(['success' => 'Congratulations, but you already solved this one!', 'gifPath' => $gifPath]);
            }
            else
            {
                $gifPath = "";
                return redirect()->route('challenges.show', $challenge->id)->with(['challenge' => $challenge, 'gifPath' => $gifPath])->withErrors('Could not submit because of an error!');
            }
        }
        catch (\Exception $ex)
        {
            if ($challenge == null)
            {
                return redirect()->route('challenges.index')->withErrors('Could not submit because of error: ' . $ex->getMessage());
            }
            else
            {
                $gifPath = "";
                return redirect()->route('challenges.show', $challenge->id)->with(['challenge' => $challenge, 'gifPath' => $gifPath])->withErrors('Could not submit because of error: ' . $ex->getMessage());
            }
        }
    }
}
