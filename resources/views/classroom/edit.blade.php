@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>You are in this classroom: {{$classroom->classroom_name}}</h1>
        <div class="col-2">
            <form method="post" action="{{ route('classroom.update', $classroom->id)}}" >
                @csrf
                <h3>Edit classroom information</h3>
                <p>
                    <strong>ID</strong>
                    <input type="text" disabled="disabled" name="id" value="{{ $classroom->id }}"/>
                </p>
                <p>
                    <strong>Name</strong>
                    <input type="text" name="name" value="{{ $classroom->classroom_name }}"/>
                </p>

                <h1>Disable this classroom</h1>
                <strong>Status:</strong>
                <select name="active">
                    <option value="1" @if($classroom->active == "1") selected="selected" @endif>Enabled</option>
                    <option value="0" @if($classroom->active == "0") selected="selected" @endif>Disabled</option>
                </select>

                <ul class="list-unstyled">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                </ul>
                <br>
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
@endsection
