@extends('layouts.app')
@section('content')
<h2>Report an issue:</h2>
    <div class="container">
        <form method="post" action="{{ route('support.submit', ['challenge' => $challenge]) }}" id="supportform">
        @csrf
            <p>
                <strong>Challenge-ID:</strong>
                <br>
                {{ $challenge->id }}
            </p>
            <p>
                <strong>Subject:</strong>
                <br>
                Support Request to challenge: {{ $challenge->name }}
            </p>
            <p>
                <strong>Message:</strong>
                <br>
                <textarea class="text" form="supportform" name="message"></textarea>
            </p>
            <p>
                <button type="submit" class="btn btn-success">Submit</button>
                <a href="{{ route('challenges.show', $challenge->id) }}" class="btn btn-info">Go Back</a>
            </p>
        </form>
    </div>
@endsection
