axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var Manager_bill = new Vue({
    el: '#manager_bill',

    data: {
        users: {},
        token: {},
        items: [],
        users: {'name': '', 'phone': ''},
        newItem: {'phone': ''},
        bookingUser: {'name': '', 'phone': ''},
        departments: [],
        stylists:[],
        services:[],
        bill: {'customer_id': '', 'phone': '', 'status': 0, 'customer_name': '', 
            'order_booking_id': '', 'grand_total': 0, 'department_id': '', 'bill_items': []},
        formErrors: {'phone': ''},
        booking: {},
        billItem: {'qty': 1, 'price': '', 'stylist_id': '', 'service_product_id': ''},
        billItems: [],
        billSuccess: {},

    },
    mounted : function(){
        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});
        this.showUser();
        this.showService();
        this.showDepartment();
        this.showStylist();
        this.users = '';
        $('#list_service').hide();
    },

    methods: {
        showBill: function() {
            $('#create-item').modal('show');
        },
        addBill: function() {
            $('#showBill').modal('show');
        },
        showUser: function() {
            var authOptions = {
                method: 'get',
                url: '/api/v0/get-custommer/',
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then(response => {
                    this.$set(this, 'items', response.data.data.data);
                    console.log(this.items);
                }).catch((error) => {
            });
        },
        addService: function(){
            var error = false;
            if (!this.billItem.stylist_id) {
                toastr.error('Please chon stylist', '', {timeOut: 5000});
                error = true;
            }
            if (!this.billItem.service_product_id) {
                toastr.error('Please chon service', '', {timeOut: 5000});
                error = true;
            }
            if (error) return;

            this.billItem.row_total = this.billItem.price * this.billItem.qty;
            this.billItems.push(this.billItem);
            this.billItem = {'qty': 1, 'price': '', 'stylist_id': '', 'service_product_id': ''};
            var grand_total = 0;
            for (var i = 0; i < this.billItems.length; i++) {
                grand_total += this.billItems[i].row_total;
            }
            this.bill.grand_total = grand_total;
            this.bill.bill_items = this.billItems;
        },
        showDepartment: function(page) {
            axios.get('/api/v0/department').then(response => {
                this.$set(this, 'departments', response.data.data);
            });
        },
        changeDeparment: function(){
            this.showStylist();
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
            }).catch(function (error) {
                this.$set(this, 'stylists', []);
            });
        },
        selectUser: function(event){
            var value = event.target.value;
            var authOptions = {
                method: 'GET',
                url: '/api/v0/get_booking_by_user_id/'+ value,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    // 'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then(response => {
                this.$set(this, 'users', response.data.data)
                }).catch((error) => {
            });
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
            this.billItem.price = service.price;
        },
        select_stylist: function(event){
            var stylist_id = event.target.value;
            var stylist = {};
            for (var i = 0; i < this.stylists.length; i++) {
                if (this.stylists[i].id == stylist_id) {
                    stylist = this.stylists[i];
                    break;
                }
            }
            this.billItem.stylist_name = stylist.name;
        },
        keyPhone: function(event){
            var input = this.newItem;
            var self = this;
            var authOptions = {
                method: 'GET',
                url: '/api/v0/get_last_booking_by_phone',
                params: {'phone': this.bill.phone},
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then(response => {
                this.bill.customer_name = response.data.data.name;
                this.bill.department_id = response.data.data.department.id;
                this.booking = response.data.data;
            }).catch((error) => {
                this.booking = {};
                this.formErrors.phone = error.response.data.message[0];
            });
        },
        createBill: function(event){
            if (this.bill.bill_items.length == 0) {
                toastr.error('Please add it nhat 1 service!', '', {timeOut: 5000});
                return;
            }

            var authOptions = {
                method: 'POST',
                url: '/api/v0/bill',
                params: this.bill,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then(response => {
                this.billSuccess = response.data.data;
                for (key in response.data.message) {
                    toastr.success(response.data.message[key], '', {timeOut: 5000});
                }   
            }).catch((error) => {
                for (key in error.response.data.message) {
                    toastr.error(error.response.data.message[key], '', {timeOut: 5000});
                }
            });
        }

    }
});
