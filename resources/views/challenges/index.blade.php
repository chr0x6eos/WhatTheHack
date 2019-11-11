@extends('layouts.app')
@section('content')
<h2>Challenges</h2>
@if(sizeof($challenges) > 0)
<table border="1">
<thead>
<th>Id</th>
<th>Name</th>
<th>Difficulty</th>
<th>Author</th>
<th colspan="1">Actions</th>
</thead>
<tbody>
    @foreach($challenges as $challenge)
    <tr>
        <td>{{ $challenge->id }}</td>
        <td>{{ $challenge->name }}</td>
        <td>{{ $challenge->difficulty }}</td>
        <td>{{ $challenge->author }}</td>
        <td>
            <a href="{{ route('challenges.show', $challenge->id) }}" class="btn btn-info">More info</a>
        </td>
    </tr>
    @endforeach
</tbody>
</table>
    @else
    <h3>No challenges yet!</h3>
@endif
<br>
@if(Auth::user()->isAdmin(Auth::user()->userrole)==true)
<a href="{{route('challenges.create')}}" class="btn btn-success">Add new challenge</a>
@endif
@endsection
