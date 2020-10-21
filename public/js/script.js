const average = arr => arr.reduce((sume, el) => sume + el, 0) / arr.length;

const ambilKesimpulan = nilai => {
    let kesimpulan = '';

    if (nilai == 4) {
        kesimpulan = 'Baik Sekali';
    } else if (nilai >= 3) {
        kesimpulan = 'Baik';
    } else if (nilai >= 2) {
        kesimpulan = 'Cukup';
    } else if (nilai >= 1) {
        kesimpulan = 'Buruk';
    }

    return kesimpulan;
}

const tampilTahunAk = url => {
    $.get(url, data => {
        tampilData(data);
    });

    const tampilData = data => {
        data.forEach(dt => {
            let sel = '';

            if (dt.id == data[data.length - 1].id) {
                sel = 'selected';
            }

            const el = `<option value="${dt.id}" ${sel} >${dt.tahun} ${dt.ganjil_genap}</option>`;
            $('#tahun_akademik').append(el);
            console.log('a');
        });
    };


};

const randomWarna = () => {
    const color = [
        'primary',
        'secondary',
        'success',
        'danger',
        'warning',
        'info',
        'dark'
    ];



    return color[Math.floor(Math.random() * 6)];
}

const buatGrafikBar = (label, data) => {

    let data2 = [];

    data.forEach( dt => {
        data2.push(toPersenGrafik(dt));
    });


    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';
    var ctx = document.getElementById("myBarChart");
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: label,
            datasets: [{
                label: "nilai",
                backgroundColor: "rgba(54, 162, 235, 0.5)",
                hoverBackgroundColor: "rgba(54, 162, 235)",
                borderColor: "rgb(54, 162, 235)",
                data: data2,
                borderWidth: 1,
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
                        max: 100,
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

    });
};

const buatGrafikLine = (label, data) => {

    let data2 = [];

    data.forEach( dt => {
        data2.push(toPersenGrafik(dt));
    });


    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';
    var ctx = document.getElementById("myBarChart");
    var myBarChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: label,
            datasets: [{
                label: "nilai",
                fill: false,
                backgroundColor: 'rgb(54, 162, 235)',
                hoverBackgroundColor: "rgba(54, 162, 235)",
                borderColor: 'rgb(54, 162, 235)',
                data: data2,
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
                        max: 100,
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
        },
    });


};

const toPersen = nilai => (nilai*25).toString().substr(0,5) + '%';
const toPersenGrafik = nilai => parseFloat((nilai*25).toString().substr(0,5));
