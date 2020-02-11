
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

const toastrWarning = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
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
Vue.component('subir-imagen', require('./components/subir-imagen.vue').default);
Vue.component('abm-maestro', require('./components/abm-maestro/abm-maestro.vue').default);

Vue.component('table-users', require('./components/abm-maestro/usuarios/table-users.vue').default);
Vue.component('nuevo-users', require('./components/abm-maestro/usuarios/nuevo-users.vue').default);
Vue.component('editar-users', require('./components/abm-maestro/usuarios/editar-users.vue').default);

Vue.component('table-clientes', require('./components/abm-maestro/clientes/table-clientes.vue').default);
Vue.component('nuevo-clientes', require('./components/abm-maestro/clientes/nuevo-clientes.vue').default);
Vue.component('editar-clientes', require('./components/abm-maestro/clientes/editar-clientes.vue').default);

//contratistas
Vue.component('table-contratistas', require('./components/abm-maestro/contratistas/table-contratistas.vue').default);
Vue.component('nuevo-contratistas', require('./components/abm-maestro/contratistas/nuevo-contratistas.vue').default);
Vue.component('editar-contratistas', require('./components/abm-maestro/contratistas/editar-contratistas.vue').default);

//norma ensayos
Vue.component('table-norma_ensayos', require('./components/abm-maestro/norma-ensayos/table-norma_ensayos.vue').default);
Vue.component('nuevo-norma_ensayos', require('./components/abm-maestro/norma-ensayos/nuevo-norma_ensayos.vue').default);
Vue.component('editar-norma_ensayos', require('./components/abm-maestro/norma-ensayos/editar-norma_ensayos.vue').default);

//norma evaluaciones
Vue.component('table-norma_evaluaciones', require('./components/abm-maestro/norma-evaluaciones/table-norma_evaluaciones.vue').default);
Vue.component('nuevo-norma_evaluaciones', require('./components/abm-maestro/norma-evaluaciones/nuevo-norma_evaluaciones.vue').default);
Vue.component('editar-norma_evaluaciones', require('./components/abm-maestro/norma-evaluaciones/editar-norma_evaluaciones.vue').default);


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


Vue.component('table-fuentes', require('./components/abm-maestro/fuentes/table-fuentes.vue').default);
Vue.component('editar-fuentes', require('./components/abm-maestro/fuentes/editar-fuentes.vue').default);
Vue.component('nuevo-fuentes', require('./components/abm-maestro/fuentes/nuevo-fuentes.vue').default);

Vue.component('table-interno_fuentes', require('./components/abm-maestro/interno-fuentes/table-interno_fuentes.vue').default);
Vue.component('editar-interno_fuentes', require('./components/abm-maestro/interno-fuentes/editar-interno_fuentes.vue').default);
Vue.component('nuevo-interno_fuentes', require('./components/abm-maestro/interno-fuentes/nuevo-interno_fuentes.vue').default);

Vue.component('table-equipos', require('./components/abm-maestro/equipos/table-equipos.vue').default);
Vue.component('editar-equipos', require('./components/abm-maestro/equipos/editar-equipos.vue').default);
Vue.component('nuevo-equipos', require('./components/abm-maestro/equipos/nuevo-equipos.vue').default);

Vue.component('table-interno_equipos', require('./components/abm-maestro/interno-equipos/table-interno_equipos.vue').default);
Vue.component('editar-interno_equipos', require('./components/abm-maestro/interno-equipos/editar-interno_equipos.vue').default);
Vue.component('nuevo-interno_equipos', require('./components/abm-maestro/interno-equipos/nuevo-interno_equipos.vue').default);

Vue.component('soldadores', require('./components/abm-maestro/soldadores/soldadores.vue').default);
Vue.component('table-soldadores', require('./components/abm-maestro/soldadores/table-soldadores.vue').default);
Vue.component('nuevo-soldadores', require('./components/abm-maestro/soldadores/nuevo-soldadores.vue').default);
Vue.component('editar-soldadores', require('./components/abm-maestro/soldadores/editar-soldadores.vue').default);

Vue.component('table-materiales', require('./components/abm-maestro/materiales/table-materiales.vue').default);
Vue.component('nuevo-materiales', require('./components/abm-maestro/materiales/nuevo-materiales.vue').default);
Vue.component('editar-materiales', require('./components/abm-maestro/materiales/editar-materiales.vue').default);

