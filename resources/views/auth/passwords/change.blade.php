@extends('layouts.app')
@section('content')
    <div id="landing" class="py-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><strong> {{ __('Change Password') }} </strong></div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.change') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="currentPassword" class="col-md-4 col-form-label text-md-right">{{ __('Current Password:') }}</label>

                                <div class="col-md-4">
                                    <input id="currentPassword" type="password" class="form-control @error('currentPassword') is-invalid @enderror" name="currentPassword" required autocomplete="currentPassword" autofocus>

                                    @error('currentPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password:') }}</label>

                                <div class="col-md-4">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="confirmPassword" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password:') }}</label>

                                <div class="col-md-4">
                                    <input id="confirmPassword" type="password" class="form-control" name="confirmPassword" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-4 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Change Password') }}
                                    </button>
                                    <a href="{{ route('profile.show') }}" class="btn bg-light btn-outline-dark">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection



