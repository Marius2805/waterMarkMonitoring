function HourlyAverageController()
{
    this.segment = $('#hourlyAverageSegment');
    this.lineChart = new LineChart('hourlyAverageChart', 'stündlicher Durchschnitt')
}

HourlyAverageController.prototype.renderChart = function()
{
    $.ajax({
        type: 'GET',
        url: '/api/hourly-average',
        success: function (data) {
            $.each(data, function (key, value) {
                var date = moment(value.date);
                app.hourlyAverageController.lineChart.addData(date.format('H') + ':00', value.value);
            })

            app.hourlyAverageController.lineChart.render();
            app.hourlyAverageController.segment.removeClass('loading');
        }
    });
};