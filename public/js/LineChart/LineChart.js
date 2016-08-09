function LineChart(canvasId, label)
{
    this.canvasId = canvasId;

    this.data = {
        labels: [],
        datasets: [
            {
                label: label,
                borderColor: "rgba(47, 47, 50, 0.4)",
                pointBorderColor: "rgba(47, 47, 50, 0.6)",
                data: []
            }
        ]
    };

    this.options = {
        scales: {
            yAxes: [{
                display: true,
                ticks: {
                    beginAtZero: true   // minimum value will be 0.
                }
            }]
        }
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
        data: this.data,
        options: this.options
    });
};