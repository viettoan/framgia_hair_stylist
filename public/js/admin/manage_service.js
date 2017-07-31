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
        fillItem: {'id': '', 'name': '', 'short_description': '', 'description': '', 'price': '', 'avg_rate': '', 'total_rate': ''},
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
        this.users = Vue.ls.get('user');
        this.token = Vue.ls.get('token');
        console.log(this.token);
        // this.showInfor(this.pagination.current_page);
    },

    methods: {
        // showInfor: function(page) {
        //     axios.get('/admin/user?page='+ page).then(response => {
        //         this.$set(this, 'items', response.data.data.data);
        //         this.$set(this, 'pagination', response.data.pagination);
        //     })
        // },
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
                    toastr.success('success', '', {timeOut: 5000});
                    this.changePage(this.pagination.current_page);
            }).catch((error) => {
                    if (error.response.status == 403) {
                        self.formErrors = error.response.data.message;
                        console.log(self.formErrors);
                        for (key in self.formErrors) {
                            toastr.error(self.formErrors[key], '', {timeOut: 20000});
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
