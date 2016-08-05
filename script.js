////////////// DEFAULTS //////////////

Chart.defaults.global.animation.duration = 2500;
Chart.defaults.global.defaultFontFamily = "'Noto Sans', 'Source Sans Pro', -apple-system";
Chart.defaults.global.defaultFontSize = 15;
Chart.defaults.global.title.fontSize = 19;


////////////// TEMPERATURE //////////////

var ctx = document.getElementById("24hourchart");
var rain_chance = document.getElementById("24hourrain");
var max_temp = Math.max.apply(null, tempOfHour) + 3;
var min_temp = Math.min.apply(null, tempOfHour) - 3;

var myChart = new Chart(ctx, {
type: 'line',
// defaultFontColor: '#ffffff',
data: {
    labels: timeOfDay,
datasets: [
    {
        label: "Temp",
        fill: true,
        lineTension: 0.3,
        backgroundColor: "rgba(214,44,44,0.1)",
        borderColor: "rgba(214, 44, 44, 1)",
        borderCapStyle: 'bitt',
        borderDash: [],
        borderWidth: 9,
        borderDashOffset: 0.0,
        borderJoinStyle: 'miter',
        pointBorderColor: "rgba(214, 44, 44, 1)",
        pointBackgroundColor: "#041127",
        pointBorderWidth: 1,
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(75,192,192,1)",
        pointHoverBorderColor: "rgba(220,220,220,1)",
        pointHoverBorderWidth: 2,
        pointRadius: 4,
        pointStyle: 'circle',
        pointHitRadius: 10,
        data: tempOfHour,
        maintainAspectRatio: true
    }
]
},
options: {
    legend: {
        display: false,
    },
    title: {
        display: true,
        text: 'Temperature'
    },
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero:false,
                suggestedMax:max_temp,
                suggestedMin:min_temp,
            },
            gridLines: {
            	color:'rgba(255,255,255,0.1)'
            },
        }],
        xAxes: [{
            ticks: {
                maxTicksLimit:5
            }
        }],
    },
    global: {
        defaultFontColor:'#eee'
    }
}
});



////////////// PERCIPITATION //////////////


var barChartData = {
    labels: timeOfDay,
    datasets: [{
        type: 'line',
        label: 'Precip%',
        fill: true,
        lineTension: 0.3,
        backgroundColor: "rgba(75,192,192,0.1)",
        borderColor: "rgba(75,192,192,1)",
        borderCapStyle: 'butt',
        borderDash: [],
        borderWidth: 9,
        borderDashOffset: 0.0,
        borderJoinStyle: 'miter',
        pointBorderColor: "rgba(75,192,192,1)",
        pointBackgroundColor: "#041127",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(75,192,192,1)",
        pointHoverBorderColor: "rgba(220,220,220,1)",
        pointHoverBorderWidth: 2,
        pointRadius: 4,
        pointHitRadius: 10,
        data: rainOfHour
    },
    {
        type: 'bar',
        label: 'Intensity',
        backgroundColor: "rgba(75, 90, 193, 0.8)",
        data: intensityOfHour,
        borderColor: 'rgba(75, 90, 193, 0.8)',
        borderWidth: 0
    }]
};

var testing = document.getElementById("24hourrain");

var percipChart = new Chart(testing, {
    type: 'bar',
    data: barChartData,
    options: {
        title: {
            display: true,
            text: 'Precipitation'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false,
                    max:100,
                    min:0
                },
                gridLines: {
            	color:'rgba(255,255,255,0.1)'
            },
            }],
            xAxes: [{
                ticks: {
                    maxTicksLimit:5
                }
            }]
        }
    }
});



////////////// HUMIDITY //////////////

var humidityData = {
    labels: timeOfDay,
    datasets: [{
        type: 'line',
        label: 'Humidity',
        fill: true,
        lineTension: 0.3,
        backgroundColor: "rgba(157, 79, 176,0.1)",
        borderColor: "rgba(157, 79, 176, 1)",
        borderCapStyle: 'butt',
        borderDash: [],
        borderWidth: 9,
        borderDashOffset: 0.0,
        borderJoinStyle: 'miter',
        pointBorderColor: "rgba(157, 79, 176,1)",
        pointBackgroundColor: "#041127",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(157, 79, 176,1)",
        pointHoverBorderColor: "rgba(220,220,220,1)",
        pointHoverBorderWidth: 2,
        pointRadius: 4,
        pointHitRadius: 10,
        data: humidity
    },
    // {
    //     type: 'bar',
    //     label: 'Intensity',
    //     backgroundColor: "rgba(75, 90, 193, 0.8)",
    //     data: intensityOfHour,
    //     borderColor: 'rgba(75, 90, 193, 0.8)',
    //     borderWidth: 0
    // }
]
};

var humidDom = document.getElementById("24humidity");

var percipChart = new Chart(humidDom, {
    type: 'line',
    data: humidityData,
    options: {
        legend: {
            display: false,
        },
        title: {
            display: true,
            text: 'Humidity'
        },
        defaultFontColor: '#efefef',
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false,
                    suggestedMax:100,
                    suggestedMin:0
                },
                gridLines: {
            	color:'rgba(255,255,255,0.1)'
            },
            }],
            xAxes: [{
                ticks: {
                    maxTicksLimit:5
                }
            }]
        }
    }
});



////////////// NEXT HOUR PERCIPITATION //////////////

