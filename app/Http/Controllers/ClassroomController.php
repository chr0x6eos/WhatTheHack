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
    public function index()
    {
        //
        try {
            $classrooms = Classroom::all();
        }
        catch (Exception $ex){
            return redirect('classroom.index')->withErrors("No db");
        }
        return view('classroom.index')->with('classrooms',$classrooms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('classroom.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $classroom = new Classroom();
            $classroom->id = $request->id;
            $user = Auth::user();
            $this->validate($request,[
                'name' => 'required',
                'add_Students'=>'required',
            ]);
            $classroom->classroom_name = $request->name;
            $classroom->classroom_owner=$user->getAuthIdentifier();
            // $classroom->active = $request->active;

            $addStudents = $request->input('add_Students');
            $classroom->save();
            foreach ($addStudents as $student){
                $classroom->users()->attach($student);
            }

            //Creator of a classroom is automatically a member
            $classroom->users()->attach($user->getAuthIdentifier());

            return redirect()->route('home');
        }
        catch (Exception $ex)
        {
            return redirect()->route('classroom.create')->withErrors("Cannot create because of error: " . $ex. "!");
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function myClassrooms(){
        $classrooms = Auth::user()->classrooms;
        return view('classroom.myclassrooms')->with('classrooms', $classrooms);
    }

    public function edit($id)
    {
        $classroom = Classroom::find($id);

        if ($classroom != null) {
            return view('classroom.edit')->with('classroom', $classroom);
        }
        else {
            return redirect()->route('classroom.index')
                ->withErrors('Classroom with id=' . $id . ' not found!');
        }
    }

    public function editMembers($id){
        $classroom = Classroom::find($id);
        if ($classroom != null) {
            return view('classroom.editmembers')->with('classroom', $classroom);
        }
        else {
            return redirect()->route('classroom.myclassrooms')
                ->withErrors('Classroom with id=' . $id . ' not found!');
        }
    }

    public function editChallenges($id){
        $classroom = Classroom::find($id);

        if ($classroom != null) {
            return view('classroom.editChallenges')->with('classroom', $classroom);
        }
        else {
            return redirect()->route('classroom.myClassrooms')
                ->withErrors('Classroom with id=' . $id . ' not found!');
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
        $classroom = Classroom::find($id);
        $classroom->classroom_name = $request->name;
        $classroom->active = $request->active;
        $classroom->save();
        return redirect()->route('classroom.myclassrooms');
    }

    public function updateMembers(Request $request, $id){
        $classroom = Classroom::find($id);
        $this->validate($request,[
            'addmember'=>'required',
        ]);
        $addStudents = $request->input('addmember');
        $classroom->save();
        foreach($addStudents as $student){
            $classroom->users()->attach($student);
        }
        return redirect()->route('classroom.myclassrooms');
    }

    public function deleteMembers(Request $request, $id){
        $classroom = Classroom::find($id);
        $this->validate($request,[
            'deletemembers'=>'required',
        ]);
        $deletestudents = $request->input('deletemembers');
        $classroom->save();
        foreach($deletestudents as $student){
            $classroom->users()->detach($student);
        }
        return redirect()->route('classroom.myclassrooms');
    }

    public function updateChallenges(Request $request, $id){

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $classroom = Classroom::find($id);
        if(Auth::user()->hasRole("admin"))
        {
            if($classroom->active == "0") {
                $challenges = $classroom->challenges;
                $members = $classroom->users;
                foreach ($challenges as $c){
                    $classroom->challenges()->detach($c);
                }
                foreach ($members as $m){
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

        return redirect()->route('classroom.index')->with('success','Successfully deleted classroom!');
    }

    //Associate a multitude of challenges with a classroom
    public function attach(Request $request, $id)
    {
        $classroom = Classroom::find($id);

        $this->validate($request,[
            'add_Challenges'=>'required',
        ]);
        $challenges = $request->input('add_Challenges');

        foreach ($challenges as $c) {
            $challenge=Challenge::find($c);
            if($challenge->active == true)
                $classroom->challenges()->attach($c);
        }

        return redirect()->route('classroom.myclassrooms');
    }

    public function detach(Request $request,$id){
        $classroom = Classroom::find($id);

        $challenges = $request->input('remove_Challenges');

        foreach ($challenges as $c){
            $classroom->challenges()->detach($c);
        }
        return redirect()->route('classroom.myclassrooms');
    }


    public function disabled(){
        try {
            $classrooms = Classroom::all();
        }
        catch (Exception $ex){
            return redirect('classroom.disabled')->withErrors("No db");
        }
        return view('classroom.disabled')->with('classrooms',$classrooms);
    }

    public function restore($id){
        $classroom = Classroom::find($id);
        $classroom->active = "1";
        $classroom->save();
        $classrooms = Classroom::all();
        return view('classroom.disabled')->with('classrooms',$classrooms);
    }

    public function showChallenges($id){
        $classroom = Classroom::find($id);

        if ($classroom != null) {
            return view('classroom.showchallenges')->with('classroom', $classroom);
        }
        else {
            return redirect()->route('classroom.myClassrooms')
                ->withErrors('Classroom with id=' . $id . ' not found!');
        }
    }

}
