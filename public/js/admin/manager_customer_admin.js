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
        fillItem: {'id': '', 'name': '', 'phone': '', 'about': '', 'gender': '', 'permission': '', 'birthday': ''},
        deleteItem: {'name':'','id':''},
        isLoadCustomer: false
    },
    mounted : function(){
        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});
        this.showDepartment();
        this.showInfor();
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

        edit_Service: function(item) {
            this.fillItem.name = item.name;
            this.fillItem.short_description = item.short_description;
            this.fillItem.description = item.description;
            this.fillItem.price = item.price;
            this.fillItem.id = item.id;
            $('#edit_Service').modal('show');
        },

        updateService: function(id) {
            var input = this.fillItem;
            var self = this;
            var authOptions = {
                    method: 'PUT',
                    url: '/api/v0/service/' + id,
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
                $("#edit_Service").modal('hide');
                toastr.success('Update Service Success', 'Success', {timeOut: 5000});
                this.showInfor(this.pagination.current_page);
                this.changePage(this.pagination.current_page);
            }).catch((error) => {
                if (error.response.status == 403) {
                    self.formErrors = error.response.data.message;
                    for (key in self.formErrors) {
                        toastr.error(self.formErrors[key], '', {timeOut: 10000});
                    }    
                }
            });
        },

        changePage: function (page) {
            this.params.page = page;
            this.showInfor(page);
        }
    }
});

function myFunction() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("example1");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        } 
    }
};
