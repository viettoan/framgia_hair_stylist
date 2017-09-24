

var labels = {
    labelDate:[],
    labelMonth:[],
    labelYear:[]
};
var DayChart, MonthChart, YearChart;
var label = "", background = [], border = [];

Vue.component("bar-chart-day", {
    template: '<canvas id="DayChart" width="400" height="400"></canvas>',
    props: ["data1", "type"],

    computed: {
        chartData: function() {
            return this.data1;
        },

        typeChartData: function() {
            return this.type;
        }
    },

    data: function () {
        return labels;
    }, 

    methods: {
        renderLineChart: function() {
            var dataInDataSets = [];
            var customerOld = [];
            var customerNew = [];
            var ctx = document.getElementById("DayChart");

            if (typeof this.chartData.customer_new !== 'undefined')   
            {
                for (var i = 0; i < this.chartData.statistical.length; i++) {
                    labels.labelDate.push(this.chartData.statistical[i].label);
                    customerOld.push(this.chartData.statistical[i].customer_old);
                    customerNew.push(this.chartData.statistical[i].customer_new);
                } 
                if (DayChart) {
                    DayChart.destroy();
                }
                if(MonthChart)
                {
                    MonthChart.destroy();
                }
                if(YearChart)
                {
                    YearChart.destroy();
                }
                DayChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels.labelDate,
                        datasets: [
                            {
                                label: 'New customer',
                                data: customerNew,
                                backgroundColor: [
                                    'yellow'
                                ],
                                borderColor: [
                                    'yellow'
                                ],
                                borderWidth: 1
                            },
                            {
                                label: 'Old customer',
                                data: customerOld,
                                backgroundColor: [
                                    'blue'
                                ],
                                borderColor: [
                                    'blue'
                                ],
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            }
            else
            {
                for (var i = 0; i < this.chartData.statistical.length; i++) {
                    labels.labelDate.push(this.chartData.statistical[i].label);
                    dataInDataSets.push(this.chartData.statistical[i].value);
                } 
                if (DayChart) {
                    DayChart.destroy();
                }
                if(MonthChart)
                {
                    MonthChart.destroy();
                }
                if(YearChart)
                {
                    YearChart.destroy();
                }
                DayChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels.labelDate,
                        datasets: [{
                            label: label,
                            data: dataInDataSets,
                            backgroundColor: background,
                            borderColor: [
                                'red'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                }); 
            }
        }
    },
    watch: {
        data1: function() {
            this.renderLineChart();
        }
    }
})

Vue.component('bar-chart-month', {
    template: '<canvas id="MonthChart" width="400" height="400"></canvas>',
    props: ["data2", "type"],

    computed: {
        chartData: function() {
            return this.data2;
        },

        typeChartData: function() {
            return this.type;
        }
    },

    data: function () {
        return labels;
    }, 

    methods: {
        renderLineChart: function() {
            var dataInDataSets = [];
            var customerOld = [];
            var customerNew = [];
            var ctx = document.getElementById("MonthChart");

            if (typeof this.chartData.customer_new !== 'undefined')   
            {
                for (var i = 0; i < this.chartData.statistical.length; i++) {
                    labels.labelMonth.push(this.chartData.statistical[i].label);
                    customerOld.push(this.chartData.statistical[i].customer_old);
                    customerNew.push(this.chartData.statistical[i].customer_new);
                } 
                if (DayChart) {
                    DayChart.destroy();
                }
                if(MonthChart)
                {
                    MonthChart.destroy();
                }
                if(YearChart)
                {
                    YearChart.destroy();
                }
                MonthChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels.labelMonth,
                        datasets: [
                            {
                                label: 'New customer',
                                data: customerNew,
                                backgroundColor: [
                                    'yellow'
                                ],
                                borderColor: [
                                    'yellow'
                                ],
                                borderWidth: 1
                            },
                            {
                                label: 'Old customer',
                                data: customerOld,
                                backgroundColor: [
                                    'blue'
                                ],
                                borderColor: [
                                    'blue'
                                ],
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            }
            else
            {
                for (var i = 0; i < this.chartData.statistical.length; i++) {
                    labels.labelMonth.push(this.chartData.statistical[i].label);
                    dataInDataSets.push(this.chartData.statistical[i].value);
                } 
                if (DayChart) {
                    DayChart.destroy();
                }
                if(MonthChart)
                {
                    MonthChart.destroy();
                }
                if(YearChart)
                {
                    YearChart.destroy();
                }
                MonthChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels.labelMonth,
                        datasets: [{
                            label: label,
                            data: dataInDataSets,
                            backgroundColor: background,
                            borderColor: [
                            'red'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                }); 
            }
        }
    },
    watch: {
        data2: function() {
          this.renderLineChart();
        }
    }
})
Vue.component('bar-chart-year', {
    template: '<canvas id="YearChart" width="400" height="400"></canvas>',
    props: ["data3", "type"],

    computed: {
        chartData: function() {
            return this.data3;
        },

        typeChartData: function() {
            return this.type;
        }
    },

    data: function () {
        return labels;
    }, 

    methods: 
    {
        renderLineChart: function() {
            var dataInDataSets = [];
            var customerOld = [];
            var customerNew = [];
            var ctx = document.getElementById("YearChart");

            if (typeof this.chartData.customer_new !== 'undefined')   
            {
                for (var i = 0; i < this.chartData.statistical.length; i++) {
                    labels.labelYear.push(this.chartData.statistical[i].label);
                    customerOld.push(this.chartData.statistical[i].customer_old);
                    customerNew.push(this.chartData.statistical[i].customer_new);
                } 
                if (DayChart) {
                    DayChart.destroy();
                }
                if(MonthChart)
                {
                    MonthChart.destroy();
                }
                if(YearChart)
                {
                    YearChart.destroy();
                }
                YearChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels.labelYear,
                        datasets: [
                            {
                                label: 'New customer',
                                data: customerNew,
                                backgroundColor: [
                                    'yellow'
                                ],
                                borderColor: [
                                    'yellow'
                                ],
                                borderWidth: 1
                            },
                            {
                                label: 'Old customer',
                                data: customerOld,
                                backgroundColor: [
                                    'blue'
                                ],
                                borderColor: [
                                    'blue'
                                ],
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            }
            else
            {
                for (var i = 0; i < this.chartData.statistical.length; i++) {
                    labels.labelYear.push(this.chartData.statistical[i].label);
                    dataInDataSets.push(this.chartData.statistical[i].value);
                } 
                if (DayChart) {
                    DayChart.destroy();
                }
                if(MonthChart)
                {
                    MonthChart.destroy();
                }
                if(YearChart)
                {
                    YearChart.destroy();
                }
                YearChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels.labelYear,
                        datasets: [{
                            label: label,
                            data: dataInDataSets,
                            backgroundColor: background,
                            borderColor: [
                            'red'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true,
                                }
                            }]
                        }
                    }
                }); 
            }
        },
    },
    watch: {
        data3: function() {
          this.renderLineChart();
        }
    }
})

var vm = new Vue({
    el: ".content-wrapper",

    data:{
        users: {},
        token: {},
        checkTypeReport: '',
        filterParams: {'type': '', 'start_date': '', 'end_date': '', 'status': ''},
        inputDate: {'start_date': '', 'end_date': ''},
        inputMonth: {'start_date': '', 'end_date': ''},
        inputYear: {'start_date': '', 'end_date': ''},
        count: {'month': 0,'year': 0, 'sales': 0,'booking': 0,'customer': 0},
        inputStatus: '',
        total: '',
        statusVisible: '',
        dataChartDay: { 
            'label': '',
            'value': ''
        },
        dataChartMonth: { 
            'label': '',
            'value': ''
        },
        dataChartYear: { 
            'label': '',
            'value': ''
        },
    },
    mounted : function(){

        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});

        var curentDateTimeStamp = new Date().getTime() / 1000 | 0;
        var curentDateString = new Date().toISOString().slice(0, 10);

        this.filterParams.type = "day";
        this.filterParams.start_date = curentDateTimeStamp - 604800;
        this.filterParams.end_date = curentDateTimeStamp;

        this.inputDate.start_date = new Date(this.filterParams.start_date*1000).toISOString().slice(0, 10);;
        this.inputDate.end_date = curentDateString;
        this.checkTypeReport = 'sales';

        this.ChartSales();
    },
    methods: {
        ChartSales: function() {
            var self = this;
            var urls = '';
            if(this.checkTypeReport == 'sales')
            {
                label = "Sales";
                background = ["#00c0ef"]
                urls ='/api/v0/report-sales';
            }
            else if(this.checkTypeReport == 'booking')
            {
                label = "Booking";
                background = ["#00a65a"];
                urls ='/api/v0/report-booking';
            }
            else
            {
                urls ='/api/v0/report-customer';
            }
            var authOptions = {
                method: 'get',
                url: urls,
                params: this.filterParams,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then(response => {
                if(this.filterParams.type == "day")
                {
                    this.$set(this, "dataChartDay", response.data.data);
                }
                else if(this.filterParams.type == "month")
                {
                    this.$set(this, "dataChartMonth", response.data.data);
                }
                else
                {
                    this.$set(this, "dataChartYear", response.data.data);
                }
                this.$set(this, "checkTypeReport", this.checkTypeReport);
            })
        },

        salesChosen: function(event) {
            labels.labelDate = [];
            labels.labelMonth = [];
            labels.labelYear = [];
            this.checkTypeReport = 'sales';
            this.statusVisible = 'visible';
            this.ChartSales();
        },

        bookingChosen: function(event) {
            labels.labelDate = [];
            labels.labelMonth = [];
            labels.labelYear = [];

            this.checkTypeReport = 'booking';
            this.statusVisible = 'visible';
            this.ChartSales();
        },

        customerChosen: function(event) {
            labels.labelDate = [];
            labels.labelMonth = [];
            labels.labelYear = [];
            this.checkTypeReport = 'customer';
            this.statusVisible = 'hidden';
            this.ChartSales();
        },

        selectTypeMonth: function(event) {
            labels.labelMonth = [];
            // if(this.count.month > 0)
            // {
            //     this.filterParams.type = "month";
            // }
            // else
            // {
                this.filterParams.type = "month";
                this.count.month = this.count.month + 1;
                this.count.year = 0;

                var currentYear = new Date().getFullYear();
                var currentMonth = new Date().getMonth();
                if(currentMonth <=9)
                {
                    currentMonth = "0" + currentMonth;
                }
                this.filterParams.start_date = moment("01/15/" + currentYear).unix();
                this.filterParams.end_date = moment(currentMonth + "/15/" + currentYear).unix();


                this.inputMonth.start_date =currentYear + "-" + "01-15"; 
                this.inputMonth.end_date = currentYear + "-" + currentMonth + "-" + "15";

                this.ChartSales();
            // }

        },

        selectTypeDay: function(event) {
            labels.labelDate = [];

            var curentDateTimeStamp = new Date().getTime() / 1000 | 0;
            var curentDateString = new Date().toISOString().slice(0, 10);

            this.filterParams.type = "day";
            this.filterParams.start_date = curentDateTimeStamp - 604800;
            this.filterParams.end_date = curentDateTimeStamp;

            this.inputDate.start_date = new Date(this.filterParams.start_date*1000).toISOString().slice(0, 10);;
            this.inputDate.end_date = curentDateString;

            this.ChartSales();

        },

        selectTypeYear: function(event) {
            labels.labelYear = [];
            // if(this.count.year > 0)
            // {
            //     this.filterParams.type = "year";
            // }
            // else
            // {
                this.filterParams.type = "year";
                this.count.year = this.count.year + 1;
                this.count.month = 0;

                var currentYear = new Date().getFullYear();
                var currentMonth = new Date().getMonth();

                if(currentMonth <=9)
                {
                    currentMonth = "0" + currentMonth;
                }

                this.filterParams.start_date = moment("01/15/" + (currentYear- 4) ).unix();
                this.filterParams.end_date = moment(currentMonth + "/15/" + currentYear).unix();

                this.inputYear.start_date =(currentYear - 4) + "-" + "01-15";
                this.inputYear.end_date = currentYear + "-" + currentMonth + "-" + "15";

                this.ChartSales();
            // }
        },

        selectStartDay: function(event) {
            labels.labelDate = [];
            labels.labelMonth = [];
            labels.labelYear = [];
            var timestamp = new Date(event.target.value).getTime() / 1000 | 0;
            this.filterParams.start_date = timestamp;

            this.ChartSales();
        },

        selectEndDay: function(event) {
            labels.labelDate = [];
            labels.labelMonth = [];
            labels.labelYear = [];

            var timestamp = new Date(event.target.value).getTime() / 1000 | 0;
            this.filterParams.end_date = timestamp;
            this.ChartSales();
        },

        selectStatus: function(event) {

            this.filterParams.status = this.inputStatus;
            this.ChartSales();
        },
    }
});

