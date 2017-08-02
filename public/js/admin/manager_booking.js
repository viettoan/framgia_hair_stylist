axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var manage_service = new Vue({
    el: '#manager_booking',

    data: {
        users: {},
        token: {},
        items: [],
        formErrors: {},
        formErrorsUpdate: {},
        newItem: {},
    },
    mounted : function(){
        // this.users = Vue.ls.get('user');
        // this.token = Vue.ls.get('token');
        // console.log(this.token);
        // this.showInfor(this.pagination.current_page);
    },

    methods: {
        showBooking: function() {
            $('#showBooking').modal('show');
            // console.log(1);
        }
    }
});
