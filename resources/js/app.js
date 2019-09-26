
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
  "timeOut": "10000",
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
Vue.component('v-select', vSelect);

import Vue from 'vue'
import VueLazyLoad from 'vue-lazyload'
/*
vSelect.props.components.default = () => ({
  Deselect: {
    render: createElement => createElement('span', '❌'),
  },
  OpenIndicator: {
    render: createElement => createElement('span', '🔽'),
  },
});
*/
Vue.component('app-icon', require('./components/app-icon.vue').default);
Vue.component('abm-maestro', require('./components/abm-maestro/abm-maestro.vue').default);
Vue.component('table-users', require('./components/abm-maestro/usuarios/table-users.vue').default);
Vue.component('nuevo-users', require('./components/abm-maestro/usuarios/nuevo-users.vue').default);
Vue.component('editar-users', require('./components/abm-maestro/usuarios/editar-users.vue').default);
Vue.component('table-clientes', require('./components/abm-maestro/clientes/table-clientes.vue').default);
Vue.component('nuevo-clientes', require('./components/abm-maestro/clientes/nuevo-clientes.vue').default);
Vue.component('editar-clientes', require('./components/abm-maestro/clientes/editar-clientes.vue').default);

Vue.component('table-unidades_medidas', require('./components/abm-maestro/unidades-medidas/table-unidades_medidas.vue').default);
Vue.component('nuevo-unidades_medidas', require('./components/abm-maestro/unidades-medidas/nuevo-unidades_medidas.vue').default);
Vue.component('editar-unidades_medidas', require('./components/abm-maestro/unidades-medidas/editar-unidades_medidas.vue').default);

Vue.component('table-medidas', require('./components/abm-maestro/medidas/table-medidas.vue').default);
Vue.component('nuevo-medidas', require('./components/abm-maestro/medidas/nuevo-medidas.vue').default);
Vue.component('editar-medidas', require('./components/abm-maestro/medidas/editar-medidas.vue').default);

Vue.component('table-productos', require('./components/abm-maestro/productos/table-productos.vue').default);
Vue.component('nuevo-productos', require('./components/abm-maestro/productos/nuevo-productos.vue').default);
Vue.component('editar-productos', require('./components/abm-maestro/productos/editar-productos.vue').default);

Vue.component('table-servicios', require('./components/abm-maestro/servicios/table-servicios.vue').default);
Vue.component('nuevo-servicios', require('./components/abm-maestro/servicios/nuevo-servicios.vue').default);
Vue.component('editar-servicios', require('./components/abm-maestro/servicios/editar-servicios.vue').default);



Vue.component('table-materiales', require('./components/abm-maestro/materiales/table-materiales.vue').default);
Vue.component('nuevo-materiales', require('./components/abm-maestro/materiales/nuevo-materiales.vue').default);
Vue.component('delete-registro', require('./components/abm-maestro//delete.vue').default);

Vue.component('table-documentaciones', require('./components/abm-maestro/documentaciones/table-documentaciones.vue').default);
Vue.component('editar-documentaciones', require('./components/abm-maestro/documentaciones/editar-documentaciones.vue').default);

Vue.component('abm-doc', require('./components/documentaciones/abm-doc.vue').default);

Vue.component('dashboard-enod', require('./components/dashboard/dashboard-enod').default);
Vue.component('ot-operarios', require('./components/dashboard/operarios/ot-operarios').default);
Vue.component('ot-informes', require('./components/dashboard/informes/ot-informes').default);
Vue.component('ot-remitos', require('./components/dashboard/remitos/ot-remitos').default);
Vue.component('ot-soldadores', require('./components/dashboard/soldadores/ot-soldadores').default);
Vue.component('ot-documentaciones', require('./components/dashboard/documentaciones/ot-documentaciones').default);
Vue.component('table-ot_procedimientos_propios', require('./components/dashboard/procedimientos/table-ot_procedimientos_propios').default);



Vue.component('ots', require('./components/ots/ots.vue').default);
Vue.component('create-referencias', require('./components/ots/referencias/create.vue').default);


Vue.component('remitos', require('./components/remitos/remitos.vue').default);



  /* Infomres    */
  Vue.component('informe-ri', require('./components/informes/informe-ri.vue').default);
  Vue.component('informe-pm', require('./components/informes/informe-pm.vue').default);
  Vue.component('informe-header', require('./components/informes/informe-header.vue').default);




Vue.prototype.Laravel = window.Laravel;



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 *
 */
import 'vue-select/dist/vue-select.css';

const VueGoogleMaps = require('vue2-google-maps');

Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyAjnyOfVeT0QoN9rOws7-xAE8tR8ndyVD8',
    libraries: 'places', 
    // This is required if you use the Autocomplete plugin
    // OR: libraries: 'places,drawing'
    // OR: libraries: 'places,drawing,visualization'
    // (as you require)

    //// If you want to set the version, you can do so:
    // v: '3.26',
  },

    //// If you intend to programmatically custom event listener code
    //// (e.g. `this.$refs.gmap.$on('zoom_changed', someFunc)`)
    //// instead of going through Vue templates (e.g. `<GmapMap @zoom_changed="someFunc">`)
    //// you might need to turn this on.
    // autobindAllEvents: false,

    //// If you want to manually install components, e.g.
    // import {GmapMarker} from 'vue2-google-maps/src/components/marker';
   //  Vue.component('GmapMarker', GmapMarker);
    ////then disable the following:
     installComponents: true,
})
Vue.use(VueLazyLoad);
import Vuex from 'vuex' ;
import vSelect from 'vue-select';
import ProgressBar from 'vuejs-progress-bar'
Vue.use(ProgressBar)

const store = new Vuex.Store({
  
state: {
        
        url:process.env.NODE_ENV == 'production' ? 
        process.env.MIX_API_URL_PRO :
        process.env.MIX_API_URL_DEV,

        AppUrl:process.env.NODE_ENV == 'production' ? 
        process.env.MIX_URL_PRO :
        process.env.MIX_URL_DEV,
        provincias:[],
        unidades_medidas:[],
        metodos_ensayos:[],

       
    },

actions : {

        loadData({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'provincias' + '?api_token=' + Laravel.user.api_token;  
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            commit('getProvincias', response.data)           
          })
        },

        loadUnidadesMedidas({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'unidades_medidas' + '?api_token=' + Laravel.user.api_token;  
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            commit('getUnidadesMedidas', response.data)           
          })
        },

        loadMetodosEnsayos({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'metodo_ensayos' + '?api_token=' + Laravel.user.api_token;  
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            commit('getMetodosEnsayos', response.data)           
          })
        }
    },
    mutations: {
      getProvincias(state, provincias) {
        state.provincias = provincias
      },

      getUnidadesMedidas(state, unidadesMedidas) {
        state.unidades_medidas = unidadesMedidas
      },

      getMetodosEnsayos(state, metodoEnsayos) {
        state.metodos_ensayos = metodoEnsayos
      },
    }

})

export const eventNewRegistro = new Vue();
export const eventSetReferencia = new Vue();
export const eventEditRegistro = new Vue();

const app = new Vue({
    el: '#app',   
    store,
    
    
});
