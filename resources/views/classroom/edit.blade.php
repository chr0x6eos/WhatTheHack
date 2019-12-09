@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>You are in this classroom: {{$classroom->classroom_name}}</h1>
        <div class="col-2">
            <form method="post" action="{{ route('classroom.update', $classroom) }}">
                @csrf
                @method('patch')
                <h3>Edit classroom information</h3>
                <p>
                    <strong>ID</strong>
                    <input type="text" disabled="disabled" name="id" value="{{ $classroom->id }}"/>
                </p>
                <p>
                    <strong>Name</strong>
                    <input type="text" name="name" value="{{ $classroom->classroom_name }}"/>
                </p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled"   >
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <br>
                <br>
                <p>
                    <button type="submit"  class="btn btn-success">
                        Submit
                    </button>
                </p>
                <p>
                    <a href="{{ route('classroom.myclassrooms') }}" class="btn btn-danger">
                        Cancel
                    </a>
                </p>
            </form>
        </div>
    </div>
@endsection
