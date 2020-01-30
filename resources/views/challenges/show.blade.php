@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="card">
            @php{{//TODO:Make the Solved appear on the right side of the card header}} @endphp
            @if(Auth::user()->solvedChallenge($challenge->id))
                <div class="card-header font-weight-bold bg-success">{{ __('Challenge details')}} - Solved</div>
            @else
                <div class="card-header font-weight-bold ">{{ __('Challenge details') }}</div>
            @endif

            <div class="card-body">
                <div class="form-group row">
                    <form id="challengeform">
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-md-right" >
                                {{ __('Challenge name:') }}
                            </label>
                            <div class="col-md-6">
                                <input id="challenge_name" type="text" disabled class="form-control" name="name" required autofocus value="{{ $challenge->name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-4 col-form-label text-md-right">
                                {{ __('Challenge description:') }}
                            </label>
                            <div class="col-md-6">
                                <textarea id="description "form="challengeform" disabled name="description" class="form-control">{{ $challenge->description }}</textarea>
                            </div>
                        </div>
                        @if(Auth::user()->hasRole("admin") || Auth::user()->isAuthor($challenge->author))
                            <div class="form-group row">
                                <label for="flag" class="col-sm-4 col-form-label text-md-right">
                                    {{ __('Flag:') }}
                                </label>
                                <div class="col-md-6">
                                    <input id="flag" type="text" disabled class="form-control" name="flag" required autofocus value="{{ $challenge->flag }}">
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="difficulty" class="col-sm-4 col-form-label text-md-right">
                                {{ __('Difficulty:') }}
                            </label>
                            <div class="col-md-6">
                                <select id="difficulty "name="difficulty" disabled class="form-control">
                                    <option value="tatu" @if($challenge->difficulty=="tatu") selected="selected" @endif>TaTü</option>
                                    <option value="easy" @if($challenge->difficulty=="easy") selected="selected" @endif>Easy</option>
                                    <option value="medium" @if($challenge->difficulty=="medium") selected="selected" @endif>Medium</option>
                                    <option value="hard" @if($challenge->difficulty=="hard") selected="selected" @endif>Hard</option>
                                    <option value="insane" @if($challenge->difficulty=="insane") selected="selected" @endif>Insane</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category" class="col-sm-4 col-form-label text-md-right">
                                {{ __('Category:') }}
                            </label>
                            <div class="col-md-6">
                                <select id="category "name="category" disabled class="form-control">
                                    <option value="misc" @if($challenge->category=="misc")selected="selected"@endif>misc</option>
                                    <option value="web" @if($challenge->category=="web")selected="selected"@endif>web</option>
                                    <option value="forensic" @if($challenge->category=="forensic")selected="selected"@endif>forensic</option>
                                    <option value="reversing" @if($challenge->category=="reversing")selected="selected"@endif>reversing</option>
                                    <option value="crypto" @if($challenge->category=="crypto")selected="selected"@endif>crypto</option>
                                    <option value="pwn" @if($challenge->category=="pwn")selected="selected"@endif>pwn</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="author" class="col-sm-4 col-form-label text-md-right">
                                {{ __('Author:') }}
                            </label>
                            <div class="col-md-6">
                                <input id="author" type="text" disabled name="author" class="form-control" value="{{ $challenge->author }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-sm-4 col-form-label text-md-right">
                                {{ __('Status:') }}
                            </label>
                            <div class="col-md-6">
                                <select id="status" disabled name="active" class="form-control">
                                    <option value="1" @if($challenge->active) selected="selected"@endif>Enabled</option>
                                    <option value="0" @if(!$challenge->active) selected="selected"@endif>Disabled</option>
                                </select>
                            </div>
                        </div>
                        @if(Auth::user()->hasRole("admin") || Auth::user()->isAuthor($challenge->author))
                            @if($challenge->targetSolution)
                                <div class="form-group row">
                                    <label for="targetSolution" class="col-sm-4 col-form-label text-md-right">
                                        {{ __('Feasible Solution (optional:)') }}
                                    </label>
                                    <div class="col-md-6">
                                        <textarea id="targetSolution "form="challengeform" disabled name="targetSolution" class="form-control">{{ $challenge->targetSolution }}</textarea>
                                    </div>
                                </div>
                            @endif
                        @endif
                        @if($challenge->hint)
                            <div class="form-group row">
                                <label for="hint" class="col-sm-4 col-form-label text-md-right">
                                    {{ __('Hint:') }}
                                </label>
                                <div class="col-md-6">
                                    <textarea id="hint "form="challengeform" name="hint" disabled  class="form-control">{{ $challenge->hint }}</textarea>
                                </div>
                            </div>
                        @endif
                        @if($challenge->imageID)
                            <div class="form-group row">
                                <label for="imageID" class="col-sm-4 col-form-label text-md-right">
                                    {{ __('Docker Image ID (optional):') }}
                                </label>
                                <div class="col-md-6">
                                    <input id="imageID" type="text" class="form-control" disabled name="imageID" required autofocus value="{{ $challenge->imageID }}">
                                </div>
                            </div>
                        @endif
                        @if($challenge->files)
                            <p>
                                <strong>Resource:</strong>
                                <br>
                                <a href="{{route('challenges.download', $challenge->id)}}">Download</a>
                            </p>
                        @endif
                    </form>

                    <div class="form-group-row">
                        @if(Auth::user()->hasRole("admin") || Auth::user()->isAuthor($challenge->author))
                            <a href="{{ route('challenges.edit', $challenge->id) }}" class="btn btn-info col">Edit</a>
                            <a href="{{ route('challenges.files', $challenge->id) }}" class="btn btn-secondary col">Upload Files</a>
                            @if(!$challenge->active)
                                <form method="POST" action="{{ route('challenges.destroy',$challenge->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @endif
                        @endif

                        <div>
                            <form method="POST" action="{{ route('challenges.flag',$challenge->id) }}">
                                @csrf

                                <input id="flag" data-test="input" name="flag" type="text" class="form-control form-control-lg {{ $errors->has('flag') ? ' is-invalid' : '' }}" value="" required autofocus>
                                <label class="label-form" data-error="" data-success="" id="">Flag:</label>

                                @if ($errors->has('flag'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('flag') }}</strong>
                                    </span>
                                @endif

                                <button type="submit" class="btn btn-success">Submit Flag</button>
                            </form>
                        </div>
                            <div>
                                @if(isset($gifPath) && $gifPath != "")
                                    <img src="{{ $gifPath }}" style="height: 350px; width: 450px;">
                                @endif
                            </div>
                    </div>
                </div>
            </div>
            <div>
                <a href="{{ route('classroom.myclassrooms') }}" class="btn btn-outline-secondary">Go back</a>
                <a href="{{ route('support.create', $challenge->id) }}" class="btn btn-outline-dark">Report a problem</a>
            </div>
        </div>
    </div>
@endsection


