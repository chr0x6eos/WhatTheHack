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
                    This is my userrole {{Auth::user()->userrole}}

                        @if (Auth::user()->isTeacher(Auth::user()->userrole)==true || Auth::user()->isAdmin(Auth::user()->userrole)==true)

                            <a href="{{route('classroom.create')}} " class="btn btn-success" >Create classroom</a>

                        @endif
                    {{Auth::user()->username}} is logged in!
                    <p>
                        You are logged in!
                        <br>
                        Go here to view the <a href="{{ route('challenges.index') }}" class="btn">Challenges</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
