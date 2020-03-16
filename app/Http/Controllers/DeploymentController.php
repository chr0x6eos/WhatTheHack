<?php

namespace App\Http\Controllers;

use App\Deployment;
use Illuminate\Http\Request;

class DeploymentController extends Controller
{
    //This view is currently WIP, and is not used at the moment

    //Only allow authenticated users
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
        //Show
        try
        {
            //TODO: Implement with multiple deployment
            $deployment = Deployment::first();
            return view('deployment.index')->with('deployment',$deployment);
        }
        catch (Exception $ex)
        {
            return redirect()->route('home')->withErrors("Could not connect to database!");
        }
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //start virtual instance
    public function start($id)
    {
        try
        {
            $deploy = Deployment::findOrFail($id);
            $output = 'Started with output: ' . $deploy->start();
            return view('deployment.index')->with(['deployment' => $deploy,'output' => $output]);
        }
        catch (\Exception $exception)
        {
            //TODO: VDI - Exception handling
        }
    }

    //stop virtual instance
    public function stop($id)
    {
        try
        {
            $deploy = Deployment::findOrFail($id);
            $output = 'Stopped with output: ' . $deploy->stop();
            return view('deployment.index')->with(['deployment' => $deploy,'output' => $output]);
        }
        catch (\Exception $exception)
        {
            //TODO: VDI - Exception handling
        }
    }
}
