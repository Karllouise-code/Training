import Vue from 'vue';
import VueRouter from 'vue-router';
// import AxiosPlugin from 'vue-axios-cors';
import VueMeta from 'vue-meta';
import VueSweetalert2 from 'vue-sweetalert2';
import moment from 'moment';
import routes from './routes';
import App from './App.vue';
import './queries';
import swal from 'sweetalert2';

require('./bootstrap');

Vue.use(VueRouter);
// Vue.use(AxiosPlugin);
Vue.use(VueMeta);
Vue.use(VueSweetalert2);
import 'sweetalert2/dist/sweetalert2.min.css';

const router = new VueRouter({ routes });

router.beforeEach((to, from, next) => {
    if (to.matched.some((m) => m.meta.isCustomer === true)) {
        Vue.prototype
            .$query('checkcustomer')
            .then((res) => {
                next();
            })
            .catch((err) => {
                router.push('/');
            });
    }

    if (to.matched.some((m) => m.meta.requiresAuth === false)) {
        next();
        return;
    }
});

Vue.prototype.$appEvents = new Vue();

new Vue({
    router,
    render: (h) => h(App),
}).$mount('#app');
