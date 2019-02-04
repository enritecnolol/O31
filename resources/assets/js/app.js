
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