<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:admin');
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
            $users = User::all();
        }
        catch (Exception $ex)
        {
            return redirect()->route('manageuser.index')
                ->withErrors(['mu_c_list_user_error' => 'Invalid request. (MU_C_LIST_USER_ERROR)']);
        }

        return view('manageuser.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($request->type == 'active_status')
        {
            if ($user->active)
            {
                $user->active = 0;
            }
            else
            {
                $user->active = 1;
            }

            $user->save();

        }
        elseif ($request->type == 'userrole_change')
        {
            if ($request->userrole == 'student' || $request->userrole == 'teacher' || $request->userrole == 'admin')
            {
                $user->userrole = $request->userrole;
            }
            else
            {
                return redirect()->route('manageuser.index')
                    ->withErrors(['mu_c_invalid_userrole_change' => 'Invalid request. (MU_C_INVALID_USERROLE_CHANGE)']);
            }

            $user->save();
        }
        else
        {
            return redirect()->route('manageuser.index')
                ->withErrors(['mu_c_invalid_update_request' => 'Invalid request. (MU_C_INVALID_UPDATE_REQUEST)']);
        }

        return redirect()->route('manageuser.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
