@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">{{ __('Information') }}</div>

        <div class="card-body">
            <p>Go to <a href="{{ route('home') }}">Home</a></p>
        </div>
    </div>
</div>
@endsection