Vue.component('table-roles', require('./components/abm-maestro/roles/table-roles.vue').default);
Vue.component('editar-roles', require('./components/abm-maestro/roles/editar-roles.vue').default);
Vue.component('nuevo-roles', require('./components/abm-maestro/roles/nuevo-roles.vue').default);

Vue.component('table-permissions', require('./components/abm-maestro/permisos/table-permissions.vue').default);
Vue.component('editar-permissions', require('./components/abm-maestro/permisos/editar-permissions.vue').default);
Vue.component('nuevo-permissions', require('./components/abm-maestro/permisos/nuevo-permissions.vue').default);

Vue.component('delete-registro', require('./components/abm-maestro//delete.vue').default);

Vue.component('table-documentaciones', require('./components/abm-maestro/documentaciones/table-documentaciones.vue').default);
Vue.component('editar-documentaciones', require('./components/abm-maestro/documentaciones/editar-documentaciones.vue').default);

Vue.component('abm-doc', require('./components/documentaciones/abm-doc.vue').default);
Vue.component('abm-placas', require('./components/dashboard/placas-ri/abm-placas.vue').default);


Vue.component('dashboard-enod', require('./components/dashboard/dashboard-enod').default);
Vue.component('ot-operarios', require('./components/dashboard/operarios/ot-operarios').default);
Vue.component('ot-interno-equipos', require('./components/dashboard/interno-equipos/ot-interno-equipos').default);
Vue.component('ot-informes', require('./components/dashboard/informes/ot-informes').default);
Vue.component('informes-importables', require('./components/dashboard/informes/informes-importables').default);
Vue.component('ot-remitos', require('./components/dashboard/remitos/ot-remitos').default);
Vue.component('ot-partes', require('./components/dashboard/partes/ot-partes').default);
Vue.component('ot-soldadores', require('./components/dashboard/soldadores/ot-soldadores').default);
Vue.component('ot-documentaciones', require('./components/dashboard/documentaciones/ot-documentaciones').default);
Vue.component('table-ot_procedimientos_propios', require('./components/dashboard/procedimientos/table-ot_procedimientos_propios').default);
Vue.component('table-placas_ri', require('./components/dashboard/placas-ri/table-placas_ri').default);

Vue.component('partes', require('./components/partes/partes.vue').default);
Vue.component('parte-header', require('./components/partes/parte-header.vue').default);

Vue.component('ots', require('./components/ots/ots.vue').default);
Vue.component('create-referencias', require('./components/ots/referencias/create.vue').default);

Vue.component('remitos', require('./components/remitos/remitos.vue').default);

/* Informes    */
Vue.component('informe-ri', require('./components/informes/informe-ri.vue').default);
Vue.component('informe-pm', require('./components/informes/informe-pm.vue').default);
Vue.component('informe-lp', require('./components/informes/informe-lp.vue').default);
Vue.component('informe-us', require('./components/informes/informe-us.vue').default);
Vue.component('informe-header', require('./components/informes/informe-header.vue').default);

/* Dosimetria */
Vue.component('dosimetria-operador', require('./components/dosimetria/dosimetria-operador.vue').default);
Vue.component('dosimetria-rx', require('./components/dosimetria/dosimetria-rx.vue').default);
Vue.component('dosimetria-estados', require('./components/dosimetria/dosimetria-estados.vue').default);
Vue.component('operador-periodo', require('./components/dosimetria/operador-periodo.vue').default);
Vue.component('dosimetria-resumen', require('./components/dosimetria/dosimetria-resumen.vue').default);




Vue.prototype.Laravel = window.Laravel;

