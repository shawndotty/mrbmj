
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import router from './routes';
import utils from './utils';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('myAdmin', require('./views/admin/myAdmin.vue'));
Vue.component('login', require('./components/Login.vue'));                           
Vue.prototype.$eventHub = new Vue(); // Global event bus
const app = new Vue({
    el: '#app',
    router
});


