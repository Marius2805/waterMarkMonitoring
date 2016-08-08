@include('header')
<body>
    <script>
        var app;
        $( document ).ready(function() {
            app = new Application();
            app.dailyAverageController.renderChart();
            app.hourlyAverageController.renderChart();
        });
    </script>
    <div class="page">
        <h1 class="ui header">
            <img class="image" id="header-icon" src="/images/waterDrop.svg">{{env('PAGE_TITLE', 'Watermark monitoring')}}
        </h1>
        @if($gapWarning)
            <div class="ui orange icon message">
                <i class="warning icon"></i>
                <div class="content">
                    <div class="header">
                        Die letzte Messung fand vor mehr als {{$gapWarningLimit}} Minuten statt!
                    </div>
                </div>
            </div>
        @endif
        <div class="ui {{$waterMarkWarning ? 'red' : 'green'}} icon message">
            <i class="{{$waterMarkWarning ? 'warning' : 'checkmark'}} icon"></i>
            <div class="content">
                <div class="header">
                    Der aktuelle Wassertand beträgt {{$lastMeasurementValue}} cm
                </div>
                <p>Die letzte Messung fand vor {{$lastMeasurementOffset}} Minuten statt</p>
            </div>
        </div><br>
        <div class="ui one column grid">
            <div class="column">
                <div class="segment ui">
                    <h3 class="icon header"><i class="time icon" id="hourlyAverageSegment"></i>Heute</h3>
                    <canvas id="hourlyAverageChart" width="700" height="260"></canvas>
                </div>
            </div>
            <div class="column">
                <div class="loading segment ui" id="dailyAverageSegment">
                    <h3 class="icon header"><i class="calendar icon"></i>Tagesdurchschnitt</h3><br>
                    <canvas id="dailyAverageChart" width="700" height="260"></canvas>
                </div>
            </div>
        </div>
    </div>
</body>