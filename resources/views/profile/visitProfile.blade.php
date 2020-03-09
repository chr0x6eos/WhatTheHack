@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('User Profile of ') }}
                        <strong>{{ $user->username }}</strong>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right font-weight-bold">
                                {{ __('Username:') }}
                            </label>
                            <label class="col-md-7 col-form-label text-md-center">{{ $user->username }}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right font-weight-bold">
                                {{ __('Global Points:') }}
                            </label>
                            <label class="col-md-7 col-form-label text-md-center">{{ $user->points }}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right font-weight-bold">
                                {{ __('Level:') }}
                            </label>
                            <label class="col-md-7 col-form-label text-md-center">{{ App\User::calculateLevel($user->points) }}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right font-weight-bold">
                                {{ __('Level Progress:') }}
                            </label>
                            <label class="col-md-7 col-form-label text-md-center">{{ App\User::calculateProgress1($user->points) }}/{{ App\User::calculateProgress2($user->points)." Points" }}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right font-weight-bold">
                                {{ __('Rank:') }}
                            </label>
                            <label class="col-md-7 col-form-label text-md-center">{{ App\User::calculateRank($user->points) }}</label>
                        </div>
                        <div>
                            <a href="{{ route('home') }}" class="btn btn-outline-dark">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

