google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawCharts);
function drawCharts() {
    var barData = google.visualization.arrayToDataTable([
        ['Day', 'Price Total', 'Total Hair'],
        ['Sun',  50,      600],
        ['Mon',  1200,      910],
        ['Tue',  660,       400],
        ['Wed',  1030,      540],
        ['Thu',  1000,      480],
        ['Fri',  1170,      960],
        ['Sat',  660,       320]
    ]);
    var barOptions = {
        focusTarget: 'category',
        backgroundColor: 'transparent',
        colors: ['cornflowerblue', 'tomato'],
        fontName: 'Open Sans',
        chartArea: {
            left: 50,
            top: 10,
            width: '100%',
            height: '70%'
        },
        bar: {
            groupWidth: '80%'
        },
        hAxis: {
            textStyle: {
                fontSize: 11
            }
        },
        vAxis: {
            minValue: 0,
            maxValue: 1500,
            baselineColor: '#DDD',
            gridlines: {
                color: '#DDD',
                count: 4
            },
            textStyle: {
                fontSize: 11
            }
        },
        legend: {
            position: 'bottom',
            textStyle: {
                fontSize: 12
            }
        },
        animation: {
            duration: 1200,
            easing: 'out',
            startup: true
        }

    };
    var barChart = new google.visualization.ColumnChart(document.getElementById('bar-chart'));
    barChart.draw(barData, barOptions);
}
///////////////////////////////////////////////////////////
$('#day').click(function(){
    barData = google.visualization.arrayToDataTable([
        ['Day', 'Price Total', 'Total Hair'],
        ['Sun',  50,      600],
        ['Mon',  1200,      910],
        ['Tue',  660,       400],
        ['Wed',  1030,      540],
        ['Thu',  1000,      480],
        ['Fri',  1170,      960],
        ['Sat',  660,       320]
    ]);
    var barOptions = {
        focusTarget: 'category',
        backgroundColor: 'transparent',
        colors: ['cornflowerblue', 'tomato'],
        fontName: 'Open Sans',
        chartArea: {
            left: 50,
            top: 10,
            width: '100%',
            height: '70%'
        },
        bar: {
            groupWidth: '80%'
        },
        hAxis: {
            textStyle: {
                fontSize: 11
            }
        },
        vAxis: {
            minValue: 0,
            maxValue: 1500,
            baselineColor: '#DDD',
            gridlines: {
                color: '#DDD',
                count: 4
            },
            textStyle: {
                fontSize: 11
            }
        },
        legend: {
            position: 'bottom',
            textStyle: {
                fontSize: 12
            }
        },
        animation: {
            duration: 1200,
            easing: 'out',
            startup: true
        }
    };
    var barChart = new google.visualization.ColumnChart(document.getElementById('bar-chart'));
    barChart.draw(barData, barOptions);
});
////////////////////////////////////////////////////////
$('#week').click(function(){
    barData = google.visualization.arrayToDataTable([
        ['Week', 'Price Total', 'Total Hair'],
        ['Week 1',  50,      600],
        ['Week 2',  1200,      910],
        ['Week 3',  660,       400],
        ['Week 4',  1030,      540],
        ]);
    var barOptions = {
        focusTarget: 'category',
        backgroundColor: 'transparent',
        colors: ['cornflowerblue', 'tomato'],
        fontName: 'Open Sans',
        chartArea: {
            left: 50,
            top: 10,
            width: '100%',
            height: '70%'
        },
        bar: {
            groupWidth: '80%'
        },
        hAxis: {
            textStyle: {
                fontSize: 11
            }
        },
        vAxis: {
            minValue: 0,
            maxValue: 1500,
            baselineColor: '#DDD',
            gridlines: {
                color: '#DDD',
                count: 4
            },
            textStyle: {
                fontSize: 11
            }
        },
        legend: {
            position: 'bottom',
            textStyle: {
                fontSize: 12
            }
        },
        animation: {
            duration: 1200,
            easing: 'out',
            startup: true
        }

    };
    var barChart = new google.visualization.ColumnChart(document.getElementById('bar-chart'));
    barChart.draw(barData, barOptions);
});
///////////////////////////////////////////////////////////////
$('#monthly').click(function(){
    barData = google.visualization.arrayToDataTable([
        ['Monthly', 'Price Total', 'Total Hair'],
        ['Jan',  50,      600],
        ['Feb',  1200,      910],
        ['Mar',  660,       400],
        ['Apr',  1030,      540],
        ['May',  1000,      480],
        ['Jun',  1170,      960],
        ['Jul',  660,       320],
        ['Aug',  50,      600],
        ['Sep',  660,       400],
        ['Oct',  1030,      540],
        ['Now',  1000,      480],
        ['Dec',  1170,      960],
    ]);
    var barOptions = {
        focusTarget: 'category',
        backgroundColor: 'transparent',
        colors: ['cornflowerblue', 'tomato'],
        fontName: 'Open Sans',
        chartArea: {
            left: 50,
            top: 10,
            width: '100%',
            height: '70%'
        },
        bar: {
            groupWidth: '80%'
        },
        hAxis: {
            textStyle: {
                fontSize: 11
            }
        },
        vAxis: {
            minValue: 0,
            maxValue: 1500,
            baselineColor: '#DDD',
            gridlines: {
                color: '#DDD',
                count: 4
            },
            textStyle: {
                fontSize: 11
            }
        },
        legend: {
            position: 'bottom',
            textStyle: {
                fontSize: 12
            }
        },
        animation: {
            duration: 1200,
            easing: 'out',
            startup: true
        }

    };
    var barChart = new google.visualization.ColumnChart(document.getElementById('bar-chart'));
    barChart.draw(barData, barOptions);
});
