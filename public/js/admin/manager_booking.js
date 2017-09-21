axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var manage_service = new Vue({
    el: '#manager_booking',

    data: {
        users: {},
        token: {},
        items: [],
        show_input: {},
        formErrors: {},
        showDepartments:{},
        booking: {},
        departments: [],
        stylists:[],
        services:[],
        listSevice: [],
        listBill: [],
        bill: {'customer_id': '',
                'phone': '', 
                'status': 0,
                'customer_name': '',
                'order_booking_id': '',
                'order_id': '',
                'grand_total': 0,
                'service_name': '',
                'department_id': '',
                'stylist_id': '',
                'price': '',
                'service_product_id': '',
                'bill_items': []
            },
        changer_status_booking:{'id': '', 'status': '', 'message': ''},
        billItem: {'qty': 1, 'price': '', 'stylist_id': '', 'service_product_id': ''},
        isEditBillItem: {'status': false, 'index' : ''},
        billItems: [],
        orderItems: [],
        billSuccess: {},
        logStatus: [],
        formErrorsUpdate: {},
        newItem: {},
        params: {},
        start_date: '',
        end_date: '',
        status: '',
    },
    mounted : function(){
        this.showDepartment();
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
        this.selectDepartment();
        this.getBooking();
    },

    methods: {
        resetData: function() {
            this.bill = {'customer_id': '',
                'phone': '', 
                'status': 0,
                'customer_name': '',
                'order_booking_id': '',
                'order_id': '',
                'grand_total': 0,
                'service_name': '',
                'department_id': '',
                'stylist_id': '',
                'price': '',
                'service_product_id': '',
                'bill_items': []
            },
            this.billItems = [];

            this.billItem = {'qty': 1, 'price': '', 'stylist_id': '', 'service_product_id': ''};
            this.booking = {};
            this.isEditBillItem = {'status': false, 'index' : ''};
        },
        showBooking: function() {
            $('#showBooking').modal('show');
        },

        curent_time: function(data) {
            let today = new Date().getTime();
            var min = today - (new Date(data[0].time_start).getTime());
            min_current_time = [];
            for(key in data){
                var timestamp = new Date(data[key].time_start).getTime();
                var time = today - timestamp;
                if (time < 0) {
                    data[key]['status_time'] = 0;
                } else {
                    data[key]['status_time'] = 1;
                }
                data[key]['current_time'] = time;
            }

            return data.sort(function(a, b){
                return b.current_time - a.current_time;   
            }).sort(function(a, b){
                return a.status_time - b.status_time;
            });
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
                if(response.data.data[0].list_book.length > 0) {
                    response.data.data[0].list_book = this.curent_time(response.data.data[0].list_book);
                }
                this.$set(this, 'items', response.data.data);
                $('.list-booking-indicator').addClass('hide');
            }).catch(function (error) {
                $('.list-booking-indicator').addClass('hide');
            });
        },
 
        changer_status(item){
            this.changer_status_booking.status = item.status;
            this.changer_status_booking.id = item.id;
            this.changer_status_booking.message = item.message;
            this.$set(this, 'status', this.changer_status_booking.status);
            $('#update_status').modal('show');
        },
        update_status: function(id){
            var self = this;
            var authOptions = {
                    method: 'PUT',
                    url: '/api/v0/change-status-booking/' + id,
                    params: {status: this.changer_status_booking.status, message: this.changer_status_booking.message},
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
                console.log(response.data.data);
                this.$set(this, 'showDepartments', response.data.data);
            })
        },
        selectDepartment: function() {
            this.params.department_id = this.bill.department_id;
            this.getBooking();
        },
        addService: function(){

            var error = false;
            if (!this.billItem.stylist_id) {
                toastr.error('Please select stylist!', '', {timeOut: 5000});
                error = true;
            }
            if (!this.billItem.service_product_id) {
                toastr.error('Please select service!', '', {timeOut: 5000});
                error = true;
            }
            if (this.billItem.qty <= 0) {
                toastr.error('Please add qty service smallest is 1!', '', {timeOut: 5000});
                error = true;
            }
            if (error) return;

            var issetBillItem = false;
            for (var i = this.orderItems.get_order_items.length - 1; i >= 0; i--) {
                var tmpBill = this.orderItems.get_order_items[i];
                if (tmpBill.service_product_id == this.billItem.service_product_id
                    && tmpBill.stylist_id == this.billItem.stylist_id
                ) {
                    tmpBill.qty = parseInt(tmpBill.qty) + parseInt(this.billItem.qty);
                    issetBillItem  = true;
                    this.billItems[i] = tmpBill;
                    break;
                }
            }
            if (!issetBillItem) {
                this.billItem.qty = parseInt(this.billItem.qty);
                this.billItem.row_total = this.billItem.price * parseInt(this.billItem.qty);
                this.orderItems.get_order_items.push(this.billItem);
            }
            
            this.billItem = {'qty': 1, 'price': '', 'stylist_id': '', 'service_product_id': ''};
            this.grand_total();

            this.billItem = {'qty': 1, 'price': '', 'stylist_id': '', 'service_product_id': ''};
            this.grand_total();
        },
        grand_total: function(){
            var grand_total = 0;
            for (var i = 0; i < this.billItems.length; i++) {
                this.billItems[i].row_total = parseInt(this.billItems[i].qty) * this.billItems[i].price;
                grand_total += this.billItems[i].row_total;
            }
            this.bill.grand_total = grand_total.toLocaleString('de-DE');
        },
        showDepartment: function(page) {
            axios.get('/api/v0/department').then(response => {
                this.$set(this, 'departments', response.data.data);
            });
        },
        showStylist: function(page) {
            var authOptions = {
                method: 'get',
                url: '/api/v0/get-stylist-by-salonId/' + this.bill.department_id,
                params: this.params,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token
                }
            }
            axios(authOptions).then(response => {
                this.$set(this, 'stylists', response.data.data);
            }).catch(error => {
                this.$set(this, 'stylists', []);
            });
        },
        getNameStylist: function(stylist_id) {
            var stylistName = '';
            for (var i = 0; i < this.stylists.length; i++) {
                if (this.stylists[i].id == stylist_id) {
                    stylistName = this.stylists[i].name;
                    break;
                }
            }

            return stylistName;
        },
        getNameService: function(service_id) {
            var serviceName = '';
            for (var i = 0; i < this.services.length; i++) {
                if (this.services[i].id == service_id) {
                    serviceName = this.services[i].name;
                    break;
                }
            }

            return serviceName;
        },

        showService: function(){
            var authOptions = {
                method: 'GET',
                url: '/api/v0/service',
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then(response => {
                this.$set(this, 'services', response.data.data);
            }).catch((error) => {
            });
        },
        select_service: function(event){
            var service_id = event.target.value;
            var service = {};
            for (var i = 0; i < this.services.length; i++) {
                if (this.services[i].id == service_id) {
                    service = this.services[i];
                    break;
                }
            }
            this.bill.service_product_id = service_id;
            this.bill.service_name = service.name;
            this.bill.price = service.price;
            this.billItem.price = service.price;
            this.billItem.service_name = service.name;
        },
        select_stylist: function(event){
            var stylist_id = event.target.value;
            this.bill.stylist_id = stylist_id;
            this.billItem.stylist_name = this.getNameStylist(stylist_id);
            this.billItem.service_id = stylist_id;
        },
        editBillItem: function(key) {
            if (this.isEditBillItem.status) {
                toastr.error('Please update service is editing!', '', {timeOut: 5000});
                return;
            }

            this.isEditBillItem = {'status': true, 'index': key};
            this.orderItems.get_order_items = this.billItems[key];
        },
        submitEditBillItem: function(key) {
            this.isEditBillItem = {'status': false, 'index': ''};

            var issetBillItem = false;
            for (var i = this.orderItems.length - 1; i >= 0; i--) {
                if (i == key) continue;
                var tmpBill = this.orderItems.get_order_items[i];
                if (tmpBill.service_product_id == this.billItem.service_product_id
                    && tmpBill.stylist_id == this.billItem.stylist_id
                ) {
                    tmpBill.qty = parseInt(tmpBill.qty) + parseInt(this.billItem.qty);
                    issetBillItem  = true;
                    this.billItems[i] = tmpBill;
                    this.billItems.splice(key, 1);
                    break;
                }
            }

            if (!issetBillItem) {
                this.billItems[key] = this.billItem;
                this.billItem.row_total = this.billItem.price * parseInt(this.billItem.qty);
            }
            
            this.billItem = {'qty': 1, 'price': '', 'stylist_id': '', 'service_product_id': ''};
            this.grand_total();
        },
        deleteBillItem: function(key, id) {
            if (!confirm('Do you want to delete this service!')) return;
            var order_item_id = id;
            var authOptions = {
                method: 'DELETE',
                url: '/api/v0/add-booking-service/' + order_item_id,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then(response => {
                this.getListBill(this.booking.id);
                toastr.error(response.data.message, '', {timeOut: 5000});
            }).catch((error) => {
                this.orderItems.get_order_items.splice(key, 1);
                toastr.error(response.data.message, '', {timeOut: 5000});
            });
        },

        bookingDetail: function(list) {
            this.showService();
            this.status = list.status
            var ok = list.phone;
            var self = this;
            var authOptions = {
                method: 'GET',
                url: '/api/v0/get_last_booking_by_phone',
                params: {'phone': ok},
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then(response => {
                this.bill.customer_name = response.data.data.name;
                this.bill.phone = response.data.data.phone;
                this.bill.department_id = response.data.data.department.id;
                this.booking = response.data.data;
                this.bill.order_booking_id = this.booking.id;
                this.bill.order_id = this.booking.id;
                this.formErrors.phone = '';
                this.getListBill(this.booking.id);
                $('#showBill').modal('show');
                this.showStylist();
            }).catch((error) => {   
            });
        },
        createBill: function(event){
            if (this.orderItems.get_order_items.length == 0) {
                toastr.error('Please add at least one service!', '', {timeOut: 5000});
                return;
            }

            if (this.isEditBillItem.status) {
                toastr.error('Please update service is editing!', '', {timeOut: 5000});
                return;
            }

            this.bill.bill_items = JSON.stringify(this.orderItems);
            var authOptions = {
                method: 'POST',
                url: '/api/v0/add-booking-service',
                params: this.bill,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }

            axios(authOptions).then(response => {
                this.billSuccess = response.data.data;
                toastr.success(response.data.message, '', {timeOut: 5000});
                this.resetData();
                $('#showBill').modal('hide');
            }).catch((error) => {
                for (key in error.response.data.message) {
                    toastr.error(error.response.data.message[key], '', {timeOut: 5000});
                }
            });
        },
        getListBill: function(order_booking_id) {
            var authOptions = {
                method: 'get',
                url: '/api/v0/show-booking-service/' + order_booking_id,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then(response => {
               this.$set(this, 'orderItems', response.data.data);
               this.grand_total();
            })
        },
        editBill: function(bill) {
            this.bill = bill;
            this.billItems = bill.bill_items;
            for (var i = this.billItems.length - 1; i >= 0; i--) {
                this.billItems[i].qty = parseInt(this.billItems[i].qty);
                this.billItems[i].stylist_name = this.billItems[i].stylist.name;
                if (!this.billItems[i].service_name) {
                    this.billItems[i].service_name = this.billItems[i].service_product.name;
                }
            }
            this.showStylist();
            $('#showBill').modal('show');
        },

        showLogStatus: function(order_booking_id) {
            var authOptions = {
                method: 'get',
                url: '/api/v0/log-status/' + order_booking_id,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }

            axios(authOptions).then(response => {
                console.log(response.data.data.length);
                this.$set(this, 'logStatus', response.data.data);
                $('#show_log_status').modal('show');
            })
            
        }
    }
});
