
// Vue.component('bar-chart-year', {
//   extends: VueChartJs.Bar,
//   mounted () {
//     this.renderChart({
//       labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
//       datasets: [
//         {
//           label: 'Data 5',
//           backgroundColor: 'red',
//           data: [40, 39, 10, 40, 39, 80, 40]
//         },
//         {
//           label: 'Data 6',
//           backgroundColor: 'blue',
//           data: [50, 40, 10, 40, 39, 80, 40]
//         }
//       ]
//     }, {responsive: true, maintainAspectRatio: false})
//   }
// })

var labels = {
    labelDate:[],
    labelMonth:[],
    labelYear:[]
};

Vue.component('bar-chart-month', {
    extends: VueChartJs.Bar,
    props: ["data2", "options"],

    computed: {
        chartData: function() {
            return this.data2;
        },
    },

    data: function () {
        return labels;
    }, 

    methods: {
        renderLineChart: function() {
            var dataInDataSets = [];
            for (var i = 0; i < this.chartData.statistical.length; i++) {
                labels.labelMonth.push(this.chartData.statistical[i].label);
                dataInDataSets.push(this.chartData.statistical[i].value);
            }
            this.renderChart(
            {
                labels:labels.labelMonth,
                datasets: [
                {
                    label: ['Bills'],
                    backgroundColor: "red",
                    data: [1,2,3,2,4,5,2]
                },
                ]
            },
            { responsive: false, maintainAspectRatio: true }
            );      
        }
    },
    watch: {
        data2: function() {
          this.renderLineChart();
      }
  }
})

Vue.component("bar-chart-day", {
    extends: VueChartJs.Bar,
    props: ["data1", "options"],

    computed: {
        chartData: function() {
            return this.data1;
        },
    },

    data: function () {
        return labels;
    }, 

    methods: {
        renderLineChart: function() {
            var dataInDataSets = [];
            for (var i = 0; i < this.chartData.statistical.length; i++) {
                labels.labelDate.push(this.chartData.statistical[i].label);
                dataInDataSets.push(this.chartData.statistical[i].value);
            }   
            this.renderChart(
            {
                labels:labels.labelDate,
                datasets: [
                {
                    label: ['Bills'],
                    backgroundColor: "red",
                    data: [1,2,3,2,4,5,2]
                },
                ]
            },
            { responsive: false, maintainAspectRatio: false }
            );    
     }
 },
 watch: {
    data1: function() {
      this.renderLineChart();
  }
}
});

var vm = new Vue({
    el: ".content-wrapper",

    data:{
        users: {},
        token: {},
        filterParams: {'type': '', 'start_date': '', 'end_date': ''},
        inputDate: {'start_date': '', 'end_date': ''},
        inputMonth: {'start_date': '', 'end_date': ''},
        dataChartDay: { 
            'label': '',
            'value': ''
        },
        dataChartMonth: { 
            'label': '',
            'value': ''
        },
        dataChartyear: { 
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


        this.ChartSales();
    },
    methods: {
        ChartSales: function() {
            var self = this;
            var authOptions = {
                method: 'get',
                url: '/api/v0/report-sales',
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
                
            })
        },

        selectTypeMonth: function(event) {
            this.filterParams.type = "month";
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
        },

        selectStartDay: function(event) {
            labels.labelDate = [];
            labels.labelMonth = [];
            var timestamp = new Date(event.target.value).getTime() / 1000 | 0;
            this.filterParams.start_date = timestamp;
            this.ChartSales();
        },

        selectEndDay: function(event) {
            labels.labelDate = [];
            labels.labelMonth = [];
            var timestamp = new Date(event.target.value).getTime() / 1000 | 0;
            this.filterParams.end_date = timestamp;
            this.ChartSales();
        },
    }
});