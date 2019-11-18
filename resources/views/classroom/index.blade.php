@extends('layouts.app')
@section('content')
    <h2>My classrooms</h2>
    <p>

    </p>

    @if(sizeof($classrooms) > 0)
        <table border="1">
            <thead>
            <th>Id</th>
            <th>Name</th>
            <th>Owner</th>
            </thead>
            <tbody>
            @foreach($classrooms as $classroom)
                <tr>
                    <td>{{ $classroom->id }}</td>
                    <td>{{ $classroom->classroom_name }}</td>
                    <td>{{ $classroom->classroom_owner }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <h3>No challenges yet!</h3>
    @endif
    <br>
    @if(Auth::user()->isAdmin(Auth::user()->userrole)==true)
        <a href="{{route('classroom.create')}}" class="btn btn-success">Add new challenge</a>
    @endif
@endsection
