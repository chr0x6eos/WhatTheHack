@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card row " style="float: left; width: 150px; margin-right: 30px">
            <div class="card-header">Filter</div>
            <div class="card-body">
                <div class="form-group row"><input type="submit" class="btn btn-elegant" id="solved_button" value="Solved" /></div>
                <div class="form-group row"><input type="submit" class="btn btn-elegant" id="unsolved_button" value="Unsolved" /></div>
                <div class="form-group row"><input type="submit" class="btn btn-elegant" id="all_button" value="All" /></div>
            </div>
        </div>
        <div class="container my-shuffle-container row " style="width: 100%; margin-right: 40px">
            @foreach($challenges as $challenge)
                @if($challenge->active==1)
                    @if(Auth::user()->solvedChallenge($challenge->id))
                        @php//TODO:Change colour to match theme @endphp
                        <div class="card picture-item " data-groups='["solved"]' style="background-color: #0C9A9A">
                            <div class="card-header"><a href="{{route('challenges.show',$challenge->id)}}">{{$challenge->name}} - {{$challenge->category}}</a>
                            <p style="float: right;color: black">Total solves: {{$challenge->solves($challenge->id)}}</p>
                            </div>
                            <div class="card-body">
                                Author: {{$challenge->author}}
                                <br>
                                {{$challenge->description}}
                            </div>
                        </div>
                    @else
                        <div class="picture-item" data-groups='["unsolved"]'>
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
                });
            </script>
        </div>
    </div>
@endsection
