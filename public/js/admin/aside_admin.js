options = {
  namespace: 'vuejs__'
};
Vue.use(VueLocalStorage, options);

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var header = new Vue({
    el: '#aside_amind',

    data: {
        users: {},
        token: {}
    },
    mounted : function(){
        this.users = Vue.ls.get('user', {});
        this.token = Vue.ls.get('token', {});
    },
});
