@extends('layouts.app')
@section('content')
<h2>Edit {{ $challenge->name }}</h2>
<form method="post" action="{{ route('challenges.update', $challenge)}}" id="challengeform">
    @csrf
    @method('patch')
    <p>
        <strong>Challenge name:</strong>
        <input type="text" name="name" value="{{ $challenge->name }}">
    </p>
    <p>
        <strong>Challenge description:</strong>
        <br>
        <textarea form="challengeform" name="description">{{ $challenge->description }}</textarea>
    </p>
    <p>
        <strong>Flag:</strong>
        <input type="text" name="flag" value="{{ $challenge->flag }}">
    </p>
    <p>
        <strong>Difficulty:</strong>
        <select name="difficulty">
            <option value="tatu" @if($challenge->difficulty=="tatu") selected="selected" @endif>TaTü</option>
            <option value="easy" @if($challenge->difficulty=="easy") selected="selected" @endif>Easy</option>
            <option value="medium" @if($challenge->difficulty=="medium") selected="selected" @endif>Medium</option>
            <option value="hard" @if($challenge->difficulty=="hard") selected="selected" @endif>Hard</option>
            <option value="insane" @if($challenge->difficulty=="insane") selected="selected" @endif>Insane</option>
        </select>
    </p>
    <p>
        <strong>Category:</strong>
        <select name="category">
            <option value="misc" @if($challenge->category=="misc")selected="selected"@endif>misc</option>
            <option value="web" @if($challenge->category=="web")selected="selected"@endif>web</option>
            <option value="forensic" @if($challenge->category=="forensic")selected="selected"@endif>forensic</option>
            <option value="reversing" @if($challenge->category=="reversing")selected="selected"@endif>reversing</option>
            <option value="crypto" @if($challenge->category=="crypto")selected="selected"@endif>crypto</option>
            <option value="pwn" @if($challenge->category=="pwn")selected="selected"@endif>pwn</option>
        </select>
    </p>
    <p>
        <strong>Author:</strong>
        {{-- Only allow admins to edit authors --}}
        @if(Auth::user()->hasRole("admin"))<input type="text" name="author" value="{{ $challenge->author }}">
        @else {{$challenge->author}}
        @endif
    </p>
    <p>
        <strong>Feasible solution (optional)</strong>
        <br>
        <textarea form="challengeform" name="targetSolution">{{ $challenge->targetSolution }}</textarea>
    </p>
    <p>
        <strong>Hint:</strong>
        <br>
        <textarea form="challengeform" name="hint">{{ $challenge->hint }}</textarea>
    </p>
    <p>
        <strong>Docker Image ID (optional):</strong>
        <input type="text" name="imageID" value="{{ $challenge->imageID }}">
    </p>
    <p>
        <strong>Status:</strong>
        <select name="active">
        <option value="1" @if($challenge->active) selected="selected"@endif>Enabled</option>
        <option value="0" @if(!$challenge->active) selected="selected"@endif>Disabled</option>
        </select>
    </p>
    <p>
        <button type="submit" class="btn btn-info">Update</button>
        <a href="{{ route('challenges.index') }} " class="btn btn-danger">Cancel</a>
    </p>
</form>
<br>
@endsection
