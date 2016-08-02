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
        <div class="ui green icon message">
            <i class="checkmark icon"></i>
            <div class="content">
                <div class="header">
                    Der aktuelle Wassertand beträgt 21.29 cm
                </div>
                <p>Die letzte Messung fand vor 10 Minuten statt</p>
            </div>
        </div>
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