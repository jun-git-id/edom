Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
var ctx = document.getElementById("myBarChart");

var objBar = {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: "nilai",
            backgroundColor: "rgba(54, 162, 235, 0.5)",
            hoverBackgroundColor: "rgba(54, 162, 235)",
            borderColor: "rgb(54, 162, 235)",
            data: [],
        }],
    }
};




