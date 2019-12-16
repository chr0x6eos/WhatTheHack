@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    Welcome {{Auth::user()->username}}!
                    <p>
                        <br>
                        Go here to view the <a href="{{ route('challenges.index') }}">Challenges</a>.
                        <br>
                        <br>
                        @if (Auth::user()->isTeacher(Auth::user()->userrole)==true || Auth::user()->isAdmin(Auth::user()->userrole)==true)

                            <a href="{{route('classroom.create')}} " class="btn btn-info" >Create classroom</a>
                        @endif
                        <br>
                        Go here to view the <a href="{{ route('classroom.myclassrooms') }}">Classrooms</a>.
                    </p>
                        <p>
                        @if (Auth::user()->userrole == 'admin')
                            <p>Go here to access the <a href="{{ route('classroom.index') }}">management classroom</a> page.</p>
                            @endif
                        </p>

                    @if (Auth::user()->userrole == 'admin')
                    <p>Go here to access the <a href="{{ route('manageuser.index') }}">User Management</a>.</p>
                    @endif

                    <p>
                        @if (Auth::user()->userrole == 'admin')
                            <p>Go here to access the <a href="{{ route('classroom.disabled') }}">disabled classrooms</a>.</p>
                            @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
