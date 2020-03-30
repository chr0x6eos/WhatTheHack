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
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
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
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,

                /*subtitles: [{
                    text: "GBP & EUR to INR",
                    fontSize: 18
                }],*/
                axisY: {
                    includeZero: true,
                    title: "Points",
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

