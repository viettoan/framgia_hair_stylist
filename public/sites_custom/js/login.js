 axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    var Login = new Vue({
        el: '#pwd-container',

        data: {
            param: {},
            newItem: {'email_or_phone': '', 'password': ''},
            errors: [],
            formErrors: {},
            token: []
        },
        methods: {
            login: function() {
                var self = this;
                var input = this.newItem;
                console.log(input);
                var authOptions = {
                    method: 'POST',
                    url: '/api/v0/login',
                    data: input,
                    json: true,
                    headers: {
                        "Access-Control-Allow-Origin": "*"
                    },
                }
                
                axios(authOptions).then((response) => {
                    localStorage.access_token = response.data.data.token.access_token;
                    localStorage.name = response.data.data.user.name;
                    localStorage.email = response.data.data.user.email;
                    var permisssion = response.data.data.user.permission;
                    if (permisssion == 0) {
                        window.location = '/site/home/';
                    } else {
                        window.location = '/admin/index';
                    }
             }).catch((error) => {
                    self.formErrors = error.response.data.message;
                    toastr.error(this.formErrors, '', {timeOut: 10000});
                })
            }
        }
    });
