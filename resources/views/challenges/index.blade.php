@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header font-weight-bold">{{ __('Challenges') }}</div>

            <div class="card-body">
                @if(isset($challenges) && sizeof($challenges) > 0)

                    <table border="1"class="table table-bordered">
                        <thead>
                        <th>Name</th>
                        <th>Difficulty</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th colspan="1">Info</th>
                        @if(Auth::user() && ( Auth::user()->hasRole("admin") || Auth::user()->hasRole("teacher")))
                            <th colspan="1">Edit</th>
                        @endif
                        </thead>
                        <tbody>
                        @foreach($challenges as $challenge)
                            @if(Auth::user()->solvedChallenge($challenge->id))
                                {{//TODO:Change colour to match theme }}
                                <tr bgcolor="#f0f8ff">
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
                                @if(Auth::user() && ( Auth::user()->hasRole("admin") || Auth::user()->hasRole("teacher")))
                                    <td>
                                        <a href="{{ route('challenges.edit', $challenge->id) }}" class="btn btn-outline-danger">Edit</a>
                                    </td>
                                @endif
                             </tr>
                            @else
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
                                    @if(Auth::user() && ( Auth::user()->hasRole("admin") || Auth::user()->hasRole("teacher")))
                                        <td>
                                            <a href="{{ route('challenges.edit', $challenge->id) }}" class="btn btn-outline-danger">Edit</a>
                                        </td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h3>No challenges yet!</h3>
                @endif
                <br>
                {{-- Only administrators or teachers are allowed to edit challenges --}}
                @if(Auth::user() && ( Auth::user()->hasRole("admin") || Auth::user()->hasRole("teacher")))
                    <a href="{{ route('challenges.create') }}" class="btn btn-info">Add new challenge</a>
                @endif
            </div>
@endsection
