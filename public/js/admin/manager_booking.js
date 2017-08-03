axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var manage_service = new Vue({
    el: '#manager_booking',

    data: {
        users: {},
        token: {},
        items: [],
        pagination: {
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1
        },
        show_input: {},
        offset: 4,
        formErrors: {},
        formErrorsUpdate: {},
        newItem: {},
        params: {},
        start_date: '',
        end_date: ''
    },
    mounted : function(){
        this.show_input.start = false;
        this.show_input.end = false;
        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});

        var timestamp = new Date().getTime() / 1000 | 0;
        this.params.start_date = timestamp;
        this.params.end_date = timestamp;

        var curentDay = new Date().toISOString().slice(0, 10);
        this.start_date = curentDay;
        this.end_date = curentDay;

        this.getBooking();
    },

    methods: {
        showBooking: function() {
            $('#showBooking').modal('show');
        },
        convertHourMinute: function(data) {
            data = String(data);
            var split = data.split(' ');
            return split[1];
        },
        getBooking: function() {
            $('.list-booking-indicator').removeClass('hide');
            var authOptions = {
                method: 'get',
                url: '/api/v0/filter-order-booking',
                params: this.params,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token
                }
            }
            axios(authOptions).then(response => {
                this.$set(this, 'items', response.data.data);
                $('.list-booking-indicator').addClass('hide');
            }).catch(function (error) {
                $('.list-booking-indicator').addClass('hide');
            });
        },

        selectDay: function(event){
            var value = event.target.value;
            this.params.type = value;

            this.show_input.start = false;
            this.show_input.end = false;
            if (value == 'day') {
                this.show_input.start = true;
                this.show_input.end = false;
            }
            if (value == 'space') {
                this.show_input.start = true;
                this.show_input.end = true;
            }
            this.getBooking();
        },

        selectStartDay: function(event) {
            var timestamp = new Date(event.target.value).getTime() / 1000 | 0;
            this.params.start_date = timestamp;
            this.getBooking();
        },

        selectEndDay: function(event) {
            var timestamp = new Date(event.target.value).getTime() / 1000 | 0;
            this.params.end_date = timestamp;
            this.getBooking();
        },

        selectStatus: function(event) {
            this.params.status = event.target.value;
            this.getBooking();
        },

        selectPerPage: function(event) {
            this.params.per_page = event.target.value;
            this.getBooking();
        },

        changePage: function (page) {
            this.params.page = page;
            this.showInfor(page);
        }
    }
});
