@extends('layouts.app')
@section('content')
<div class="container">
    @if(Auth::user()->hasRole("admin"))
    <div class="row justify-content-center">
        <div class="row mt-5" style="width: 100%">
            <div class="col-md-4 mb-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="card-title">Users</h2>
                        <p class="card-text">
                            <img src="{{URL::asset('/images/icons/username.png')}}" width="30px"> Total: {{App\User::count()}}
                        </p>
                        <p class="card-text">
                            <img src="{{URL::asset('/images/icons/active.jpg')}}" width="30px"> Active: {{App\User::countActiveUsers()}}
                        </p>
                        <p class="card-text">
                            <img src="{{URL::asset('/images/icons/disabled.png')}}" width="30px"> Disabled: {{App\User::countDisabledUsers()}}
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="/manage/users" class="btn btn-success btn-sm" style="width: 100%">User Management</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="card-title">Classrooms</h2>
                        <p class="card-text">
                            <img src="{{URL::asset('/images/icons/classroom.png')}}" width="30px"> Total: {{App\Classroom::count()}}
                        </p>
                        <p class="card-text">
                            <img src="{{URL::asset('/images/icons/active.jpg')}}" width="30px"> Active: {{App\Classroom::countActiveClassrooms()}}
                        </p>
                        <p class="card-text">
                            <img src="{{URL::asset('/images/icons/disabled.png')}}" width="30px"> Disabled: {{App\Classroom::countDisabledClassrooms()}}
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="/classroom" class="btn btn-success btn-sm" style="width: 100%">Classroom Management</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="card-title">Challenges</h2>
                        <p class="card-text">
                            <img src="{{URL::asset('/images/icons/challenge.png')}}" width="30px"> Total: {{App\Challenge::count()}}
                        </p>
                        <p class="card-text">
                            <img src="{{URL::asset('/images/icons/active.jpg')}}" width="30px"> Active: {{App\Challenge::countActiveChallenges()}}
                        </p>
                        <p class="card-text">
                            <img src="{{URL::asset('/images/icons/disabled.png')}}" width="30px"> Disabled: {{App\Challenge::countDisabledChallenges()}}
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="/challenges" class="btn btn-success btn-sm" style="width: 100%">Challenge Management</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-9" style="width: 100%">
            <div class="col-md-12 mb-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="card-title">Top 5</h2>
                        <div class="card-body">
                            <table id="rankingTable" class="table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th class="th-sm">Username</th>
                                    <th class="th-sm">Overall Points</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(\App\Http\Controllers\RankingController::getTopFive()->ranked as $key => $value)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>{{ $value->username }}</td>
                                        <td>{{ $value->points }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="/ranking" class="btn btn-success btn-sm" style="width: 100%">Show Global Ranking</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(Auth::user()->hasRole("student") || Auth::user()->hasRole("teacher"))
            <div class="row justify-content-center">
                <div class="row mt-5" style="width: 100%">
                    <div class="col-md-4 mb-9">
                        <div class="card h-100">
                            <div class="card-body">
                                <h2 class="card-title">Profile</h2>
                                <p class="card-text"><img src="{{URL::asset('/images/icons/username.png')}}" width="30px"> {{ Auth::user()->username }}</p>
                                <p class="card-text"><img src="{{URL::asset('/images/icons/xp.png')}}" width="30px"> Level {{ App\User::calculateLevel(Auth::user()->points) }}</p>
                                <p class="card-text"><img src="{{URL::asset('/images/icons/level.png')}}" width="30px"> {{ App\User::calculateProgress1(Auth::user()->points) }}/{{ App\User::calculateProgress2(Auth::user()->points) }} Points</p>
                                <p class="card-text"><img src="{{URL::asset('/images/icons/rank.png')}}" width="30px"> {{ App\User::calculateRank(Auth::user()->points) }}</p>

                            </div>
                            <div class="card-footer">
                                <a href="{{ route('profile.show') }}"  class="btn btn-success btn-sm" style="width: 100%">My Profile</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-9">
                        <div class="card h-100">
                            <div class="card-body">
                                <h2 class="card-title">My Classrooms</h2>
                                <p class="card-text">
                                    @foreach(Auth::user()->classrooms as $classroom)
                                        @if($classroom->active == "1")
                                            <tr>
                                                <p class="card-text">
                                                    <td><img src="{{URL::asset('/images/icons/classroom.png')}}" width="30px"> {{ $classroom->classroom_name }}</td>
                                                </p>
                                            </tr>
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('classroom.myclassrooms') }}" class="btn btn-success btn-sm" style="width: 100%">My Classrooms</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-9">
                        <div class="card h-100">
                            <div class="card-body">
                                <h2 class="card-title">Activity</h2>

                                @foreach(\App\Activity::latest(5) as $a)
                                    <p class="card-text">✓ {{$a}}</p>
                                @endforeach
                            </div>
                            <div class="card-footer">
                                <a href="#" class="btn btn-success btn-sm" style="width: 100%">All Activities</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5" style="width: 100%">
                    <div class="col-md-12 mb-7">
                        <div class="card h-100">
                            <div class="card-body">
                                <h2 class="card-title">Top 5</h2>
                                <div class="card-body">
                                    <table id="rankingTable" class="table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th class="th-sm">Username</th>
                                            <th class="th-sm">Overall Points</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Http\Controllers\RankingController::getTopFive()->ranked as $key => $value)
                                                <tr>
                                                    <td>{{ $key }}</td>
                                                    <td>{{ $value->username }}</td>
                                                    <td>{{ $value->points }}</td>
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="/ranking" class="btn btn-success btn-sm" style="width: 100%">Show Global Ranking</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
</div>
@endsection
