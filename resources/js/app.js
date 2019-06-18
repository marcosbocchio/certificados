
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-bottom-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}


window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */


// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('v-select', vSelect)

Vue.component('abm-maestro', require('./components/abm-maestro/abm-maestro.vue').default);
Vue.component('table-users', require('./components/abm-maestro/usuarios/table-users.vue').default);
Vue.component('nuevo-users', require('./components/abm-maestro/usuarios/nuevo-users.vue').default);
Vue.component('table-materiales', require('./components/abm-maestro/materiales/table-materiales.vue').default);
Vue.component('nuevo-materiales', require('./components/abm-maestro/materiales/nuevo-materiales.vue').default);
Vue.component('delete-registro', require('./components/abm-maestro//delete.vue').default);


Vue.component('certificados', require('./components/certificados/certificados.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 *
 */
import 'vue-select/dist/vue-select.css';


import Vuex from 'vuex' 
import vSelect from 'vue-select'

const store = new Vuex.Store({
state: {
        url:process.env.NODE_ENV == 'production' ? 
        process.env.MIX_API_URL_PRO :
        process.env.MIX_API_URL_DEV,
    }

})

export const eventNewRegistro = new Vue();
const app = new Vue({
    el: '#app',   
    store,

});
