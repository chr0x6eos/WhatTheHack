@extends('layouts.app')
@section('content')
    <div id="landing" class="py-5">
    <div class="container" >
        <div class="row justify-content-center">
            <div class="col-mg-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile: ') }}{{ $user->username }}</div>
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    <div class="card-body">
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
                        <br>
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
                <br>
            </div>
        </div>
    </div>
    </div>
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title:{
                    text: "Your points over time"
                },
                /*subtitles: [{
                    text: "GBP & EUR to INR",
                    fontSize: 18
                }],*/
                axisY: {
                    includeZero: true,
                    prefix: "points"
                },
                legend:{
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                toolTip: {
                    shared: true
                },
                data: [
                    {
                        type: "line",
                        name: "web",
                        showInLegend: "true",
                        xValueType: "dateTime",
                        xValueFormatString: "YYYY-MMM-dd HH",
                        yValueFormatString: "#,##0.##",
                        dataPoints: <?php echo json_encode(Auth::user()->progress("web",$user->id),JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "line",
                        name: "pwn",
                        showInLegend: "true",
                        xValueType: "dateTime",
                        xValueFormatString: "YYYY-MMM-dd HH",
                        yValueFormatString: "#,##0.##",
                        dataPoints: <?php echo json_encode(Auth::user()->progress("pwn",$user->id),JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "line",
                        name: "forensic",
                        showInLegend: "true",
                        xValueType: "dateTime",
                        xValueFormatString: "YYYY-MMM-dd HH",
                        yValueFormatString: "#,##0.##",
                        dataPoints: <?php echo json_encode(Auth::user()->progress("forensic",$user->id),JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "line",
                        name: "reverse-engineering",
                        showInLegend: "true",
                        xValueType: "dateTime",
                        xValueFormatString: "YYYY-MMM-dd HH",
                        yValueFormatString: "#,##0.##",
                        dataPoints: <?php echo json_encode(Auth::user()->progress("reverse-engineering",$user->id),JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "line",
                        name: "miscellaneous",
                        showInLegend: "true",
                        xValueType: "dateTime",
                        xValueFormatString: "YYYY-MMM-dd HH",
                        yValueFormatString: "#,##0.##",
                        dataPoints: <?php echo json_encode(Auth::user()->progress("miscellaneous",$user->id),JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "line",
                        name: "cryptography",
                        showInLegend: "true",
                        xValueType: "dateTime",
                        xValueFormatString: "YYYY-MMM-dd HH:mm",
                        yValueFormatString: "#,##0.##",
                        dataPoints: <?php echo json_encode(Auth::user()->progress("cryptography",$user->id),JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            chart.render();

            function toggleDataSeries(e){
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                }
                else{
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        }
    </script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
@endsection