var nextHourData = {
    labels: [5,10,15,20,25,30,35,40,45,50,55,60],
    datasets: [
    {
        type: 'line',
        label: 'Precip%',
        fill: false,
        lineTension: 0.3,
        backgroundColor: "rgba(75,192,192,0.1)",
        borderColor: "rgba(75,192,192,1)",
        borderCapStyle: 'butt',
        borderDash: [],
        borderDashOffset: 0.0,
        borderJoinStyle: 'miter',
        pointBorderColor: "rgba(75,192,192,1)",
        pointBackgroundColor: "#041127",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(75,192,192,1)",
        pointHoverBorderColor: "rgba(220,220,220,1)",
        pointHoverBorderWidth: 2,
        pointRadius: 4,
        pointHitRadius: 10,
        data: nextHourPercip
    },
    {
        type: 'bar',
        label: 'Intensity',
        backgroundColor: "rgba(75, 90, 193, 0.8)",
        data: nextHourIntensity,
        borderColor: 'rgba(75, 90, 193, 0.8)',
        borderWidth: 0
    }]
};

var nextHourRain = document.getElementById("hourRain");

var percipChartHour = new Chart(nextHourRain, {
    type: 'bar',
    data: nextHourData,
    options: {
        legend: {
            display: true,
        },
        title: {
            display: false,
            text: 'Precipitation'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    max:100,
                    suggestedMin:0
                },
                gridLines: {
            	color:'rgba(255,255,255,0.1)'
            },
            }]
        }
    }
});


////////////// WEEKLY TEMPERATURE //////////////

var weeklyTempData = {
    labels: weeklyDays,
    datasets: [
        {
            type: 'line',
            label: 'Low',
            backgroundColor: "rgba(75, 90, 193, 0.1)",
            data: weeklyLowArray,
            fill: false,
            borderColor: 'rgba(75, 90, 193, 1)',
            pointHoverBackgroundColor: "rgba(75, 90, 193, 1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointBackgroundColor: "#041127",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            borderWidth: 9,
            lineTension: 0.3,
        },
        {
            label: "High",
            fill: true,
            lineTension: 0.3,
            backgroundColor: "rgba(214,44,44,0.1)",
            borderColor: "rgba(214, 44, 44, 1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderWidth: 9,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(214, 44, 44, 1)",
            pointBackgroundColor: "#041127",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(214, 44, 44, 1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 4,
            pointHitRadius: 10,
            data: weeklyHighArray,
            maintainAspectRatio: true
        }
    ]
};

var weeklyTemps = document.getElementById("weekly_temp");

var weeklyTempChart = new Chart(weeklyTemps, {
    type: 'line',
    data: weeklyTempData,
    options: {
        legend: {
            display: true,
        },
        title: {
            display: true,
            text: 'Temperature'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false,
                    suggestedMax:max_temp,
                    suggestedMin:min_temp
                },
                gridLines: {
            	color:'rgba(255,255,255,0.1)'
            },
            }],
        },
        global: {
            defaultFontColor:'#eee'
        }
    }
});


////////////// WEEKLY PERCIPITATION //////////////


var weeklyRainData = {
    labels: weeklyDays,
    datasets: [{
        type: 'line',
        label: 'Precip%',
        fill: true,
        lineTension: 0.3,
        backgroundColor: "rgba(75,192,192,0.1)",
        borderColor: "rgba(75,192,192,1)",
        borderCapStyle: 'butt',
        borderDash: [],
        borderDashOffset: 0.0,
        borderWidth: 9,
        borderJoinStyle: 'miter',
        pointBorderColor: "rgba(75,192,192,1)",
        pointBackgroundColor: "#041127",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(75,192,192,1)",
        pointHoverBorderColor: "rgba(220,220,220,1)",
        pointHoverBorderWidth: 2,
        pointRadius: 4,
        pointHitRadius: 10,
        data: weeklyRainArray
    },
    {
        type: 'bar',
        label: 'Intensity',
        backgroundColor: "rgba(75, 90, 193, 0.8)",
        data: weeklyRainIntensity,
        borderColor: 'rgba(75, 90, 193, 0.8)',
        borderWidth: 0
    }]
};

var weeklyRain = document.getElementById("weekly_rain");

var weeklyRainChart = new Chart(weeklyRain, {
    type: 'bar',
    data: weeklyRainData,
    options: {
        legend: {
            display: false,
        },
        title: {
            display: true,
            text: 'Precipitation'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false,
                    suggestedMax:100,
                    suggestedMin:0
                },
                gridLines: {
            	color:'rgba(255,255,255,0.1)'
            	},
            }]
        }
    }
});


////////////// WEEKLY HUMIDITY //////////////

var humidityWeekData = {
    labels: weeklyDays,
    datasets: [{
        type: 'line',
        label: 'Humidity',
        fill: true,
        lineTension: 0.3,
        backgroundColor: "rgba(157, 79, 176,0.1)",
        borderColor: "rgba(157, 79, 176, 1)",
        borderCapStyle: 'butt',
        borderDash: [],
        borderWidth: 9,
        borderDashOffset: 0.0,
        borderJoinStyle: 'miter',
        pointBorderColor: "rgba(157, 79, 176,1)",
        pointBackgroundColor: "#041127",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(157, 79, 176,1)",
        pointHoverBorderColor: "rgba(220,220,220,1)",
        pointHoverBorderWidth: 2,
        pointRadius: 4,
        pointHitRadius: 10,
        data: weeklyHumidityArray
    }
]
};

var humidWeekDom = document.getElementById("weekly_humidity");

var percipChart = new Chart(humidWeekDom, {
    type: 'line',
    data: humidityWeekData,
    options: {
        legend: {
            display: false,
        },
        title: {
            display: true,
            text: 'Humidity'
        },
        defaultFontColor: '#efefef',
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false,
                    suggestedMax:100,
                    suggestedMin:0
                },
                gridLines: {
            	color:'rgba(255,255,255,0.1)'
            	},
            }]
        }
    }
});
