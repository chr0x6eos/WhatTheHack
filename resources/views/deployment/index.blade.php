@extends('layouts.app')
@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
<div class="card-header font-weight-bold">{{ __('My Profile') }}</div>
<div class="card-body">

    @if(!$deployment || $deployment == null)
        <h1>No VMs in database! Please fill DB first!</h1>
    @endif
    <div class="form-group row col-md-8 offset-md-4">
        <h1 class="h1-responsive">Start instance</h1>
        <h2 class="h2-responsive"> @if($deployment) {{ $deployment->name }} @endif </h2>
    </div>

        <div class="form-group row col-md-8 offset-md-4">
        <form method="post" action="{{ route('deploy.start', $deployment) }}">
            @csrf
            <div class="form-group row">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-outline-success">Start</button>
                </div>
            </div>
        </form>
        <form method="post" action="{{ route('deploy.stop', $deployment) }}">
            @csrf
            <div class="form-group row">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-outline-danger">Stop</button>
                </div>
            </div>
        </form>
            <div class="form-group row">
                <div class="col-md-8 offset-md-4">
                    <a href="{{ route('home') }} " class="btn btn-outline-grey">Back</a>
                </div>
            </div>
        </div>
    @if(isset($output) && $output != "")
    <p class="align-content-center">{{ $output }}</p>
    @endif
    </div>

</div>
</div>
</div>
</div>
@endsection
