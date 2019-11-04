@extends('layouts.app')
@section('content')
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
        <strong>Docker-Image-ID:</strong>
        {{ $challenge->imageID }}
    </p>
    <p>
        <strong>Attachments:</strong>
        <br>
        {{ $challenge->attachments }}
    </p>
    <!-- //TODO:Only allow below to admin user-->
    @if(Auth::user()->isAdmin(Auth::user()->userrole)==true)
    <a href="{{ route('challenges.edit', $challenge->id) }}" class="btn btn-info">Edit</a><br>
    <form method="POST" action="{{ route('challenges.destroy',$challenge->id) }}">
    @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="{{ route('challenges.index') }}" class="btn">Go back</a>
    </form>
    @endif
@endsection
