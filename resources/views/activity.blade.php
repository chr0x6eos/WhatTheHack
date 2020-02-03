@extends ('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Recent Activity
            </div>
                <div class="card-body">
                    @foreach(\App\Activity::latest() as $a)
                        <p class="card-text">✓ {{$a}}</p>
                    @endforeach
                </div>
        </div>
    </div>
@endsection
