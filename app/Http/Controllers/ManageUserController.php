<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{

    //constructor
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    //return the manageuser view with all users
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

    //change the ativity status of a specific users
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

        //change the userrole
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
}
