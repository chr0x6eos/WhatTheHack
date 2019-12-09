@extends('layouts.app')
@section('content')
    @if($challenge)
    @if($challenge->files != "")
    <div class="content">
        <h1>Attention!</h1>
        <p>Please note this challenge already has a file uploaded!</p>
        <p>If you upload a new file the old one will be replaced!</p>
    </div>
    @endif
    <div class="content">
        <h1>Upload files here</h1>
        <p>Please note that only .zip files are allowed!<br>
        Furthermore, the maximum file size is 100MB.<br>
        Uploading may take some time! Please wait once you pressed the upload button.</p>
        <br>
        <h4>Files for {{$challenge->name}}</h4>
        <form action="{{ route('challenges.upload', $challenge->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="file" class="custom-file-input" id="inputGroupFile04">
                    <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Upload</button>
                </div>
            </div>
        </form>
    </div>
    {{--
    <script>
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone",{
            maxFilesize: 100,
            acceptedFiles: ".zip,.rar",
        });
        myDropzone.on("sending", function(file, xhr, formData) {
            formData.append("_token", CSRF_TOKEN);
        });
    </script>
    --}}
    @else
        <h1>Error occurred!</h1>
        <p>Go <a href="{{route('challenges.index')}}">back</a> and try again!</p>
    @endif
@endsection
