<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use function Sodium\add;
use Symfony\Component\Routing\Matcher\RedirectableUrlMatcher;

class ClassroomController extends Controller
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
    //show classrooms
    public function index()
    {
        try
        {
            //The admin is allowed to see all classrooms
            if (Auth::user()->hasRole('admin'))
            {
                $classrooms = Classroom::all();
            }
            //Teacher can view all classrooms he is either an owner or a member
            elseif (Auth::user()->hasRole('teacher'))
            {
                $classrooms = null;
                foreach (Classroom::all() as $classroom)
                {
                    if ($classroom->getMembers(Auth::user()->getAuthIdentifier()) || $classroom->isOwner(Auth::user()->getAuthIdentifier()))
                    {
                        $classrooms[] = $classroom;
                    }
                }
            }
            else
            {
                return redirect()->route('home')->withErrors('You are not allowed to view all classrooms!');
            }

            return view('classroom.index')->with('classrooms', $classrooms);
        }
        catch (Exception $ex)
        {
            return redirect()->route('home')->withErrors("No database connection");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //create a new classroom
    public function create()
    {
        return view('classroom.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    //store the data of a specific classroom
    public function store(Request $request)
    {
        try
        {
            $this->validate($request, [
                'name' => 'required',
                //'add_Students'=>'required', //Not required, because empty classrooms can exist
            ]);

            $classroom = new Classroom();

            $classroom->id = $request->id;
            $user = Auth::user();

            $classroom->classroom_name = $request->name;
            $classroom->classroom_owner = $user->getAuthIdentifier();
            // $classroom->active = $request->active;

            $addStudents = $request->input('add_Students');
            $classroom->save();

            //Creator of a classroom is automatically a member
            $classroom->users()->attach($user->getAuthIdentifier());

            //Add all selected students to the classroom
            foreach ($addStudents as $student)
            {
                $classroom->users()->attach($student);
            }

            return redirect()->route('classroom.index');
        }
        catch (Exception $ex)
        {
            return redirect()->route('classroom.create')->withErrors("Cannot create because of error: " . $ex . "!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    //return a list of all my classrooms
    public function myClassrooms()
    {
        $classrooms = Auth::user()->classrooms;
        return view('classroom.myClassrooms')->with('classrooms', $classrooms);
    }

    //edit a specific classroom
    public function edit($id)
    {
        try
        {
            $classroom = Classroom::findOrFail($id);
            return view('classroom.edit')->with('classroom', $classroom);
        }
        catch (\Exception $exception)
        {
            return redirect()->route('classroom.index')
                ->withErrors('Classroom with id ' . $id . ' not found!');
        }
    }

    //add and remove members to a specific classroom
    public function editMembers($id)
    {
        try
        {
            $classroom = Classroom::find($id);
            return view('classroom.editMembers')->with('classroom', $classroom);
        }
        catch (\Exception $exception)
        {
            return redirect()->route('classroom.index')
                ->withErrors('Classroom with id ' . $id . ' not found!');
        }
    }

    //add and remove challenges to a classroom
    public function editChallenges($id)
    {
        try
        {
            $classroom = Classroom::find($id);
            return view('classroom.editChallenges')->with('classroom', $classroom);
        }
        catch (\Exception $exception)
        {
            return redirect()->route('classroom.index')
                ->withErrors('Classroom with id ' . $id . ' not found!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    //update a specific classroom
    public function update(Request $request, $id)
    {
        try
        {
            $classroom = Classroom::findOrFail($id);

            $classroom->classroom_name = $request->name;
            $classroom->active = $request->active;
            $classroom->save();

            return redirect()->route('classroom.index')->with('success', 'Successfully edited!');
        }
        catch (\Exception $exception)
        {
            return redirect()->route('classroom.index')->withErrors('Error upon editing classroom!');
        }
    }

    //update the members of a classroom
    public function updateMembers(Request $request, $id)
    {
        try
        {
            $this->validate($request, [
                'addmember' => 'required',
            ]);
            $classroom = Classroom::findOrFail($id);
            $addStudents = $request->input('addmember');
            $classroom->save();

            foreach ($addStudents as $student)
            {
                $classroom->users()->attach($student);
            }
            return redirect()->route('classroom.index');
        }
        catch (\Exception $exception)
        {
            return redirect()->route('classroom.index')->withErrors('Error upon updating classroom members!');
        }
    }

    //delete members of a classroom
    public function deleteMembers(Request $request, $id)
    {
        try
        {
            $this->validate($request, [
                'deletemembers' => 'required',
            ]);

            $classroom = Classroom::find($id);
            $deleteStudents = $request->input('deletemembers');
            $classroom->save();

            foreach ($deleteStudents as $student)
            {
                $classroom->users()->detach($student);
            }
            return redirect()->route('classroom.index')->with('success', 'Successfully deleted members!');
        }
        catch (\Exception $exception)
        {
            return redirect()->route('classroom.index')->withErrors('Error upon deleting classroom members!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    //destroy/delete a classroom, only when classroom is already disabled
    public function destroy($id)
    {
        try
        {
            $classroom = Classroom::findOrFail($id);

            if (Auth::user()->hasRole("admin"))
            {
                if ($classroom->active == "0")
                {
                    $challenges = $classroom->challenges;
                    $members = $classroom->users;
                    foreach ($challenges as $c)
                    {
                        $classroom->challenges()->detach($c);
                    }
                    foreach ($members as $m)
                    {
                        $classroom->users()->detach($m);
                    }
                    $classroom->delete();

                    return redirect()->route('classroom.disabled');
                }
                else
                {
                    return redirect()->route('classroom.index')->withErrors('An active classroom cannot be deleted!');
                }
            }
            else
            {
                return redirect()->route('classroom.index')->withErrors('You are not authorized to delete this classroom!');
            }

            return redirect()->route('classroom.index')->with('success', 'Successfully deleted classroom!');
        }
        catch (\Exception $exception)
        {
            return redirect()->route('classroom.index')->withErrors('Error upon deleting classroom!');
        }
    }

    //Associate a multitude of challenges with a classroom
    public function attach(Request $request, $id)
    {
        try
        {
            $this->validate($request, [
                'add_Challenges' => 'required',
            ]);

            $classroom = Classroom::findOrFail($id);
            $challenges = $request->input('add_Challenges');

            foreach ($challenges as $c)
            {
                $challenge = Challenge::find($c);
                if ($challenge->active == true)
                    $classroom->challenges()->attach($c);
            }

            return redirect()->route('classroom.index')->with('success', 'Added challenges to classroom!');
        }
        catch (\Exception $exception)
        {
            return redirect()->route('classroom.index')->withErrors('Error upon adding challenges to classroom!');
        }
    }

    //detach the relations between classroom, users and challenges
    public function detach(Request $request, $id)
    {
        try
        {
            $classroom = Classroom::findOrFail($id);
            $challenges = $request->input('remove_Challenges');

            foreach ($challenges as $c)
            {
                $classroom->challenges()->detach($c);
            }
            return redirect()->route('classroom.index')->with('success','Successfully removed challenges from classroom!');
        }
        catch (\Exception $exception)
        {
            return redirect()->route('classroom.index')->withErrors('Error upon removing challenges from classroom!');
        }
    }

    //disable a specific classroom
    public function disabled()
    {
        try
        {
            $classrooms = Classroom::all();
        }
        catch (Exception $ex)
        {
            return redirect()->route('classroom.disabled')->withErrors("No database connection!");
        }
        return view('classroom.disabled')->with('classrooms', $classrooms);
    }

    //restore a specific classroom
    public function restore($id)
    {
        try
        {
            $classroom = Classroom::findOrFail($id);
            $classroom->active = "1";
            $classroom->save();

            $classrooms = Classroom::all();
            return view('classroom.disabled')->with('classrooms', $classrooms);
        }
        catch (\Exception $exception)
        {
            return view('classroom.disabled')->with('classrooms',Classroom::all())->withErrors('Error upon restoring the classroom!');
        }
    }

    //show challenges of a specific classroom
    public function showChallenges($id)
    {
        try
        {
            $classroom = Classroom::find($id);
            return view('classroom.showChallenges')->with('classroom', $classroom);
        }
        catch (\Exception $exception)
        {
            return redirect()->route('classroom.index')
                ->withErrors('Classroom with id ' . $id . ' not found!');
        }
    }
}
