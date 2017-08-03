axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var manage_service = new Vue({
    el: '#manager_servece   ',

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
        offset: 4,
        formErrors: {},
        formErrorsUpdate: {},
        newItem: {'id': '', 'name': '', 'short_description': '', 'description': '', 'price': '', 'avg_rate': '', 'total_rate': ''},
        fillItem: {'id': '', 'name': '', 'short_description': '', 'description': '', 'price': ''},
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
    },

    methods: {
        showInfor: function(page) {
            axios.get('/api/v0/service').then(response => {
                console.log(response.data.data);
                this.$set(this, 'items', response.data.data);
            })
        },
        addItem: function(){
            this.formErrors = '';
            $("#create-item").modal('show');
        },
            
        createItem: function(){
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
            this.pagination.current_page = page;
            this.showInfor(page);
        }
    }
});
