axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var manager_department = new Vue({
    el: '#manager_department   ',

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
        newItem: {'id': '', 'department_name': '', 'department_address': '' },
        fillItem: {'id': '', 'department_name': '', 'department_address': ''},
        deleteItem: {'name':'','id':''}
    },
    mounted : function(){
        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});
        this.showInfor(this.pagination.current_page);
    },

    methods: {
        showInfor: function(page) {
            axios.get('/api/v0/department').then(response => {
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
                    toastr.error(response.data.message[key], '', {timeOut: 5000});
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
            this.fillItem.id = item.id;
            this.fillItem.department_name = item.name;
            this.fillItem.department_address = item.address;
            $('#edit_Service').modal('show');
        },

        updateService: function(id) {
            var input = this.fillItem;
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
                this.newItem = {'id': '', 'department_name': '', 'department_address': ''},
                this.formErrors = '';
                $("#edit_Service").modal('hide');
                    toastr.success('Update Service Success', 'Success', {timeOut: 5000});
                    this.showInfor(this.pagination.current_page);
                    this.changePage(this.pagination.current_page);
            }).catch((error) => {
                self.formErrors = error.response.data.message;
                for (key in self.formErrors) {
                    toastr.error(self.formErrors[key], '', {timeOut: 10000});
                }    
            });
        },

        changePage: function (page) {
            this.pagination.current_page = page;
            this.showInfor(page);
        }
    }
});
