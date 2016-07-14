function DailyAverageController()
{
    this.segment = $('#dailyAverageSegment');
    this.lineChart = new LineChart('dailyAverageChart')
}

DailyAverageController.prototype.renderChart = function()
{
    this.lineChart.addData('01.01.2015', 10);
    this.lineChart.addData('02.01.2015', 15);
    this.lineChart.addData('03.01.2015', 12);
    this.lineChart.addData('04.01.2015', 12);
    this.lineChart.addData('05.01.2015', 20);
    this.lineChart.addData('06.01.2015', 22);
    this.lineChart.addData('07.01.2015', 21);
    this.lineChart.render();
    this.segment.removeClass('loading');
};