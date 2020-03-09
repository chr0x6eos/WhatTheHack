@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('My Profile') }}</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right font-weight-bold">
                                {{ __('Username:') }}
                            </label>
                            <label class="col-md-7 col-form-label text-md-center">{{ $user->username }}</label>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right font-weight-bold">
                                {{ __('E-Mail:') }}
                            </label>
                            <label class="col-md-7 col-form-label text-md-center">{{ $user->email }}</label>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right font-weight-bold">
                                {{ __('E-Mail verified at:') }}
                            </label>
                            <label class="col-md-7 col-form-label text-md-center">@if($user->email_verified_at){{ $user->email_verified_at }}@else Not yet verified!@endif</label>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right font-weight-bold">
                                {{ __('Userrole:') }}
                            </label>
                            <label class="col-md-7 col-form-label text-md-center">{{ $user->userrole }}</label>
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
                        <div class="container">
                            <div class="row">
                                <div class="col-sm text-md-center">
                                    <a href="{{ route('profile.showChangePWForm') }}" class="btn btn-info">Change Password</a>
                                </div>
                                <div class="col-sm text-md-center">
                                    <a href="{{ route('profile.showChangeEMForm') }}" class="btn btn-info">Change E-Mail</a>
                                </div>
                                @if(!$user->hasRole('admin'))
                                    <form method="POST" action="{{ route('profile.delete', $user->id) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn bg-danger" onclick="return confirm('Do you really want to delete your user account?')">Delete Account</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
