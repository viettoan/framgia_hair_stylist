axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var manage_service = new Vue({
    el: '#fh5co-pricing',

    data: {
        users: {},
        token: {},
        items: [],
        selected: {},
        newItem: {'name': '', 'phone': ''},
        renderBookings: [],
        renderStylists: [],
        formErrors: {},
        params: {},
        success_deparment: {},
        success_stylist: {},
        success_time: {},
        select_render_booking: '',
        select_stylist_id: '',
        classChoseTime: {'class' : 'choice_time'},
        renderStatus: {},
        chooseStylis: {},
    },
    
    mounted: function() {
        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});
        this.showInfor();
        var timestamp = new Date().getTime() / 1000 | 0;
        this.params.date = timestamp;
        this.selected.date = 1;
        $('#order_booking').hide();
    },

    methods: {
        convertTimeMinute: function(hour) {
            hour = String(hour);
            var split = hour.split(':');
            return split[0] + ':' + split[1];
        },
        showInfor: function() {
        	if (this.users) {
        		this.newItem.name  = this.users.name,
        		this.newItem.phone = this.users.phone
        	} else {
        	   //
            }
        	var input = this.newItem;
        	axios.get('/api/v0/get-salons').then(response => {
                this.$set(this, 'items', response.data.data);
                this.params.department_id = this.items[0].id;
                this.selected.department_id = this.items[0].id;
                this.getStylist(this.selected.department_id);
                this.getRenderBooking();
            })
        },

        clickBooking: function() {
            var error = false;
            if (!this.newItem.name || !this.newItem.phone) {
                toastr.error('Please enter full name and phone number', '', {timeOut: 3000});
                error = true;
            }
            if (!this.select_render_booking) {
                toastr.error('PLease Choice Time Booking!', '', {timeOut: 3000});
                error = true;
            }
            if (error) return;
            var paramsData = {
                phone: this.newItem.phone,
                name: this.newItem.name,
                render_booking_id: this.select_render_booking,
                stylist_chosen: this.select_stylist_id
            }
            var authOptions = {
                method: 'post',
                url: '/api/v0/user_booking',
                params: paramsData,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }

            axios(authOptions).then(response => {
                toastr.success('Booking Success!', '', {timeOut: 10000});
                $('#infor_user').hide(500);
                $('#choice_address').hide(800);
                $('#choice_list_time').hide(900);
                this.success_deparment = response.data.data.department;
                this.success_time = response.data.data.render_booking;
                this.success_stylist = response.data.data.stylist;
                $('#order_booking').show(1000);
            }).catch((error) => {
                if (error.response.status == 403) {
                    self.formErrors = error.response.data.message;
                    console.log(self.formErrors);
                    for (key in self.formErrors) {
                        toastr.error(self.formErrors[key], '', {timeOut: 10000});
                    }    
                }
            });

        },

        getRenderBooking: function()
        {
            $('.frontend-booking-indicator').removeClass('hide');
            var authOptions = {
                method: 'get',
                url: '/api/v0/get-render-by-depart-stylist',
                params: this.params,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }

            axios(authOptions).then(response => {
                this.renderBookings = response.data.data.renders;
                this.params.stylist_id = '';
                $('.frontend-booking-indicator').addClass('hide');
            }).catch((error) => {
                $('.frontend-booking-indicator').addClass('hide');
            });
        },
        full: function() {
            toastr.error('This time is full! Please choose another time', '', {timeOut: 3000});
            this.render_booking_id = '';
        },
        offDay: function() {
            toastr.warning('This time is off Work! Please choose another time', '', {timeOut: 3000});
            this.render_booking_id = '';
        },
        changeStylist: function(event) {
            this.params.stylist_id = event.target.value;
            this.select_stylist_id = event.target.value;
            this.select_render_booking = '';
            this.selected.render_id = '';
            this.getRenderBooking();
        },
        getStylist: function(department_id) {
            var self = this;
            var authOptions = {
                method: 'get',
                url: '/api/v0/get-stylist-by-salonId/' + department_id,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then((response) => {
                this.renderStylists = response.data.data;
                this.messageStylists = response.data.message;
                if( this.messageStylists != '') {
                    toastr.warning(this.messageStylists, '', {timeOut: 3000});
                }
            })
        },
        selectDay: function(value) {
            var result = new Date();
            result = result.setDate(result.getDate() + value -1);
            var timestamp = new Date(result).getTime() / 1000 | 0;
            this.params.date = timestamp;
            this.select_render_booking = '';
            this.selected.render_id = '';
            this.getRenderBooking();
            this.selected.date = value;
        },
        selectTime: function(render_booking_id) {
            this.select_render_booking = render_booking_id;
            this.selected.render_id = render_booking_id;
        },
        selectDepartment: function(department_id)
        {
            this.selected.department_id = department_id;
            this.params.department_id = department_id;
            this.params.stylist_id = this.chooseStylis.status;
            this.select_stylist_id = '';
            this.select_render_booking = '';
            this.selected.render_id = '';
            this.getRenderBooking();
            this.getStylist(department_id);
        },
    }
});
