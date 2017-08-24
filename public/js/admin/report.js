
// const someVariable = [report.data.sales];
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

var test = Vue.component('bar-chart-day', {
  extends: VueChartJs.Bar,
  mounted () {
    this.renderChart({
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label: 'Sales',
          backgroundColor: 'red',
          data: [this.sales]
        },
        {
          label: 'Bill',
          backgroundColor: 'blue',
          data: [50, 40, 10, 40, 39, 80, 40]
        },
        {
          label: 'Customer',
          backgroundColor: 'blue',
          data: [50, 40, 10, 40, 39, 80, 40]
        }
      ]
    }, {responsive: true, maintainAspectRatio: false})
  }
  
})
var report = new Vue({
    el: '.content-wrapper',
    data: {
        users: {},
        token: {},
        sales: [],
        bills: [],
        customers: []
    },
    mounted : function(){
        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});
        // this.getListBill();
        this.showChartByDay();
        console.log(someVariable);
    },
     components: {
        // <my-component> will only be available in parent's template
        'my-component': test
    },
    methods: {
        showChartByDay: function() {
            var authOptions = {
                method: 'get',
                url: '/api/v0/report-sales',
                // params: this.filterParams,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then(response => {
                this.$set(this, 'sales', 5);
                // console.log(this.sales);
            })
        },
    }
})
