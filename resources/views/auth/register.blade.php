@extends('layouts.app')
@section('content')
    <div id="landing" class="py-5">
        <div data-test="container" class="container">
            <div data-test="row" class="row">
                <div data-test="col" class="col-md-6 pt-5">
                    <h1 class="mt-5">Built for <div class="Typist d-inline typist"><span>en</span><span class="Cursor Cursor--blinking">_</span></div></h1></div>
                <div data-test="col" class="col-md-6">

                    <div data-test="card" class="card text-dark">
                        <div class="Toastify"></div>
                        <div data-test="card" class="card-body">
                            <h2>Register</h2>
                            <form method="POST" action="{{ route('register') }}" class="text-center p-5">
                                @csrf
                                <div class="md-form form-lg md-outline">
                                    <input id="username" data-test="input" name="username" type="text" class="form-control form-control-lg {{ $errors->has('username') ? ' is-invalid' : '' }}" value="" required autofocus>
                                    <label class="label-form" data-error="" data-success="" id="">Username</label>

                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="md-form form-lg md-outline">
                                    <input id="email" data-test="input" name="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"  required autocomplete="email">
                                    <label class="label-form" data-error="" data-success="" id="">Email</label>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="md-form form-lg md-outline">
                                    <input id="password" data-test="input" name="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" value="" required autocomplete="new-password">
                                    <label for="password" class="label-form" data-error="" data-success="" id="">Password</label>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="md-form form-lg md-outline">
                                    <input id="password-confirm" data-test="input" name="password-confirm" type="password" class="form-control form-control-lg @error('password-confirm') is-invalid @enderror" value="" required autocomplete="new-password">
                                    <label for="password-confirm" class="label-form" data-error="" data-success="" id="">Confirm Password</label>

                                    @error('password-confirm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <button class="btn btn-success btn-block my-4" type="submit">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
