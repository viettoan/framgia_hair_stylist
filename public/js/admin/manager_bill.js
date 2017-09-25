axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
var Manager_bill = new Vue({
    el: '#manager_bill',

    data: {
        users: {},
        token: {},
        filterParams: {'type': '', 'department_id': '', 'start_date': '', 'end_date': ''},
        inputDate: {'start_date': '', 'end_date': ''},
        listBill: [],
        show_input: {},
        items: [],
        users: {'name': '', 'phone': ''},
        newItem: {'phone': ''},
        departments: [],
        stylists:[],
        services:[],
        bill: {'customer_id': '', 'phone': '', 'status': 0, 'customer_name': '', 
            'order_booking_id': '', 'grand_total': 0, 'department_id': '', 'service_total': ''},
        formErrors: {'phone': ''},
        booking: {},
        billItem: {'qty': 1, 'price': '', 'stylist_id': '', 'service_product_id': ''},
        isEditBillItem: {'status': false, 'index' : ''},
        orderItems: {},
        billSuccess: {},
        exportBill:{'id':'','name_stylist':[],'name_customer':'','phone_customer' :'', 'department_address':'','checkout':'','exportBill_item':[],'service_total':'','grand_total':''},
        booking_inprogress: {},
    },
    mounted : function(){
        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});
        this.getListBill();
        this.showUser();
        this.showService();
        this.showDepartment();
        this.showStylist();
        var timestamp = new Date().getTime() / 1000 | 0;
        this.filterParams.start_date = timestamp;
        this.filterParams.end_date = timestamp;

        var curentDay = new Date().toISOString().slice(0, 10);
        this.inputDate.start_date = curentDay;
        this.inputDate.end_date = curentDay;
        this.showBookingInprogress();

        $('#list_service').hide();
    },

    methods: {
        resetData: function() {
            this.formErrors = {'phone': ''};
            this.bill = {'customer_id': '', 'phone': '', 'status': 0, 'customer_name': '', 
                'order_booking_id': '', 'grand_total': 0, 'department_id': '', 'service_total': ''};
            this.billItems = [];
            this.billItem = {'qty': 1, 'price': '', 'stylist_id': '', 'service_product_id': ''};
            this.booking = {};
            this.isEditBillItem = {'status': false, 'index' : ''};
        },

        getListBill: function() {
            var authOptions = {
                method: 'get',
                url: '/api/v0/filter-bill',
                params: this.filterParams,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then(response => {
                this.$set(this, 'listBill', response.data.data);
            })
        },

        showBill: function() {
            $('#create-item').modal('show');
        },
        exportshowBill: function(item){
            $('#exportshowBill').modal('show');
            this.exportBill.id = item.id;
            this.exportBill.name_customer = item.customer_name;
            this.exportBill.phone_customer = item.phone;
            this.exportBill.checkout=item.created_at;
            this.exportBill.department_address = item.department.address;
            this.exportBill.exportBill_item = item.get_order_booking.get_order_items;
            this.exportBill.grand_total = (item.grand_total).toLocaleString('de-DE');
            this.exportBill.service_total = item.service_total
            },
        addBill: function() {
            $('#showBill').modal('show');
        },
        selectStartDay: function(event) {
            var timestamp = new Date(event.target.value).getTime() / 1000 | 0;
            this.filterParams.start_date = timestamp;
            this.getListBill();
        },

        selectEndDay: function(event) {
            var timestamp = new Date(event.target.value).getTime() / 1000 | 0;
            this.filterParams.end_date = timestamp;
            this.getListBill();
        },
        selectStatus: function(event) {
            var arrStatus = $(event.target).val();
            if (!arrStatus) {
                this.filterParams.status = '';
            } else {
                this.filterParams.status = arrStatus.join(',');
            }
            this.getListBill();
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
                }).catch((error) => {
            });
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
            for (var i = this.billItems.length - 1; i >= 0; i--) {
                var tmpBill = this.billItems[i];
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
                this.billItems.push(this.billItem);
            }
            
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
            this.billItem.price = service.price;
            this.billItem.service_name = service.name;
        },
        select_stylist: function(event){
            var stylist_id = event.target.value;
            
            this.billItem.stylist_name = this.getNameStylist(stylist_id);
        },
        editBillItem: function(key) {
            if (this.isEditBillItem.status) {
                toastr.error('Please update service is editing!', '', {timeOut: 5000});
                return;
            }

            this.isEditBillItem = {'status': true, 'index': key};
            this.billItem = this.billItems[key];
        },
        submitEditBillItem: function(key) {
            this.isEditBillItem = {'status': false, 'index': ''};

            var issetBillItem = false;
            for (var i = this.billItems.length - 1; i >= 0; i--) {
                if (i == key) continue;
                var tmpBill = this.billItems[i];
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
        deleteBillItem: function(key) {
            if (!confirm('Do you want to delete this service!')) return;
            this.billItems.splice(key, 1);
            this.grand_total();
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
                this.bill.customer_id = response.data.data.user_id;
                this.bill.department_id = response.data.data.department.id;
                this.booking = response.data.data;
                this.bill.service_total = this.booking.order_items.length;
                this.bill.grand_total = response.data.data.grand_total;
                console.log(this.bill.grand_total);
                this.bill.order_booking_id = this.booking.id;
                this.formErrors.phone = '';
                $('#booking-inprogress-' + this.booking.id).remove();
                this.showStylist();
            }).catch((error) => {
                this.booking = {};
                this.formErrors.phone = error.response.data.message[0];
                this.bill.order_booking_id = '';
                this.showStylist();
            });
        },
        createBill: function(event){
            if (!confirm('Do you want to create this bill!')) return;
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

            if (this.bill.id) {
                authOptions.method = 'PUT';
                authOptions.url = '/api/v0/bill/' + this.bill.id;
            }

            axios(authOptions).then(response => {
                this.billSuccess = response.data.data;
                for (key in response.data.message) {
                    toastr.success(response.data.message[key], '', {timeOut: 5000});
                }
                this.getListBill();
                this.resetData();
                $('#showBill').modal('hide');
            }).catch((error) => {
                for (key in error.response.data.message) {
                    toastr.error(error.response.data.message[key], '', {timeOut: 5000});
                }
            });
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
        addBillBookingInprogress: function(id) {
            var authOptions = {
                method: 'GET',
                url: '/api/v0/get_booking_by_id/' + id,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            };

            axios(authOptions).then(response => {
                this.bill.customer_name = response.data.data.name;
                this.bill.customer_id = response.data.data.user_id;
                this.bill.department_id = response.data.data.department.id;
                this.booking = response.data.data;
                this.bill.service_total = this.booking.order_items.length;
                this.bill.grand_total = response.data.data.grand_total;
                this.bill.order_booking_id = this.booking.id;
                this.bill.phone = response.data.data.phone;
                this.formErrors.phone = '';
                $('#booking-inprogress-' + this.booking.id).remove();
            });

            $('#showBill').modal('show');
        },
        showBookingInprogress: function() {
            var authOptions = {
                method: 'GET',
                url: '/api/v0/show-booking-inprogress',
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            };

            axios(authOptions).then(response => {
                this.$set(this, 'booking_inprogress', response.data.data);
            }); 
        }
    }
});

function myFunction() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("Myinput");
    filter = input.value.toUpperCase();
    table = document.getElementById("MyTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        } 
    }
};
