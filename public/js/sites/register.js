axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var Register = new Vue({
    el: '#resgiter',
    data: {
        items: [],
        pagination: {
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1
        },
        offset: 4,
        newItem: {'email': '',
                    'phone': '',
                    'name': '',
                    'password': '',
                    'password_confirmation': '',
                },
        formErrors: {'email': '',
                        'phone': '',
                        'name': '',
                        'password': '',
                    },
    },
        mounted : function(){},

        methods: {
            createItem: function() {
                var self = this;
                var input = this.newItem;
                 axios.post('/api/v0/register', input).then((response) => {
                    localStorage.access_token = response.data.data.token.access_token;
                    localStorage.name = response.data.data.user.name;
                    localStorage.email = response.data.data.user.email;
                        window.location = '/site/home/';
                 }).catch((error) => {
                    if (error.response.status == 403) {
                        self.formErrors = error.response.data.message;
                        toastr.error(this.formErrors, '', {timeOut: 6000});
                    }
                });
            }
        }
    });
