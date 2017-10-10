axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var manage_service = new Vue({
    el: '#manager_servece   ',

    data: {
        users: {},
        token: {},
        items: [],
        detele_item:[],
        pagination: {
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1
        },
        offset: 4,
        formErrors: {},
        formErrorsUpdate: {},
        newItem: {'id': '', 'name': '', 'short_description': '', 'description': '', 'price': '', 'avg_rate': '', 'total_rate': ''},
        fillItem: {'id': '', 'name': '', 'short_description': '', 'description': '', 'price': ''},
        deparments: {'id': '', 'department_name': '', 'department_address': '' },
        fillDeparments: {'id': '', 'department_name': '', 'department_address': '' },
        deleteItem: {'name':'','id':''}
    },

    computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },
    
    mounted : function(){
        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});
        this.showInfor(this.pagination.current_page);
        this.showDeparment();
    },

    methods: {
        showDeparment: function() {
            axios.get('/api/v0/department').then(response => {
                this.$set(this, 'deparments', response.data.data);
            })
        },
        showInfor: function(page) {
            axios.get('/api/v0/service').then(response => {
                this.$set(this, 'items', response.data.data);
            })
        },
        addItem: function(){
            this.formErrors = '';
            $("#create-item").modal('show');
        },
        createDeparment: function() {
            if (!confirm('Do you want to create this Deparment!')) return;
            var self = this;
            var authOptions = {
                method: 'POST',
                url: '/api/v0/department',
                params: this.newItem,
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then((response) => {
                for (key in response.data.message) {
                    toastr.success(response.data.message[key], '', {timeOut: 5000});
                }
                this.showDeparment();
            }).catch((error) => {
                self.formErrors = error.response.data.message;
                for (key in self.formErrors) {
                    toastr.error(self.formErrors[key], '', {timeOut: 10000});
                }    
            });
        },
        editDeparment: function(item) {
            this.fillDeparments.id = item.id;
            this.fillDeparments.department_name = item.name;
            this.fillDeparments.department_address = item.address;
            $('#editDeparment').modal('show');
        },
        updateDeparment: function(id) {
            if (!confirm('Do you want to update this Deparment!')) return;
            var input = this.fillDeparments;
            var self = this;
            var authOptions = {
                    method: 'PUT',
                    url: '/api/v0/department/' + id,
                    params: input,
                    headers: {
                        'Authorization': "Bearer " + this.token.access_token,
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    json: true
                }

            axios(authOptions).then((response) => {
                this.deparments = {'id': '', 'department_name': '', 'department_address': ''},
                toastr.success('Update Deparment Success', 'Success', {timeOut: 5000});
                $('#editDeparment').modal('hide');
                this.showDeparment();
            }).catch((error) => {
                self.formErrors = error.response.data.message;
                for (key in self.formErrors) {
                    toastr.error(self.formErrors[key], '', {timeOut: 10000});
                }    
            });
        },
        createItem: function(){
            if (!confirm('Do you want to create this service!')) return;
            var self = this;
            var input = this.newItem;
            input.avg_rate = 0;
            input.total_rate = 0;
            var authOptions = {
                    method: 'POST',
                    url: '/api/v0/service',
                    params: input,
                    headers: {
                        'Authorization': "Bearer " + this.token.access_token,
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    json: true
                }

            axios(authOptions).then((response) => {
                this.newItem = {'id': '', 'name': '', 'short_description': '', 'description': '', 'price': '', 'avg_rate': '', 'total_rate': ''},
                this.formErrors = '';

                self.formErrors = response.data.message;
                for (key in self.formErrors) {
                    toastr.success(self.formErrors[key], '', {timeOut: 5000});
                }   
                $("#create-item").modal('hide');
                this.changePage(this.pagination.current_page);
            }).catch((error) => {
                self.formErrors = error.response.data.message;
                for (key in self.formErrors) {
                    toastr.error(self.formErrors[key], '', {timeOut: 10000});
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

        comfirmDeleteItem:function(item_id){
            $('#delete-item').modal('show');
            this.delete_item = item_id;
        },
        delItem:function(item){
            var self = this;
            var authOptions = {
                    method: 'DELETE',
                    url: ' /api/v0/service/' + item.id,
                    headers: {
                        'Authorization': "Bearer " + this.token.access_token,
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    json: true
                }
            axios(authOptions).then((response) => {
                $("#delete-item").modal('hide');
                    toastr.success('Delete Service Success', 'Success', {timeOut: 5000});
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

        changePage: function (page) {
            this.pagination.current_page = page;
            this.showInfor(page);
        }
    }
});
