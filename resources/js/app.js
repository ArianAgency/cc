/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import {ValidationProvider, extend, localize, ValidationObserver} from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';


localize('fa', fa);
Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});

import fa from 'vee-validate/dist/locale/fa.json';


localize({
    fa: {
        names: {
            name: 'نام',
            password: 'Password',
            family: 'نام خانوادگی',
            father_name: 'نام پدر',
            gender: 'جنسیت',
            mobile: 'موبایل',
            phone: 'تلفن',
            email: 'ایمیل'

        }
    },
});

// Add a rule.
// extend('secret', {
//     validate: value => value === 'example',
//     message: 'این کامه جادویی نیست'
// });

import Multiselect from 'vue-multiselect'

// register globally
Vue.component('multiselect', Multiselect)


// Register it globally
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

import swal from 'sweetalert'

window.Swal = require('sweetalert2')

import {VueCsvImport} from 'vue-csv-import';

Vue.component('vue-csv-import', VueCsvImport);

import Autocomplete from '@trevoreyre/autocomplete-vue'
import '@trevoreyre/autocomplete-vue/dist/style.css'

Vue.use(Autocomplete)


import VueKonva from 'vue-konva'

Vue.use(VueKonva)


import VTooltip from 'v-tooltip'

Vue.use(VTooltip)


import VWave from 'v-wave'

Vue.use(VWave)

//
import ECharts from 'vue-echarts'
import "echarts";
Vue.component('v-chart', ECharts)

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
Vue.component('userInstantChargeSPA', require('./components/SPA/userInstantChargeSPA.vue').default);
Vue.component('userInstantChargeForm', require('./components/form/userInstantChargeForm.vue').default);

Vue.component('customerSPA', require('./components/SPA/customerSPA.vue').default);
Vue.component('CustomerTableComponent', require('./components/table/CustomerTableComponent.vue').default);
Vue.component('newCustomerCreationForm', require('./components/form/newCustomerCreationForm.vue').default);
Vue.component('customerInstantChargeSPA', require('./components/SPA/customerInstantChargeSPA.vue').default);
Vue.component('customerInstantChargeForm', require('./components/form/customerInstantChargeForm.vue').default);
Vue.component('customerCategorySPA', require('./components/SPA/customerCategorySPA.vue').default);
Vue.component('customerCategoryForm', require('./components/form/customerCategoryForm.vue').default);
Vue.component('CategoryTableComponent', require('./components/table/CategoryTableComponent.vue').default);
Vue.component('customerTagSPA', require('./components/SPA/customerTagSPA.vue').default);
Vue.component('customerTagForm', require('./components/form/customerTagForm.vue').default);
Vue.component('TagTableComponent', require('./components/table/TagTableComponent.vue').default);
Vue.component('customerCardSPA', require('./components/SPA/customerCardSPA.vue').default);
Vue.component('customerCardForm', require('./components/form/customerCardForm.vue').default);
Vue.component('customerGroupCardSPA', require('./components/SPA/customerGroupCardSPA.vue').default);
Vue.component('customerGroupCardForm', require('./components/form/customerGroupCardForm.vue').default);
Vue.component('CustomerGroupCardTableComponent', require('./components/table/CustomerGroupCardTableComponent.vue').default);
/*
customer panel
 */
Vue.component('customerProfile', require('./components/customer/customerProfile.vue').default);
Vue.component('customerScoreConvertor', require('./components/customer/customerScoreConvertor.vue').default);


Vue.component('serviceSPA', require('./components/SPA/serviceSPA.vue').default);
Vue.component('ServiceTableComponent', require('./components/table/ServiceTableComponent.vue').default);
Vue.component('newServiceCreationForm', require('./components/form/newServiceCreationForm.vue').default);
Vue.component('serviceCategorySPA', require('./components/SPA/serviceCategorySPA.vue').default);
Vue.component('serviceTagSPA', require('./components/SPA/serviceTagSPA').default);
Vue.component('serviceCategoryForm', require('./components/form/serviceCategoryForm').default);
Vue.component('serviceTagForm', require('./components/form/serviceTagForm').default);
Vue.component('ServiceCategoryTableComponent', require('./components/table/ServiceCategoryTableComponent').default);
Vue.component('ServiceTagTableComponent', require('./components/table/ServiceTagTableComponent').default);


Vue.component('xsensSPA', require('./components/SPA/xsensSPA').default);
Vue.component('XsensTableComponent', require('./components/table/XsensTableComponent').default);
Vue.component('newXsensCreationForm', require('./components/form/newXsensCreationForm').default);

Vue.component('servicesXsenseJunctionSPA', require('./components/SPA/servicesXsenseJunctionSPA').default);
Vue.component('Jservices_xsenseTableComponent', require('./components/table/Jservices_xsenseTableComponent').default);
Vue.component('newSerXsensCreationForm', require('./components/form/newSerXsensCreationForm').default);


Vue.component('scoreConvertorSPA', require('./components/SPA/scoreConvertorSPA').default);


Vue.component('purchaseSPA', require('./components/SPA/purchaseSPA').default);
Vue.component('PurchaseHistoryTableComponent', require('./components/table/PurchaseHistoryTableComponent').default);

//REPORT
Vue.component('ReportSPA', require('./components/SPA/reportSPA').default);
Vue.component('customerAnalyze', require('./components/report/customerAnalyze').default);
Vue.component('customerAnalyzeVolumePercent', require('./components/report/customerAnalyzeVolumePercent').default);
Vue.component('salePerCustomerType', require('./components/report/salePerCustomerType').default);
Vue.component('saleCountAndVolume', require('./components/report/saleCountAndVolume').default);
Vue.component('clubSummary', require('./components/report/clubSummary').default);

Vue.component('pagination', require('laravel-vue-pagination'));
//TOOLS
// card designer
Vue.component('cardDesigner', require('./components/tools/cardDesigner').default);
//table template
Vue.component('tableTemplate', require('./components/Template/tableTemplate').default);
//SpaMainTemplate
Vue.component('SpaMainTemplate', require('./components/template/SpaMainTemplate').default);
//ModalDialog
Vue.component('ModalDialog', require('./components/tools/ModalDialog').default);
//TOOLS
//POS
Vue.component('posSPA', require('./components/POS/PosSPA').default);
Vue.component('posHeader', require('./components/POS/PosHeader').default);
Vue.component('posSideBar', require('./components/POS/PosSideBar').default);
Vue.component('posInvoiceItem', require('./components/POS/PosInvoiceItem').default);
Vue.component('servicesCardObject', require('./components/POS/ServicesCardObject').default);
Vue.component('simpleServicesCardObject', require('./components/POS/SimpleServicesCardObject').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});



