options = {
  namespace: 'vuejs__'
};
Vue.use(VueLocalStorage, options);

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var header = new Vue({
    el: '#header_admin',

    data: {
        users: {},
        token: {}
    },
    mounted : function(){
        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});
        if (this.users.permission != 3) {
            window.location = '/';
        }
        console.log(this.users);
    },
    methods: {
        logout: function() {
            var self = this;
            var authOptions = {
                method: 'POST',
                url: '/api/v0/logout',
                headers: {
                    'Authorization': "Bearer " + this.token.access_token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            
            axios(authOptions).then(response => {
                Vue.ls.remove('token');
                Vue.ls.remove('user');
                this.users = {};
                this.token = {};
                window.location = '/';
            }).catch(function (error) {
                Vue.ls.remove('token');
                Vue.ls.remove('user');
                this.users = {};
                this.token = {};
                window.location = '/';
                self.errors = error.response.data.message;
            });
        }
    }
});
