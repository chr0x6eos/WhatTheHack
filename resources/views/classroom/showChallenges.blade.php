@extends('layouts.app')
@section('content')
    <div id="landing" class="py-5">
        <div data-test="container" class="container">
            <div data-test="row" class="row">
                <div data-test="col" class="col-md-12 mb7">
                    <div class="card card_showChallenge">
                        <div data-test="card" class="card-body">
                            <p class="h2" style="display: inline"> Challenges of Classroom </p><p class="h2" style="color: #01C851; display: inline">{{$classroom->classroom_name}}</p>
                            <br>
                            <br>
                            @foreach($classroom->challenges as $challenge)
                                @if($challenge->active)
                                    @if(Auth::user()->solvedChallenge($challenge->id))
                                        <a href="{{route('challenges.show',$challenge->id)}}" class="challenge_name_link">
                                        <div class="card">
                                            <a href="{{route('challenges.show',$challenge->id)}}" class="challenge_name_link">
                                                <div class="card-header challenges-header bg-success">
                                                    <p class="challenge_name">{{$challenge->name}}</p>
                                                    <p class="total_solves">Total solves: {{$challenge->solves($challenge->id)}}</p>
                                                </div>
                                            </a>
                                            <a href="{{route('challenges.show',$challenge->id)}}" class="challenge_name_link">
                                            <div class="card-body">
                                                <p>Author: {{$challenge->author}}</p>
                                                <p>{{$challenge->description}}</p>
                                            </div>
                                            </a>
                                        </div>
                                    @else
                                        <div class="card">
                                            <a href="{{route('challenges.show',$challenge->id)}}">
                                                <div class="card-header challenges-header">
                                                    <p class="challenge_name">{{$challenge->name}}</p>
                                                    <p class="total_solves">Total solves: {{$challenge->solves($challenge->id)}}</p>
                                                </div>
                                            </a>
                                            <a href="{{route('challenges.show',$challenge->id)}}">
                                            <div class="card-body">
                                                <p>Author: {{$challenge->author}}</p>
                                                <p>{{$challenge->description}}</p>
                                            </div>
                                            </a>
                                        </div>
                                        <br>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
