@extends('layouts.app')
@section('content')
    <div id="landing" class="py-5">
        <div data-test="container" class="container">
            <div data-test="row" class="row">
                <div data-test="col" class="col-xl-9">
                        <div data-test="card" class="card-body">
                            <p class="h2" style="display: inline"> Challenges of Classroom </p><p class="h2" style="color: #01C851; display: inline">{{$classroom->classroom_name}}</p>
                            <br>
                            <br>
                            @foreach($classroom->challenges as $challenge)
                                @if($challenge->active==1)
                                    @if(Auth::user()->solvedChallenge($challenge->id))
                                        <div class="card">
                                            <a href="{{route('challenges.show',$challenge->id)}}" class="challenge_name_link">
                                                <div class="card-header">
                                                    <p class="challenge_name">{{$challenge->name}}</p>
                                                    <p class="total_solves">Total solves: {{$challenge->solves($challenge->id)}}</p>
                                                </div>
                                            </a>
                                            <div class="card-body">
                                                <p>Author: {{$challenge->author}}</p>
                                                <p>{{$challenge->description}}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="card">
                                            <a href="{{route('challenges.show',$challenge->id)}}">
                                                <div class="card-header">
                                                    <p style="display: inline">{{$challenge->name}}</p>
                                                    <p class="total_solves">Total solves: {{$challenge->solves($challenge->id)}}</p>
                                                </div>
                                            </a>
                                            <div class="card-body">
                                                <p>Author: {{$challenge->author}}</p>
                                                <p>{{$challenge->description}}</p>
                                            </div>
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
    <script>
        $(document).ready(function() {
            var Shuffle = window.Shuffle;
            var element = document.querySelector('.my-shuffle-container');
            var sizer = element.querySelector('.my-sizer-element');
            var shuffleInstance = new Shuffle(element, {
                itemSelector: '.picture-item',
            });
            $("#solved_button").on("click", function () {
                shuffleInstance.filter("solved");
            });
            $("#unsolved_button").on("click", function () {
                shuffleInstance.filter("unsolved");
            });
            $("#all_button").on("click", function () {
                shuffleInstance.filter();
            });
            $("#misc_button").on("click", function () {
                shuffleInstance.filter("misc");
            });
            $("#web_button").on("click", function () {
                shuffleInstance.filter("web");
            });
            $("#forensic_button").on("click", function () {
                shuffleInstance.filter("forensic");
            });
            $("#crypto_button").on("click", function () {
                shuffleInstance.filter("crypto");
            });
            $("#pwn_button").on("click", function () {
                shuffleInstance.filter("pwn");
            });
            $("#reversing_button").on("click", function () {
                shuffleInstance.filter("reversing");
            });
        });
    </script>
@endsection


