function DailyAverageController()
{
    this.segment = $('#dailyAverageSegment');
    this.lineChart = new LineChart('dailyAverageChart', "täglicher Durchschnittt")
}

DailyAverageController.prototype.renderChart = function()
{
    $.ajax({
        type: 'GET',
        url: '/api/daily-average',
        success: function (data) {
            $.each(data, function (key, value) {
                var date = moment(value.date);
                app.dailyAverageController.lineChart.addData(date.format('DD.MM'), value.value);
            })

            app.dailyAverageController.lineChart.render();
            app.dailyAverageController.segment.removeClass('loading');
        }
    });
};