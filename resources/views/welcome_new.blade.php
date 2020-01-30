@extends('layouts.app')
@section('content')
    <div id="landing" class="py-5">
        <div data-test="container" class="container">
            <div data-test="row" class="row">
                <div data-test="col" class="col-md-6 pt-5">
                    <h1 class="mt-5">Built for <div class="Typist d-inline typist"><span style="color: #00c851">hackers</span><span class="Cursor Cursor--blinking">_</span></div></h1></div>
                <div data-test="col" class="col-md-6">

                    <div data-test="card" class="card text-dark">
                        <div class="Toastify"></div>
                        <div data-test="card" class="card-body">
                            <h2>Login</h2>
                            <form method="POST" action="{{ route('login') }}" class="text-center p-5">
                                @csrf
                                <div class="md-form form-lg md-outline">
                                    <input id="login" data-test="input" name="login" type="text" class="form-control form-control-lg" value="" required autofocus>
                                    <label class="label-form" data-error="" data-success="" id="">Email or Username</label>

                                    @if ($errors->has('username') || $errors->has('email') || $errors->has('active'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                                <strong>{{ $errors->first('active') }}</strong>
                                            </span>
                                    @endif

                                </div>
                                <div class="md-form form-lg md-outline">
                                    <input id="password" data-test="input" name="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" value="" required autocomplete="current-password">
                                    <label class="label-form" data-error="" data-success="" id="">Password</label>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-around">
                                    <div>
                                        <!-- Remember me -->
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="remember" {{ old('remember') ? 'checked' : '' }} name="remember">
                                            <label class="custom-control-label" for="remember">Remember me</label>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- Forgot password -->
                                        @if (Route::has('password.request'))
                                        <a class="card-link" href="{{ route('password.request') }}">Forgot password?</a>
                                        @endif
                                    </div>
                                </div>
                                <button class="btn btn-success btn-block my-4" type="submit">Log in</button>
                                <p>Not a member?
                                    <a class="card-link" href="{{ route('register') }}">Register</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
