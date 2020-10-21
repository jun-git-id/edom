// Set new default font family and font color to mimic Bootstrap's default styling



// Bar Chart Example

let arr_nilai = [3.75, 2.5, 3.5, 2];

Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
var ctx = document.getElementById("myBarChart");



var charObj = {
    type: 'bar',
    data: {
        labels: ['Andfafaf', 'adfaf', 'adfaf', 'adfafa'],
        datasets: [{
            label: "IPD",
            backgroundColor: "rgba(54, 162, 235, 0.5)",
            hoverBackgroundColor: "rgba(54, 162, 235)",
            borderColor: "rgb(54, 162, 235)",
            data: arr_nilai,
        }],
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            xAxes: [{
                time: {
                    unit: 'kelas'
                },
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 6
                },
                maxBarThickness: 50,
            }],
            yAxes: [{
                ticks: {
                    min: 0,
                    max: 4,
                    padding: 10,
                    // Include a dollar sign in the ticks

                },
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }],
        },
        legend: {
            display: false
        },
        tooltips: {
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,

        },
    }
};

charObj.data.labels[0] = "Andi";
var myBarChart = new Chart(ctx, charObj);