/**loadOperadoresDisometria
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
import { resolve } from 'url';
Vue.use(ProgressBar)

const store = new Vuex.Store({
  
state: {
        
        url:process.env.NODE_ENV == 'production' ? 
        process.env.MIX_API_URL_PRO :
        process.env.MIX_API_URL_DEV,
        AppUrl:process.env.NODE_ENV == 'production' ? 
        process.env.MIX_URL_PRO :
        process.env.MIX_URL_DEV,
        
        fecha :'',
        operadores:[],
        obra_informe:'',
        contratistas:[],
        provincias:[],
        localidades:[],
        materiales:[],
        diametros:[],
        espesores:[],
        procedimientos:[],
        unidades_medidas:[],
        metodos_ensayos:[],
        norma_evaluaciones:[],
        norma_ensayos:[],
        interno_equipo_show:{},
        interno_equipos_activos:[],
        interno_fuentes_activos:[],
        fuentes:[],
        equipos:[],
        fuentePorInterno:{},
        penetrantes_tipo_liquido:[],
        reveladores_tipo_liquido:[],
        removedores_tipo_liquido:[],
        roles:[],
        permisos:[],
        iluminaciones:[],
        ejecutor_ensayos:[],
        CantInformes:'0',
        CantOperadores :'0',
        CantRemitos:'0',
        CantInternoEquipos:'0',
        CantPartes:'0',
        CantSoldadores:'0',
        CantDocumentaciones:'0',
        CantProcedimientos:'0',
        CantUsuariosCliente:'0',
        curie:'0',
        ParametroGeneral:{},
        DDPPI:false,
        DiasDelMes:'0',
        operadores_dosimetria:[],
        dosimetria_operador:[],
        dosimetria_rx:[],
        dosimetria_estados:[],
        dosimetria_resumen:[],

    },

actions : {

        loadFechaActual({
          commit}) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'fecha_actual'  + '?api_token=' + Laravel.user.api_token;     
          return new Promise((resolve, reject) => {          
          axios.get(urlRegistros).then((response) => {     
          console.log(response.data);
          commit('getFechaActual', response.data) 
          resolve()       
             })    

        })
        },

        loadObraInformes({
          commit},payload) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'informes/' + payload.informe_id + '/importado_sn/' + (payload.importado_sn ? 1 : 0 )  +'?api_token=' + Laravel.user.api_token;        
          return new Promise((resolve, reject) => {         
          axios.get(urlRegistros).then((response) => {
            console.log(response.data);
            commit('getObraInforme', response.data)   
            resolve()       
            })        
          })
        },

        loadParametrosGenerales({
          commit},codigo) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'parametros_generales/' + codigo + '?api_token=' + Laravel.user.api_token;   
          return new Promise((resolve, reject) => {          
          axios.get(urlRegistros).then((response) => {     

          commit('getParametroGeneral', response.data)   

          resolve()       
          })
        })
        },

        loadDDPPI({
          commit},ot_id) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'partes/'+ 'ot/' + ot_id + '/ddppi' +'?api_token=' + Laravel.user.api_token;   
          return new Promise((resolve, reject) => {          
          axios.get(urlRegistros).then((response) => {     

          commit('getDDPPI', response.data)   

          resolve()       
          })
        })
        },

        loadContratistas({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'contratistas' + '?api_token=' + Laravel.user.api_token;  
          axios.get(urlRegistros).then((response) => {
            commit('getContratistas', response.data)           
          })
        },

        loadProvincias({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'provincias' + '?api_token=' + Laravel.user.api_token;  
          axios.get(urlRegistros).then((response) => {
            commit('getProvincias', response.data)           
          })
        },

        loadLocalidades({
          commit},provincia_id) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'localidades/' + provincia_id + '?api_token=' + Laravel.user.api_token;        
          axios.get(urlRegistros).then((response) => {
            console.log(response.data);
            commit('getLocalidades', response.data)           
          })
        },

        loadMateriales({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'materiales' + '?api_token=' + Laravel.user.api_token;  
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            commit('getMateriales', response.data)           
          })
        },

        loadDiametros({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'diametros' + '?api_token=' + Laravel.user.api_token;  
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            commit('getDiametros', response.data)           
          })
        },

        loadEspesores({
          commit},diametro_code) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'espesor/' + diametro_code + '?api_token=' + Laravel.user.api_token;         
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            commit('getEspesores', response.data)           
          })
        },

        loadProcedimietosOtMetodo({
          commit},payload) {
          axios.defaults.baseURL = store.state.url 
          console.log(payload);
          var urlRegistros = 'procedimientos_informes/ot/' + payload.ot_id + '/metodo/' + payload.metodo + '?api_token=' + Laravel.user.api_token;         
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {     
            console.log(response.data);   
            commit('getProcedimientosOtMetodo', response.data)           
          })
        },

        loadNormaEvaluaciones({
          commit}) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'norma_evaluaciones' + '?api_token=' + Laravel.user.api_token;        
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            commit('getNormaEvaluaciones', response.data)           
          })
        },

        loadNormaEnsayos({
          commit}) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'norma_ensayos' + '?api_token=' + Laravel.user.api_token;        
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            commit('getNormaEnsayos', response.data)           
          })
        },

        loadUnidadesMedidas({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'unidades_medidas/' + '?api_token=' + Laravel.user.api_token;  
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
        },

        loadInternoEquiposActivos({
          commit},metodo = null) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'interno_equipos/metodo/' + metodo + '/activos' + '?api_token=' + Laravel.user.api_token;         
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            console.log(response.data);
            commit('getInternoEquiposActivos', response.data)           
          })
        }, 

        loadUbicacionInternoEquipo({
          commit},id) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'interno_equipos/' + id + '?api_token=' + Laravel.user.api_token;         
          console.log(urlRegistros);
          return new Promise((resolve, reject) => {
              axios.get(urlRegistros).then((response) => {
                console.log(response.data);
                commit('getUbicacionInternoEquipo', response.data) ;   
                resolve()       
              })
            })
        }, 
        
        loadInternoFuentesActivos({
          commit}) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'interno_fuentes/' + 'activos' + '?api_token=' + Laravel.user.api_token;         
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            console.log(response.data);
            commit('getInternoFuentesActivos', response.data)           
          })
        },

        loadEquipos({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'equipos' + '?api_token=' + Laravel.user.api_token;  
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            commit('getEquipos', response.data)           
          })
        },

        loadFuentes({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'fuentes' + '?api_token=' + Laravel.user.api_token;  
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            commit('getFuentes', response.data)           
          })
        },

        loadFuentePorInterno({
          commit},interno_fuente_id) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'fuentes/interno_fuente/' + interno_fuente_id  + '?api_token=' + Laravel.user.api_token;     
          return new Promise((resolve, reject) => {          
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            console.log(response.data);
            commit('getFuentePorInterno', response.data)     
            resolve()       
          })      
          })
        },  
        
        loadTipoLiquidos({
          commit},tipo) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'tipo_liquidos/' + tipo +  '?api_token=' + Laravel.user.api_token;         
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            console.log(response.data);
            commit('getTipoLiquidos',{ 'liquidos' :response.data,'tipo' : tipo })           
          })
        }, 

        loadIluminaciones({
          commit}) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'iluminaciones' + '?api_token=' + Laravel.user.api_token;        
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            console.log(response.data);
            commit('getIluminaciones', response.data)           
          })
        },

        loadEjecutorEnsayo({
          commit},ot_id) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'ot-operarios/ot/' + ot_id + '?api_token=' + Laravel.user.api_token;        
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            console.log(response.data);
            commit('getEjecutorEnsayo', response.data)           
          })
        },

        loadOperadores({
          commit}) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros ='ot-operarios/users' + '?api_token=' + Laravel.user.api_token;                
           axios.get(urlRegistros).then((response) => {
           commit('getOperadores', response.data)           
          })
        },

        loadOperadoresDisometria({
          commit}) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros ='dosimetria_operador/operadores' + '?api_token=' + Laravel.user.api_token;      
           axios.get(urlRegistros).then((response) => {
            console.log(urlRegistros);
            console.log(response.data);       
            console.log('entro en operadores dosimetria');  
           commit('getOperadoresDosimetria', response.data)           
          })
        },

        loadDosimetriaResumen({
          commit},year) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros ='dosimetria_resumen/year/'+ year + '?api_token=' + Laravel.user.api_token;    
           return new Promise((resolve, reject) => {   
           axios.get(urlRegistros).then((response) => {
           console.log(response.data);          
           commit('getDosimetriaResumen', response.data)  
           resolve()       
          })         
          })
        },

        loadDosimetriaOperador({
          commit},payload) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros ='dosimetria_operador/operador/' + payload.operador_id + '/year/' + payload.year + '/month/' + payload.month + '?api_token=' + Laravel.user.api_token;   
           return new Promise((resolve, reject) => {             
           axios.get(urlRegistros).then((response) => {
           console.log(response.data);
           commit('getDosimetriaOperador', response.data)  
           resolve()       
          })

          })
        },

        loadDosimetriaRx({
          commit},payload) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros ='dosimetria_rx/year/' + payload.year + '/month/' + payload.month + '?api_token=' + Laravel.user.api_token;   
           return new Promise((resolve, reject) => {             
           axios.get(urlRegistros).then((response) => {
           console.log(response.data);
           commit('getDosimetriaRx', response.data)  
           resolve()       
          })

          })
        },

        loadDosimetriaEstados({
          commit},payload) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros ='dosimetria_estados/year/' + payload.year + '/month/' + payload.month + '?api_token=' + Laravel.user.api_token;   
           return new Promise((resolve, reject) => {             
           axios.get(urlRegistros).then((response) => {
           console.log(response.data);
           commit('getDosimetriaEstados', response.data)  
           resolve()       
          })

          })
        },

        loadContarInformes({
          commit},ot_id) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros = 'informes/ot/' + ot_id +'/total' + '?api_token=' + Laravel.user.api_token;             
           axios.get(urlRegistros).then((response) => {
           commit('ContarInformes', response.data)           
          })
        },

        loadContarOperadores({
          commit},ot_id) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros = 'ot_operarios/users/' + ot_id +'/total' + '?api_token=' + Laravel.user.api_token;             
           axios.get(urlRegistros).then((response) => {
           commit('ContarOperadores', response.data)           
          })
        },

        loadContarSoldadores({
          commit},ot_id) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros = 'ot_soldadores/ot/' + ot_id + '/total' + '?api_token=' + Laravel.user.api_token;             
           axios.get(urlRegistros).then((response) => {
           commit('ContarSoldadores', response.data)           
          })
        },

        loadContarUsuariosCliente({
          commit},ot_id) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros = 'ot_usuarios_clientes/ot/' + ot_id +'/total' + '?api_token=' + Laravel.user.api_token;             
           axios.get(urlRegistros).then((response) => {
           commit('ContarUsuariosCliente', response.data)           
          })
        },

        loadContarProcedimientos({
          commit},ot_id) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros = 'ot_procedimientos_propios/ot/' + ot_id +'/total' + '?api_token=' + Laravel.user.api_token;             
           axios.get(urlRegistros).then((response) => {
           commit('ContarProcedimientos', response.data)           
          })
        },

        loadContarDocumentaciones({
          commit},ot_id) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros = 'ot-documentaciones/ot/' + ot_id +'/total' + '?api_token=' + Laravel.user.api_token;             
           axios.get(urlRegistros).then((response) => {
           commit('ContarDocumentaciones', response.data)           
          })
        },

        loadContarInternoEquipos({
          commit},ot_id) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros = 'interno_equipos/ot/' + ot_id +'/total' + '?api_token=' + Laravel.user.api_token;             
           axios.get(urlRegistros).then((response) => {
           commit('ContarInternoEquipos', response.data)           
          })
        },

        loadContarRemitos({
          commit},ot_id) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros = 'remitos/ot/' + ot_id +'/total' + '?api_token=' + Laravel.user.api_token;             
           axios.get(urlRegistros).then((response) => {
           commit('ContarRemitos', response.data)           
          })
        },

        loadDiasDelMes({
          commit},payload) {
            
            commit('DiasDelMes', payload)           
       
         },
        loadContarPartes({
          commit},ot_id) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros = 'partes/ot/' + ot_id +'/total' + '?api_token=' + Laravel.user.api_token;             
           axios.get(urlRegistros).then((response) => {
           commit('ContarPartes', response.data)           
          })
        },

        loadCurie({
          commit},payload ) {
           axios.defaults.baseURL = store.state.url ;
           console.log(payload);
           var urlRegistros = 'interno_fuentes/' + payload.interno_fuente_id + '/fecha_final/' + payload.fecha_final + '/curie' + '?api_token=' + Laravel.user.api_token;   
           console.log(urlRegistros);
           return new Promise((resolve, reject) => {          
           axios.get(urlRegistros).then((response) => {
           console.log(response.data);
           commit('CalcularCurie', response.data)           
           resolve()       
          })
        })
        },

        loadRoles({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'roles' + '?api_token=' + Laravel.user.api_token;  
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            commit('getRoles', response.data)           
          })
        },

        loadPermisos({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'permissions' + '?api_token=' + Laravel.user.api_token;  
          console.log(urlRegistros);
          axios.get(urlRegistros).then((response) => {
            commit('getPermisos', response.data)           
          })
        },

        

    },
    mutations: {

      getFechaActual(state, fecha) {
        state.fecha = fecha
      },

      getObraInforme(state, obra_informe) {
        state.obra_informe = obra_informe
      },

      getParametroGeneral(state, ParametroGeneral) {
        state.ParametroGeneral = ParametroGeneral
      },

      getContratistas(state, contratistas) {
        state.contratistas = contratistas
      },

      getProvincias(state, provincias) {
        state.provincias = provincias
      },

      getLocalidades(state, localidades) {
        state.localidades = localidades
      },

      getMateriales(state, materiales) {
        state.materiales = materiales
      },

      getDiametros(state, diametros) {
        state.diametros = diametros
      },

      getEspesores(state, espesores) {
        state.espesores = espesores
      },

      getProcedimientosOtMetodo(state, procedimientos) {
        state.procedimientos = procedimientos
      },

      getNormaEvaluaciones(state, norma_evaluaciones) {
        state.norma_evaluaciones = norma_evaluaciones
      },

      getNormaEnsayos(state, norma_ensayos) {
        state.norma_ensayos = norma_ensayos
      },

      getUnidadesMedidas(state, unidadesMedidas) {
        state.unidades_medidas = unidadesMedidas
      },

      getMetodosEnsayos(state, metodoEnsayos) {
        state.metodos_ensayos = metodoEnsayos
      },

      getInternoEquiposActivos(state, interno_equipos_activos) {
        state.interno_equipos_activos = interno_equipos_activos
      },

      getUbicacionInternoEquipo(state, interno_equipo_show) {
        state.interno_equipo_show = interno_equipo_show
      },      

      getInternoFuentesActivos(state, interno_fuentes_activos) {
        state.interno_fuentes_activos = interno_fuentes_activos
      },

      getFuentes(state, fuentes) {
        state.fuentes = fuentes
      },

      getEquipos(state, equipos) {
        state.equipos = equipos
      },

      getFuentePorInterno(state, fuentePorInterno) {
        state.fuentePorInterno = fuentePorInterno
      },

      getTipoLiquidos(state, tipo_liquidos) {       

        switch (tipo_liquidos.tipo) {

          case 'penetrante_tipo_liquido':

            state.penetrantes_tipo_liquido = tipo_liquidos.liquidos;
            break;

          case 'revelador_tipo_liquido':

            state.reveladores_tipo_liquido = tipo_liquidos.liquidos;
            break;
          
          case 'removedor_tipo_liquido':
            
            state.removedores_tipo_liquido = tipo_liquidos.liquidos;
            break;        
         
        }

       
      },

      getIluminaciones(state, iluminaciones) {
        state.iluminaciones = iluminaciones
      },

      getEjecutorEnsayo(state, ejecutor_ensayos) {
        state.ejecutor_ensayos = ejecutor_ensayos
      },

      getRoles(state, roles) {
        state.roles = roles
      },

      getPermisos(state, permisos) {
        state.permisos = permisos
      },

      ContarInformes(state, CantInformes) {
        state.CantInformes = CantInformes
      },

      getOperadores(state, operadores) {
        state.operadores = operadores
      },

      getOperadoresDosimetria(state, operadores_dosimetria) {
        state.operadores_dosimetria = operadores_dosimetria
      },
      ContarOperadores(state, CantOperadores) {
        state.CantOperadores = CantOperadores
      },

      ContarSoldadores(state, CantSoldadores) {
        state.CantSoldadores = CantSoldadores
      },

      ContarUsuariosCliente(state, CantUsuariosCliente) {
        state.CantUsuariosCliente = CantUsuariosCliente
      },

      ContarInternoEquipos(state, CantInternoEquipos) {
        state.CantInternoEquipos = CantInternoEquipos
      },

      ContarProcedimientos(state, CantProcedimientos) {
        state.CantProcedimientos = CantProcedimientos
      },

      ContarDocumentaciones(state, CantDocumentaciones) {
        state.CantDocumentaciones = CantDocumentaciones
      },

      ContarPartes(state, CantPartes) {
        state.CantPartes = CantPartes
      },

      ContarRemitos(state, CantRemitos) {
        state.CantRemitos = CantRemitos
      },

      CalcularCurie(state, curie) {
        state.curie = curie
      },

      getDDPPI(state, DDPPI) {
      
        state.DDPPI = DDPPI ? true : false ;  

      },

      DiasDelMes(state, payload) {

        state.DiasDelMes =  new Date(payload.year, payload.month, 0).getDate(); 

      },

      getDosimetriaOperador(state, dosimetria_operador){

        state.dosimetria_operador = dosimetria_operador;

      },

      getDosimetriaRx(state, dosimetria_rx){

        state.dosimetria_rx = dosimetria_rx;

      },

      getDosimetriaEstados(state, dosimetria_estados){

        state.dosimetria_estados = dosimetria_estados;

      },

      getDosimetriaResumen(state, dosimetria_resumen){

        state.dosimetria_resumen = dosimetria_resumen;

      },

    }

})

export const eventNewRegistro = new Vue();
export const eventSetReferencia = new Vue();
export const eventEditRegistro = new Vue();

import Permissions from './mixins/permissions';
Vue.mixin(Permissions);

const app = new Vue({
    el: '#app',   
    store,
    
    
});
