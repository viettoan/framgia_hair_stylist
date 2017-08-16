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
        showDepartments:{},
        changer_status_booking:{'id': '', 'status': ''},
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
        this.showDepartment();
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
        changer_status(item){
            this.changer_status_booking.status = item.status;
            this.changer_status_booking.id = item.id;
            $('#update_status').modal('show');
            console.log(this.changer_status_booking.status);
        },
        update_status: function(id){
            this.params.status = this.changer_status_booking.status;
            var self = this;
            var authOptions = {
                    method: 'PUT',
                    url: '/api/v0/change-status-booking/' + id,
                    params: this.params,
                    headers: {
                        'Authorization': "Bearer " + this.token.access_token,
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    json: true
                }

            axios(authOptions).then((response) => {
                this.changer_status_booking = {'id': '', 'status': ''},
                 $('#update_status').modal('hide');
                    toastr.success('Update Booking Success', 'Success', {timeOut: 5000});
                    this.getBooking();
            }).catch((error) => {
                    if (error.response.status == 403) {
                        self.formErrors = error.response.data.message;
                        for (key in self.formErrors) {
                            toastr.error(self.formErrors[key], '', {timeOut: 10000});
                        }    
                    }
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
            var arrStatus = $(event.target).val();
            if (!arrStatus) {
                this.params.status = '';
            } else {
                this.params.status = arrStatus.join(',');
            }
            this.getBooking();
        },
        showDepartment: function(page) {
            axios.get('/api/v0/department').then(response => {
                this.$set(this, 'showDepartments', response.data.data);
            })
        },

        selectDepartment: function(event) {
            this.params.department_id = event.target.value;
            this.getBooking();
        }
    }
});
