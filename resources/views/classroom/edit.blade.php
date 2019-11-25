@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>You are in this classroom: {{$classroom->classroom_name}}</h1>
        <h2>Add Challenges</h2>
        <div class="col-2">
            <form method="post" >
                @csrf

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
                                    <input type="checkbox" name="add_Challenges" value="{{$c->id}}">
                                </td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled"   >
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <p>
                    <button type="submit"  class="btn btn-success">
                        Add Challenges
                    </button>
                    <a href="{{ route('classroom.index') }}" class="btn btn-danger">
                        Cancel
                    </a>
                </p>
            </form>
        </div>
    </div>
@endsection
