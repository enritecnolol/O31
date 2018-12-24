
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('prueba', require('./components/prueba.vue'));
Vue.component('floorview', require('./components/floorview.vue'));

import draggable from 'vuedraggable'
import mouseMenu from 'vue-mouse-menu'
new Vue({
    el: '#Vue',
    components:{
        draggable,
        mouseMenu
    }
});