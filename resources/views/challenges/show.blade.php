@extends('layouts.app')
@section('content')

    <div class="container" >
        <div class="card">
            @php{{//TODO:Make the Solved appear on the right side of the card header}} @endphp
            @if(Auth::user()->solvedChallenge($challenge->id))
                <div class="card-header font-weight-bold bg-success">{{$challenge->name}} - Solved</div>
            @else
                <div class="card-header font-weight-bold ">{{$challenge->name}}</div>
            @endif

            <div class="card-body">
                <div class="table">
                <table id="tablePreview" class="table table-borderless">
                    <tbody>
                    <tr>
                        <td class="table_01">Challenge Description:</td>
                        <td class="table_02">{{ $challenge->description}}</td>
                    </tr>
                    <tr>
                        <td class="table_01">Difficulty:</td>
                        <td class="table_02">{{ $challenge->difficulty}}</td>
                    </tr>
                    <tr>
                        <td class="table_01">Category:</td>
                        <td class="table_02">{{ $challenge->category}}</td>
                    </tr>
                    <tr>
                        <td class="table_01">Author:</td>
                        <td class="table_02">{{ $challenge->author}}</td>
                    </tr>
                    <tr>
                        <td class="table_01">Status</td>
                        @if($challenge->active)
                            <td class="table_02">Enabled</td>
                        @endif
                        @if(!$challenge->active)
                            <td class="table_02">Disabled</td>
                        @endif
                    </tr>
                    @if($challenge->hint)
                    <tr>
                        <td class="table_01">Hint</td>
                        <td class="table_02">{{ $challenge->hint}}</td>
                    </tr>
                    @endif
                    @if($challenge->imageID)
                        <tr>
                        <td class="table_01">Docker Image ID:</td>
                        <td class="table_02">{{ $challenge->imageID}}</td>
                    </tr>
                    @endif
                    @if($challenge->files)
                        <tr>
                            <td class="table_01">Resource:</td>
                            <td class="table_02"><a href="{{route('challenges.download', $challenge->id)}}">Download</a></td>
                        </tr>

                    @endif
                    </tbody>
                    <!--Table body-->
                </table>
                </div>
                <div class="form-group row">
                            <form method="POST" action="{{ route('challenges.flag', $challenge->id) }}" class="text-center p-5">
                                @csrf
                                <div class="md-form form-lg md-outline">
                                    <input id="flag" data-test="input" name="flag" type="text" class="form-control form-control-lg" value="" required autofocus>
                                    <label class="label-form" data-error="" data-success="" id="">Flag</label>
                                </div>
                                <button type="submit"class="btn btn-success btn-block my-4">Submit flag</button>
                            </form>
                    <div>
                        @if(isset($gifPath) && $gifPath != "")
                            <img src="{{ $gifPath }}" style="height: 250px">
                        @endif
                    </div>
                </div>
                <a href="{{ route('challenges.index') }}" class="btn btn-outline-dark">Go back</a>
                <a href="{{ route('support.create', $challenge->id) }}" class="btn btn-outline-dark">Report a problem</a>
            </div>
            </div>
        </div>
    </div>
@endsection


