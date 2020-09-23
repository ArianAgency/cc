/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('businessSPA', require('./components/SPA/businessSPA.vue').default);
Vue.component('businessesTableComponent', require('./components/table/BusinessTableComponent.vue').default);
Vue.component('newBusinessCreationForm', require('./components/form/newBusinessCreationForm.vue').default);

Vue.component('userSPA', require('./components/SPA/userSPA.vue').default);
Vue.component('UserTableComponent', require('./components/table/UserTableComponent.vue').default);
Vue.component('newUserCreationForm', require('./components/form/newUserCreationForm.vue').default);


Vue.component('customerSPA', require('./components/SPA/customerSPA.vue').default);
Vue.component('CustomerTableComponent', require('./components/table/CustomerTableComponent.vue').default);
Vue.component('newCustomerCreationForm', require('./components/form/newCustomerCreationForm.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',

});


