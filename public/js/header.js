 axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    var header = new Vue({
        el: '#fh5co-header',

        data: {
            users: ''
        },
        mounted : function(){
            this.users = localStorage.name;
            console.log(this.users);
        },
        methods: {
            logout: function() {
                var self = this;
                var authOptions = {
                    method: 'POST',
                    url: '/api/v0/logout',
                    headers: {
                        'Authorization': "Bearer " + localStorage.access_token,
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'crossDomain': true 
                    },
                    json: true
                }
                
                axios(authOptions).then(response => {
                    localStorage.name = '';
                    localStorage.access_token = '';
                    localStorage.email = null;
                    this.user = '';
                    window.location = '/site/home/';
                }).catch(function (error) {
                    self.errors = error.response.data.message;
                });
            }
        }
    });
