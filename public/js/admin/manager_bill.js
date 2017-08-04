axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var Manager_bill = new Vue({
    el: '#manager_bill',

    data: {
        users: {},
        token: {},
        items: [],
        users: {'name': '', 'phone': ''},
        newItem: {'phone': ''},
        newUser: {'name': ''},
        params: {},
        formErrors: {'phone': ''},
    },
    mounted : function(){
        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});
        this.showUser();
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
            $('#list_service').show();
        },
        selectUser: function(event){
            var value = event.target.value;
            var authOptions = {
                method: 'GET',
                url: '/api/v0/get_booking_by_user_id/'+ value,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then(response => {
                this.$set(this, 'users', response.data.data);
                // console.log(this.users[0].name)

            }).catch((error) => {
            });
        },
        keyPhone: function(event){
            var input = this.newItem;
            var self = this;
            var authOptions = {
                method: 'GET',
                url: '/api/v0/get_last_booking_by_phone',
                params: this.newItem,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then(response => {
                    this.newUser = response.data;
                    // console.log(this.newUser.data.name);
                    this.formErrors.phone = response.data.message;
                }).catch((error) => {
            });
        },
        createBill: function(){
            var params = {
                customer_id: '1',
                phone: '345343',
                status: '2',
                customer_name: 'asdfsad',
                order_booking_id: '2',
                grand_total: '180000',
                bill_items: []
            };

            var bill_items = [
                {
                    "id": '',
                    "service_product_id": "1",
                    "stylist_id": "2",
                    "price": "100000",
                    "qty" : "1",
                    "row_total": "90000"
                },
                {
                    "id": '',
                    "service_product_id": "2",
                    "stylist_id": "2",
                    "price": "100000",
                    "qty" : "1",
                    "row_total": "90000"
                }
            ];
            params.bill_items = bill_items;
        }

    }
});
