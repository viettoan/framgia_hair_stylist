axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var manage_service = new Vue({
    el: '#manager_servece   ',

    data: {
        users: {},
        token: {},
        items: [],
        showDepartments:{},
        pagination: {
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1
        },
        offset: 4,
        formErrors: {},
        dataPages: [1],
        params: {'keyword': '', 'per_page': 10, 'page': 1},
        filter: {},
        formErrorsUpdate: {},
        newItem: {'id': '',
            'name': '',
            'email': '',
            'password': '',
            'phone': '',
            'birthday': '',
            'department_id': '',
            'gender': '',
            'permission': '',
            'password_confirmation': '',
            'specialize': '',
            'about_me': ''
        },
        fillItem: {'id': '', 'department_id': '', 'name': '', 'phone': '', 'about': '', 'gender': '', 'permission': '', 'birthday': ''},
        deleteItem: {'name':'','id':''},
        isLoadCustomer: false
    },
    
    mounted : function(){
        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});
        this.showDepartment();
        this.showInfor();
        $("#showBill_Detail").modal("show");
    },

    methods: {
        renderPages: function(total) {
            var pages = [];
            for (var i = 1; i <= Math.ceil(total/this.params.per_page); i++) {
                pages.push(i);
            }
            this.dataPages = pages;
        },

        showInfor: function() {
            var authOptions = {
                method: 'get',
                url: '/api/v0/filter-customer',
                params: this.params,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token
                }
            }
            axios(authOptions).then(response => {
                this.$set(this, 'items', response.data.data.data);
                this.renderPages(response.data.data.total);
            }).catch(error => {
                this.dataPages = [1];
            });
        },

        viewUser: function(item) {
            this.fillItem.name = item.name;
            this.fillItem.email = item.email;
            this.fillItem.phone = item.phone;
            this.fillItem.gender = item.gender;
            this.fillItem.about = item.about_me;
            this.fillItem.email = item.email;
            this.fillItem.birthday = item.birthday;
            $('#showUser').modal('show');
        },

        showDepartment: function(page) {
            axios.get('/api/v0/department').then(response => {
                this.$set(this, 'showDepartments', response.data.data);
            })
        },

        addItem: function(){
            this.formErrors = '';
            $("#create-item").modal('show');
        },

        filteCustomer: function()
        {
            if (!this.isLoadCustomer) {
                this.isLoadCustomer = true;
                var authOptions = {
                    method: 'get',
                    url: '/api/v0/filter-customer',
                    params: this.params,
                    headers: {
                        'Authorization': "Bearer " + this.token.access_token
                    }
                }
                axios(authOptions).then(response => {
                    this.$set(this, 'items', response.data.data.data);
                    this.isLoadCustomer = false;
                }).catch(error => {
                    this.isLoadCustomer = false;
                });
            }
        },

        createItem: function(){
            var self = this;
            var authOptions = {
                    method: 'POST',
                    url: '/api/v0/user',
                    params: this.newItem,
                    headers: {
                        'Authorization': "Bearer " + this.token.access_token,
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    json: true
                }

            axios(authOptions).then((response) => {
                this.newItem = {},
                this.formErrors = '';
                $("#create-item").modal('hide');
                    toastr.success('Create Service Success', 'Success', {timeOut: 5000});
                    this.changePage(this.pagination.current_page);
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

        edit_cutomer: function(item) {
            this.fillItem.id = item.id;
            this.fillItem.name = item.name;
            this.fillItem.email = item.email;
            this.fillItem.phone = item.phone;
            this.fillItem.gender = item.gender;
            this.fillItem.about = item.about_me;
            this.fillItem.email = item.email;
            this.fillItem.birthday = item.birthday;
            this.fillItem.department_id = item.department_id;
            this.fillItem.permission = item.permission;
            $('#edit').modal('show');
        },

        update_customer: function(id) {
            var input = this.fillItem;
            var self = this;
            var authOptions = {
                    method: 'PUT',
                    url: '/api/v0/user/' + id,
                    params: input,
                    headers: {
                        'Authorization': "Bearer " + this.token.access_token,
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    json: true
                }

            axios(authOptions).then((response) => {
                this.newItem = {'id': '', 'name': '', 'short_description': '', 'description': '', 'price': ''},
                this.formErrors = '';
                $("#edit").modal('hide');
                toastr.success('Update Customer Success', 'Success', {timeOut: 5000});
                this.showInfor();
            }).catch((error) => {
                if (error.response.status == 403) {
                    self.formErrors = error.response.data.message;
                    for (key in self.formErrors) {
                        toastr.error(self.formErrors[key], '', {timeOut: 10000});
                    }    
                }
            });
        },

        viewBill: function() {
            $("#showBill_Detail").modal("show");
            $("#showUser").modal("hide");
        },

        hideBill: function(){
            $("#showBill_Detail").modal("hide");
            $("#showUser").modal("show");
        },

        changePage: function (page) {
            this.params.page = page;
            this.showInfor(page);
        }
    }
});
