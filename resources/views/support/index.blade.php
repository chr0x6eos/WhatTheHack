@extends('layouts.app')
@section('content')
    <div class="container" >
        <div class="card">
            <div class="card-header">{{ __('Report a Problem of Challenge ') }} {{ $challenge->id}} </div>
            <div class="card-body">
                <form method="post" action="{{ route('support.submit', ['challenge' => $challenge]) }}" id="supportform">
                    @csrf
                    <p>
                        <strong>Subject:</strong>
                        <br>
                        Support Request to challenge: {{ $challenge->name }}
                    </p>
                    <p>
                        <strong>Message:</strong>
                        <br>
                        <textarea class="text" form="supportform" name="message" style="width: 300px"></textarea>
                    </p>
                    <p>
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('challenges.show', $challenge->id) }}" class="btn bg-light btn-outline-dark">Go Back</a>
                    </p>
                </form>
            </div>
        </div>
        <br>
    </div>
@endsection
