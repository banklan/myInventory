
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VeeValidate from 'vee-validate';
import VueToasted from 'vue-toasted';
import VueModal from 'vue-js-modal';
import Routes from './routes';
import { store } from './store';

Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(VueModal);
Vue.use(VueToasted, {
    duration: 3000
});

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    linkActiveClass: 'active',
    linkExactActiveClass: 'exact-active'
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('admin-sidebar', require('./components/AdminSidebar.vue'));
Vue.component('main-wrap', require('./components/MainWrap.vue'));
// Vue.component('navi', require('./components/nav2.vue'));
Vue.component('admin-search-form', require('./components/AdminSearchForm.vue'));
Vue.component('supervisor-nav', require('./components/Supervisor/SupervisorNav.vue'));
Vue.component('add-stock-modal', require('./components/Supervisor/AddStockModal.vue'));

const app = new Vue({
    el: '#app',
    router,
    store
});
