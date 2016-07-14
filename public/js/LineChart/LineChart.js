function LineChart(canvasId)
{
    this.canvasId = canvasId;

    this.data = {
        labels: [],
        datasets: [
            {
                label: "Tagesdurchschnitt",
                data: []
            }
        ]
    };

    this.chart = undefined;
}

LineChart.prototype.addData = function (label, value)
{
    this.data.labels.push(label);
    this.data.datasets[0].data.push(value);
};

LineChart.prototype.render = function ()
{
    var ctx = $("#" + this.canvasId);
    this.chart = new Chart(ctx, {
        type: 'line',
        data: this.data
    });
};