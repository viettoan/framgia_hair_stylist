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
                Vue.ls.set('token', response.data.data.token);
                Vue.ls.set('user', response.data.data.user);
                var permisssion = response.data.data.user.permission;
                if (permisssion == 3) {
                    window.location = '/admin/home/';
                } else {
                    window.location = '/site/home';
                }
         }).catch((error) => {
                self.formErrors = error.response.data.message;
                toastr.error(this.formErrors, '', {timeOut: 10000});
            })
        }
    }
});
