
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');
//
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'd9d6cd806b81b1004f5b',
//     cluster: 'us2',
//     encrypted: true
// });

import Echo from 'laravel-echo'
import moment from 'moment'
import toastr from '../../../node_modules/toastr'
import './components/MoneyFormat'
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'd9d6cd806b81b1004f5b',
    cluster: 'us2',
    encrypted: true
});


window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('prueba', require('./components/prueba.vue'));
Vue.component('floorview', require('./components/floorview.vue'));
Vue.component('comanda-ordenes', require('./components/comandaordenes'));
Vue.component('pantallacamarero', require('./components/pantallacamarero.vue'));
Vue.component('panelcomprobante', require('./components/secuanciacomprobante/panelcomprobante.vue'));
Vue.component('reportspanel', require('./components/Reports/panelreports.vue'));
Vue.component('loginv2', require('./components/loginv2/login.vue'));
Vue.component('adminpanel', require('./components/adminpanel/adminpane'));
Vue.component('reportpanel', require('./components/Print/ReportPanel'));
Vue.component('estimate-card', require('./components/estimate/EstimateCard'));
Vue.component('billing-card', require('./components/billing/BillingCard'));
Vue.component('reporte-dgii-panel', require('./components/Reporte607/reporteDGIIPanel'));
Vue.component('payment-methods', require('./components/paymentMethods/paymentsMethodsPanel'));
Vue.component('bill-payment', require('./components/billPayment/billPayment'));
Vue.component('billing-customers', require('./components/billingCustomers/billingCustomer'));
Vue.component('client-details', require('./components/clientDetails/clientDetails'));
Vue.component('user-section', require('./components/RegisterUser/userSection'));
Vue.component('suppliers-section', require('./components/suppliers/suppliersCard'));
Vue.component('print-report-ventas', require('./components/Print/PrintReportVentas'));
Vue.component('purchase-orders', require('./components/purchaseOrders/purchaseOrders'));
Vue.component('report-product-meses', require('./components/ReportProduct/reportTemplate'));
Vue.component('purchase-record', require('./components/purchaseRecord/purchaseRecord'));
Vue.component('purchase-payment', require('./components/purchaseRecord/purchasePayment'));
Vue.component('supplier-details', require('./components/suppliers/supplierDetails'));
Vue.component('returns-invoice', require('./components/ReturnsInvoice/returnsInvoice'));
Vue.component('returns-purchase', require('./components/returnPurchases/returnPurchases'));
Vue.component('invoice-history', require('./components/invoiceHistory/invoiceHistory'));

Vue.prototype.moment = moment;
Vue.prototype.$toastr = toastr;
Vue.prototype.$eventbus = new Vue();

import draggable from 'vuedraggable'
import mouseMenu from 'vue-mouse-menu'
new Vue({
    el: '#Vue',
    components:{
        draggable,
        mouseMenu
    },
    mounted(){
       window.Echo.channel('Orden')
            .listen(".App\\Events\\NewOrdenNotification", (e)=>{
                console.log(e)
                // this.$eventbus.$emit('refresh')
            })
    }
});