@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>You are in this classroom: {{$classroom->classroom_name}}</h1>
        <div class="col-2">
            <form method="post" action="{{ route('classroom.attach', $classroom->id)}}" >
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

                <!-- <h3>Add challenges</h3>
                <table border="1">
                    <thead>
                    <th>Challenge id</th>
                    <th>Challenge name</th>
                    <th>Add</th>
                    </thead>
                    <tbody>
                    @foreach (\App\Challenge::all() as $c)
                            <tr>
                                <td>
                                    {{$c->id}}
                                </td>
                                <td>
                                    {{$c->name}}
                                </td>
                                <td>
                                    <input type="checkbox" name="add_Challenges[]" value="{{$c->id}}">
                                </td>
                            </tr>
                    @endforeach
                    </tbody>
                </table> -->
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
