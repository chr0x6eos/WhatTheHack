@extends('layouts.app')
@section('content')
<div>
    <h2>Challenge details</h2>
    <p>
        <strong>ID:</strong>
        {{ $challenge->id }}
    </p>
    <p>
        <strong>Name:</strong>
        {{ $challenge->name }}
    </p>
    <p>
        <strong>Description:</strong>
        <br>
        {{ $challenge->description }}
    </p>
    <p>
        <strong>Difficulty:</strong>
        {{ $challenge->difficulty }}
    </p>
    <p>
        <strong>Author:</strong>
        {{ $challenge->author }}
    </p>
    <p>
        <strong>Status:</strong>
        @if($challenge->active)
            Enabled
        @else
            Disabled
        @endif
    </p>
    @if($challenge->targetSolution)
    <p>
        <strong>Feasible solution:</strong>
        <br>
        {{ $challenge->targetSolution }}
    </p>
    @endif
    @if($challenge->imageID)
    <p>
        <strong>Docker-Image-ID:</strong>
        {{ $challenge->imageID }}
    </p>
    @endif
    @if($challenge->attachments)
    <p>
        <strong>Attachments:</strong>
        <br>
        {{ $challenge->attachments }}
    </p>
    @endif

    @if(Auth::user()->hasRole("admin") || Auth::user()->isAuthor($challenge->author))
        <a href="{{ route('challenges.edit', $challenge->id) }}" class="btn btn-info">Edit</a>

        @if(!$challenge->active)
        <form method="POST" action="{{ route('challenges.destroy',$challenge->id) }}">
        @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        @endif
    @endif
        <a href="{{ route('challenges.index') }}" class="btn btn-light">Go back</a>
        <br>
</div>
@endsection
