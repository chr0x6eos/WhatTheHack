@extends('layouts.app')

@section('content')
<div id="landing" class="py-5">
    <div data-test="container" class="container">
        <div data-test="row" class="row">
            <div data-test="col" class="col-md-12 mb7">
                <div class="card card_showChallenge">
                    <div data-test="card" class="card-body">
                        <p class="h2" style="display: inline">Edit the classroom </p><p class="h2" style="color: #01C851; display: inline">{{$classroom->classroom_name}}</p>
                        <br>
                        <br>
                        <div class="col-2">
                            <form method="post" action="{{ route('classroom.update', $classroom->id)}}" >
                                @csrf
                                <p>
                                    <strong>ID</strong>
                                    <input type="text" disabled="disabled" name="id" value="{{ $classroom->id }}"/>
                                </p>
                                <p>
                                    <strong>Name</strong>
                                    <input type="text" name="name" value="{{ $classroom->classroom_name }}"/>
                                </p>
                                <p>
                                <strong>Status:</strong>
                                <select name="active">
                                    <option value="1" @if($classroom->active == "1") selected="selected" @endif>Enabled</option>
                                    <option value="0" @if($classroom->active == "0") selected="selected" @endif>Disabled</option>
                                </select>
                                </p>
                                <br>
                                <p>
                                    <button type="submit"  class="btn btn-success">
                                        Submit
                                    </button>
                                </p>
                                <p>
                                    <a href="{{ route('classroom.myClassrooms') }}" class="btn btn-danger">
                                        Cancel
                                    </a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
