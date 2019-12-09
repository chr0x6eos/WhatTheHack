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
    @if(Auth::user()->hasRole("admin") || Auth::user()->isAuthor($challenge->author))
    <p>
        <strong>Flag:</strong>
        {{ $challenge->flag }}
    </p>
    @endif
    <p>
        <strong>Difficulty:</strong>
        {{ $challenge->difficulty }}
    </p>
    <p>
        <strong>Category:</strong>
        {{ $challenge->category }}
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

    @if(Auth::user()->hasRole("admin") || Auth::user()->isAuthor($challenge->author))
        @if($challenge->targetSolution)
        <p>
            <strong>Feasible solution:</strong>
            <br>
            {{ $challenge->targetSolution }}
        </p>
        @endif
    @endif
    @if($challenge->hint)
    <p>
        <strong>Hint:</strong>
        <br>
        {{ $challenge->hint }}
    </p>
    @endif
    @if($challenge->imageID)
    <p>
        <strong>Docker-Image-ID:</strong>
        {{ $challenge->imageID }}
    </p>
    @endif
    @if($challenge->files)
    <p>
        <strong>Resource:</strong>
        <br>
        <a href="{{route('challenges.download', $challenge->id)}}">Download</a>
    </p>
    @endif

    @if(Auth::user()->hasRole("admin") || Auth::user()->isAuthor($challenge->author))
        <a href="{{ route('challenges.edit', $challenge->id) }}" class="btn btn-info">Edit</a>
        <a href="{{ route('challenges.files', $challenge->id) }}" class="btn btn-secondary">Files</a>
        @if(!$challenge->active)
        <form method="POST" action="{{ route('challenges.destroy',$challenge->id) }}">
        @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        @endif
    @endif
        <a href="{{ route('challenges.index') }}" class="btn btn-info">Go back</a>
        <a href="{{ route('support.create', $challenge->id) }}" class="btn btn-outline-dark">Report a problem</a>
</div>
@endsection


