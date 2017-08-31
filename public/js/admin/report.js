
Vue.component('bar-chart-month', {
  extends: VueChartJs.Bar,
  mounted () {
    this.renderChart({
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label: 'Data 3',
          backgroundColor: 'red',
          data: [40, 39, 10, 40, 39, 80, 40]
        },
        {
          label: 'Data 4',
          backgroundColor: 'blue',
          data: [50, 40, 10, 40, 39, 80, 40]
        }
      ]
    }, {responsive: true, maintainAspectRatio: false})
  }
})
Vue.component('bar-chart-year', {
  extends: VueChartJs.Bar,
  mounted () {
    this.renderChart({
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label: 'Data 5',
          backgroundColor: 'red',
          data: [40, 39, 10, 40, 39, 80, 40]
        },
        {
          label: 'Data 6',
          backgroundColor: 'blue',
          data: [50, 40, 10, 40, 39, 80, 40]
        }
      ]
    }, {responsive: true, maintainAspectRatio: false})
  }
})

var labels1 = {
    labels11:[]
};

Vue.component("bar-chart-day", {
    extends: VueChartJs.Bar,
    props: ["data1", "options"],

    computed: {
        chartData: function() {
            return this.data1;
        },
    },

    data: function () {
        return labels1;
    }, 

    methods: {
        renderLineChart: function() {
            console.log(this.chartData.statistical);
            for (var i = 0; i < this.chartData.statistical.length; i++) {
                labels1.labels11.push(this.chartData.statistical[i].label);
                this.renderChart(
                    {
                        labels:labels1.labels11,
                        datasets: [
                            {
                                label: ['Bills'],
                                backgroundColor: "red",
                                data: this.chartData.statistical[i].value
                            },
                        ]
                    },
                    { responsive: true, maintainAspectRatio: false }
                );      
            }   
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
        dataChart: { 
            'label': '',
            'value': ''
        },
    },
    mounted : function(){
        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});

        var curentDateTimeStamp = new Date().getTime() / 1000 | 0;
        var curentDateString = new Date().toISOString().slice(0, 10);

        this.filterParams.start_date = curentDateTimeStamp - 604800;
        this.filterParams.end_date = curentDateTimeStamp;

        this.inputDate.start_date = new Date(this.filterParams.start_date*1000).toISOString().slice(0, 10);;
        this.inputDate.end_date = curentDateString;
        this.showChartByDay();
    },
    methods: {
        showChartByDay: function() {
            var self = this;
            var authOptions = {
                method: 'get',
                url: '/api/v0/report-bill',
                params: this.filterParams,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
           axios(authOptions).then(response => {
                this.$set(this, 'dataChart', response.data.data);
            })
        },
        selectStartDay: function(event) {
            var timestamp = new Date(event.target.value).getTime() / 1000 | 0;
            this.filterParams.start_date = timestamp;
            this.showChartByDay();
        },

        selectEndDay: function(event) {
            var timestamp = new Date(event.target.value).getTime() / 1000 | 0;
            this.filterParams.end_date = timestamp;
            this.showChartByDay();
        },
    }
});