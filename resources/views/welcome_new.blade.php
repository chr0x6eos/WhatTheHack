@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">{{ __('Information') }}</div>

        <div class="card-body">
            <p>Go to <a href="{{ route('home') }}">Home</a></p>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="card-title">Welcome!</h2>
                    <p class="card-text">Welcome to whatthehack!  </p>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-primary btn-sm">More Info</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
