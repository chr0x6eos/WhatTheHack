@extends('layouts.app')
@section('content')
<h2>Add a new challenge</h2>
<form method="post" action="{{ route('challenges.store') }}" id="challengeform">
@csrf
    <p>
        <strong>Challenge name:</strong>
        <input type="text" name="name">
    </p>
    <p>
        <strong>Challenge description:</strong>
        <br>
        <textarea form="challengeform" name="description"></textarea>
    </p>
    <p>
        <strong>Difficulty:</strong>
        <select name="difficulty">
            <option value="easy" selected="selected">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
    </p>
    <p>
        <strong>Category:</strong>
        <select name="category">
            <option value="misc" selected="selected">misc</option>
            <option value="web">web</option>
            <option value="forensic">forensic</option>
            <option value="reversing">reversing</option>
            <option value="crypto">crypto</option>
            <option value="pwn">pwn</option>
        </select>
    </p>
    <p>
        <strong>Author:</strong>
        @if(Auth::user()->hasRole("admin"))<input type="text" name="author" value="{{ Auth::user()->username }}">
        @else
            {{ Auth::user()->username }}
        @endif
    </p>
    <p>
        <strong>Status:</strong>
        <select name="active">
            <option value="1" selected="selected">Enabled</option>
            <option value="0">Disabled</option>
        </select>
    </p>
    <p>
        <strong>Feasible solution (optional):</strong>
        <br>
        <textarea form="challengeform" name="targetSolution"></textarea>
    </p>
    <p>
        <strong>Docker Image ID (optional):</strong>
        <input type="text" name="imageID">
    </p>
    <p>
        <?php //TODO:Implement file upload ?>
        <strong>Attachments (optional):</strong>
            <input type="text" name="attachments">
    </p>
    <p>
        <button type="submit" class="btn btn-success">Submit</button>
        <a href="{{ route('challenges.index') }} " class="btn btn-danger">Cancel</a>
    </p>
</form>
<br>
@endsection
