@extends('layouts.app')
@section('content')

        <div class="container" style="float: right; width: 15%; margin-right: 40px; position: relative;">
            <div class="card" style="background-color: dimgrey">
                <div class="card-header ">Solved</div>
                <div class="card-body">
                    <div class="form-group row"><input type="submit" class="btn " id="solved_button" value="Solved" /></div>
                    <div class="form-group row"><input type="submit" class="btn " id="unsolved_button" value="Unsolved" /></div>
                    <div class="form-group row "><input type="submit" class="btn " id="all_button" value="All" /></div>
                </div>
            </div>
            <div class="card" style="background-color: dimgrey">
                <div class="card-header ">Filter</div>
                <div class="card-body">
                    <div class="form-group row"><input type="submit" class="btn " id="misc_button" value="misc" /></div>
                    <div class="form-group row"><input type="submit" class="btn " id="web_button" value="Web Exploitation" /></div>
                    <div class="form-group row"><input type="submit" class="btn " id="forensic_button" value="Forensic" /></div>
                    <div class="form-group row"><input type="submit" class="btn " id="reversing_button" value="Reverse Engineering" /></div>
                    <div class="form-group row"><input type="submit" class="btn " id="crypto_button" value="Cryptography" /></div>
                    <div class="form-group row"><input type="submit" class="btn " id="pwn_button" value="Binary Exploitation" /></div>
                </div>
            </div>
        </div>
        <div class="container" style="width: 1000px">
            <div class="container my-shuffle-container row " style="width: 100%; margin-right: 40px">
                @foreach($challenges as $challenge)
                    @if($challenge->active==1)
                        @if(Auth::user()->solvedChallenge($challenge->id))
                            @php//TODO:Change colour to match theme @endphp
                            <div class="card picture-item   " data-groups='["solved","{{$challenge->category}}"]' style="background-color: dimgrey" >
                                <div class="card-header" style="background-color: #0E9A00"><a href="{{route('challenges.show',$challenge->id)}}">{{$challenge->name}} - {{$challenge->category}}</a>
                                <p style="float: right;color: black">Total solves: {{$challenge->solves($challenge->id)}} ~solved</p>
                                </div>
                                <div class="card-body">
                                    Author: {{$challenge->author}}
                                    <br>
                                    {{$challenge->description}}
                                </div>
                            </div>
                        @else
                            <div class="picture-item" data-groups='["unsolved","{{$challenge->category}}"]' style="background-color: dimgrey">
                                <div class="card-header"><a href="{{route('challenges.show',$challenge->id)}}">{{$challenge->name}} - {{$challenge->category}}</a>
                                    <p style="float: right;color: black">Total solves: {{$challenge->solves($challenge->id)}}</p>
                                </div>
                                <div class="card-body">
                                    Author: {{$challenge->author}}
                                    <br>
                                    {{$challenge->description}}
                                </div>
                            </div>
                        @endif
                    @endif
                 @endforeach
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
        </div>
    </div>
@endsection
