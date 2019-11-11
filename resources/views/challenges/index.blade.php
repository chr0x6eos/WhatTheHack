@extends('layouts.app')
@section('content')
<h2>Challenges</h2>
@if(isset($challenges) && sizeof($challenges) > 0)
<table border="1">
<thead>
<th>Name</th>
<th>Difficulty</th>
<th>Author</th>
<th>Active</th>
<th colspan="1">Edit</th>
</thead>
<tbody>
    @foreach($challenges as $challenge)
    <tr>
        <td>{{ $challenge->name }}</td>
        <td>{{ $challenge->difficulty }}</td>
        <td>{{ $challenge->author }}</td>
        <td>@if($challenge->active)
                Enabled
            @else
                Disabled
            @endif
        </td>
        <td><a href="{{ route('challenges.show', $challenge->id) }}" class="btn btn-info">More info</a></td>
    </tr>
    @endforeach
</tbody>
</table>
    @else
    <h3>No challenges yet!</h3>
@endif
<br>
{{-- Only administrators or teachers are allowed to edit challenges --}}
@if(Auth::user() && ( Auth::user()->hasRole("admin") || Auth::user()->hasRole("teacher")))
<a href="{{ route('challenges.create') }}" class="btn btn-success">Add new challenge</a>
@endif
    <br>
@if(isset($errors) && sizeof($errors) != 0)
    @if(sizeof($errors) > 1)
        <h4>Errors occurred:</h4>
    @else
        <h4>Error occurred:</h4>
    @endif
    <p>
    @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
        @endforeach
        </p>
        @endif
@endsection
