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
        params: {},
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
        deleteItem: {'name':'','id':''}
    },
    mounted : function(){
        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});
        this.showDepartment();
        this.showInfor();
        this.params.per_page = '';
    },

    methods: {
        showInfor: function() {
            var authOptions = {
                method: 'get',
                url: '/api/v0/get-custommer',
                params: this.params,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token
                }
            }
            axios(authOptions).then(response => {
                this.$set(this, 'items', response.data.data.data);
                console.log(this.items);
            }).catch(function (error) {
            });
        },
        selectPerPage: function(event) {
            this.params.per_page = event.target.value;
            this.showInfor();
        },
        viewUser: function(item) {
                this.fillItem.name = item.name;
                this.fillItem.email = item.email;
                this.fillItem.phone = item.phone;
                this.fillItem.gender = item.gender;
                this.fillItem.about = item.about_me;
                this.fillItem.email = item.email;
                this.fillItem.birthday = item.birthday;
                // this.fillItem.price = item.price;
                // this.fillItem.id = item.id;
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
