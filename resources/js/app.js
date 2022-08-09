
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

//import "regenerator-runtime/runtime.js";

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

const toastrInfo = {
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

import JsonCSV from 'vue-json-csv'
Vue.component('downloadCsv', JsonCSV)

import JsonExcel from 'vue-json-excel'
Vue.component('downloadExcel', JsonExcel)

import VueClipboard from 'vue-clipboard2'
Vue.use(VueClipboard)
VueClipboard.config.autoSetContainer = true
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

Vue.component('loading-spin', require('./components/loading-spin.vue').default);
Vue.component('app-icon', require('./components/app-icon.vue').default);
Vue.component('subir-imagen', require('./components/subir-imagen.vue').default);
Vue.component('abm-maestro', require('./components/abm-maestro/abm-maestro.vue').default);

Vue.component('table-users', require('./components/abm-maestro/usuarios/table-users.vue').default);
Vue.component('nuevo-users', require('./components/abm-maestro/usuarios/nuevo-users.vue').default);
Vue.component('editar-users', require('./components/abm-maestro/usuarios/editar-users.vue').default);

Vue.component('firmas-formE', require('./components/abm-maestro/usuarios/firmasFormE.vue').default);
Vue.component('firmas-formN', require('./components/abm-maestro/usuarios/firmasFormN.vue').default);

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

Vue.component('table-campanas', require('./components/abm-maestro/campanas/table-campanas.vue').default);
Vue.component('editar-campanas', require('./components/abm-maestro/campanas/editar-campanas.vue').default);
Vue.component('nuevo-campanas', require('./components/abm-maestro/campanas/nuevo-campanas.vue').default);

Vue.component('table-bombas', require('./components/abm-maestro/bombas/table-bombas.vue').default);
Vue.component('editar-bombas', require('./components/abm-maestro/bombas/editar-bombas.vue').default);
Vue.component('nuevo-bombas', require('./components/abm-maestro/bombas/nuevo-bombas.vue').default);



Vue.component('table-interno_fuentes', require('./components/abm-maestro/interno-fuentes/table-interno_fuentes.vue').default);
Vue.component('editar-interno_fuentes', require('./components/abm-maestro/interno-fuentes/editar-interno_fuentes.vue').default);
Vue.component('nuevo-interno_fuentes', require('./components/abm-maestro/interno-fuentes/nuevo-interno_fuentes.vue').default);

Vue.component('table-tipos_equipamiento', require('./components/abm-maestro/tipo-equipamiento/table-tipos_equipamiento.vue').default);
Vue.component('editar-tipos_equipamiento', require('./components/abm-maestro/tipo-equipamiento/editar-tipos_equipamiento.vue').default);
Vue.component('nuevo-tipos_equipamiento', require('./components/abm-maestro/tipo-equipamiento/nuevo-tipos_equipamiento.vue').default);

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

Vue.component('plantas', require('./components/abm-maestro/plantas/plantas.vue').default);
Vue.component('table-plantas', require('./components/abm-maestro/plantas/table-plantas.vue').default);
Vue.component('nuevo-plantas', require('./components/abm-maestro/plantas/nuevo-plantas.vue').default);
Vue.component('editar-plantas', require('./components/abm-maestro/plantas/editar-plantas.vue').default);


Vue.component('table-materiales', require('./components/abm-maestro/materiales/table-materiales.vue').default);
Vue.component('nuevo-materiales', require('./components/abm-maestro/materiales/nuevo-materiales.vue').default);
Vue.component('editar-materiales', require('./components/abm-maestro/materiales/editar-materiales.vue').default);

Vue.component('table-modelos_3d', require('./components/abm-maestro/modelos-3d/table-modelos_3d.vue').default);
Vue.component('nuevo-modelos_3d', require('./components/abm-maestro/modelos-3d/nuevo-modelos_3d.vue').default);
Vue.component('editar-modelos_3d', require('./components/abm-maestro/modelos-3d/editar-modelos_3d.vue').default);

Vue.component('table-agente_acoplamientos', require('./components/abm-maestro/agente-acoplamientos/table-agente_acoplamientos.vue').default);
Vue.component('nuevo-agente_acoplamientos', require('./components/abm-maestro/agente-acoplamientos/nuevo-agente_acoplamientos.vue').default);
Vue.component('editar-agente_acoplamientos', require('./components/abm-maestro/agente-acoplamientos/editar-agente_acoplamientos.vue').default);

Vue.component('table-vehiculos', require('./components/abm-maestro/vehiculos/table-vehiculos.vue').default);
Vue.component('nuevo-vehiculos', require('./components/abm-maestro/vehiculos/nuevo-vehiculos.vue').default);
Vue.component('editar-vehiculos', require('./components/abm-maestro/vehiculos/editar-vehiculos.vue').default);


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
Vue.component('exportar-documentacion', require('./components/documentaciones/exportar-documentacion.vue').default);
Vue.component('modal-zip', require('./components/documentaciones/modal-zip.vue').default);

Vue.component('marcar-documentos', require('./components/documentaciones/marcar-documentos.vue').default);

Vue.component('abm-placas', require('./components/dashboard/placas/abm-placas.vue').default);


Vue.component('dashboard-enod', require('./components/dashboard/dashboard-enod').default);
Vue.component('cuadro-enod', require('./components/dashboard/cuadro-enod').default);
Vue.component('cuadro-largo-enod', require('./components/dashboard/cuadro-largo-enod').default);
Vue.component('back-dashboard', require('./components/dashboard/back-dashboard').default);

Vue.component('ot-operarios', require('./components/dashboard/operarios/ot-operarios').default);
Vue.component('ot-interno-equipos', require('./components/dashboard/interno-equipos/ot-interno-equipos').default);
Vue.component('ot-informes', require('./components/dashboard/informes/ot-informes').default);
Vue.component('informes-importables', require('./components/dashboard/informes/informes-importables').default);
Vue.component('remitos-table', require('./components/remitos/remitos-table').default);
Vue.component('ot-partes', require('./components/dashboard/partes/ot-partes').default);
Vue.component('ot-certificados', require('./components/dashboard/certificados/ot-certificados').default);

Vue.component('ot-soldadores', require('./components/dashboard/soldadores/ot-soldadores').default);
Vue.component('ot-documentaciones', require('./components/dashboard/documentaciones/ot-documentaciones').default);
Vue.component('table-ot_procedimientos_propios', require('./components/dashboard/procedimientos/table-ot_procedimientos_propios').default);
Vue.component('ot-tipoSoldaduras', require('./components/dashboard/procedimientos/ot-tipoSoldaduras').default);

Vue.component('informes-revisiones', require('./components/dashboard/informes/informes-revisiones.vue').default);

Vue.component('table-placas', require('./components/dashboard/placas/table-placas').default);

Vue.component('partes', require('./components/partes/partes.vue').default);
Vue.component('parte-header', require('./components/partes/parte-header.vue').default);

Vue.component('certificados', require('./components/certificados/certificados.vue').default);
Vue.component('certificado-header', require('./components/certificados/certificado-header.vue').default);

Vue.component('ots', require('./components/ots/ots.vue').default);
Vue.component('create-referencias', require('./components/ots/referencias/create.vue').default);

Vue.component('remitos', require('./components/remitos/remitos.vue').default);

/* Informes    */
Vue.component('informe-ri', require('./components/informes/informe-ri.vue').default);
Vue.component('informe-rd', require('./components/informes/informe-rd.vue').default);
Vue.component('informe-cv', require('./components/informes/informe-cv.vue').default);
Vue.component('informe-rg', require('./components/informes/informe-rg.vue').default);
Vue.component('informe-pmi', require('./components/informes/informe-pmi.vue').default);
Vue.component('informe-pm', require('./components/informes/informe-pm.vue').default);
Vue.component('informe-lp', require('./components/informes/informe-lp.vue').default);
Vue.component('informe-us', require('./components/informes/informe-us.vue').default);
Vue.component('informe-dz', require('./components/informes/informe-dz.vue').default);
Vue.component('informe-tt', require('./components/informes/informe-tt.vue').default);
Vue.component('informe-header', require('./components/informes/informe-header.vue').default);

/* Dosimetria */
Vue.component('dosimetria-operador', require('./components/dosimetria/dosimetria-operador.vue').default);
Vue.component('dosimetria-rx', require('./components/dosimetria/dosimetria-rx.vue').default);
Vue.component('dosimetria-estados', require('./components/dosimetria/dosimetria-estados.vue').default);
Vue.component('operador-periodo', require('./components/dosimetria/operador-periodo.vue').default);
Vue.component('dosimetria-resumen', require('./components/dosimetria/dosimetria-resumen.vue').default);
Vue.component('historial-operadores', require('./components/dosimetria/historial-operadores.vue').default);

/* Documementos escaneados*/
Vue.component('abm-documentos-escaneados', require('./components/dashboard/documentos-escaneados/abm-documentos-escaneados.vue').default);
Vue.component('table-documentos-escaneados', require('./components/dashboard/documentos-escaneados/table-documentos-escaneados.vue').default);
Vue.component('form-documentos-escaneados', require('./components/dashboard/documentos-escaneados/form-documentos-escaneados.vue').default);

/* Reportes */
Vue.component('estadisticas-soldaduras', require('./components/reportes/estadisticas-soldaduras.vue').default);
Vue.component('costuras', require('./components/reportes/costuras.vue').default);
Vue.component('placas', require('./components/reportes/placas.vue').default);
Vue.component('reporte-certificados', require('./components/reportes/reporte-certificados.vue').default);
Vue.component('reporte-partes', require('./components/reportes/reporte-partes.vue').default);
Vue.component('reporte-interno-equipos-ri', require('./components/reportes/reporte-interno-equipos-ri.vue').default);

/* Trazabilidad */
Vue.component('trazabilidad-fuente', require('./components/trazabilidad/trazabilidad-fuente.vue').default);

/*SECCION CATEGORIAS/VIDEOS  */
Vue.component('categoria-grupos', require('./components/multimedia/categoria-grupos.vue').default);
Vue.component('subcategoria', require('./components/multimedia/subcategoria.vue').default);
Vue.component('categoria-edit', require('./components/multimedia/categoria-edit.vue').default);
Vue.component('subcategoria-edit', require('./components/multimedia/subcategoria-edit.vue').default);
Vue.component('secciones-edit', require('./components/multimedia/secciones-edit.vue').default);
Vue.component('video-edit', require('./components/multimedia/video-edit.vue').default);

/* Modelos 3d*/
Vue.component('modelo3d-viewer', require('./components/modelos3d/modelo3d-viewer.vue').default);

/* Notificaciones  */
Vue.component('alarma-receptor', require('./components/notificaciones/alarma-receptor.vue').default);
Vue.component('alarmas', require('./components/notificaciones/alarmas.vue').default);
Vue.component('notificaciones', require('./components/notificaciones/notificaciones.vue').default);

/* modal confirmacion */

Vue.component('confirmar-modal', require('./components/confirmar-modal').default);


Vue.component('pdf-test', require('./components/pdf-test').default);

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

        url:'/api/',
        isLoading : false ,
        fecha :'',
        colores :[],
        operadores:[],
        obra_informe:'',
        planta_informe:'',
        operadores_empresa:[],
        clientesOperador:[],
        contratistas:[],
        provincias:[],
        localidades:[],
        ot_tipo_soldaduras:[],
        ot_obra_tipo_soldaduras:[],
        materiales:[],
        diametros:[],
        espesores:[],
        medidas_placa:[],
        procedimientos:[],
        unidades_medidas:[],
        metodos_ensayos:[],
        norma_evaluaciones:[],
        norma_ensayos:[],
        tipos_equipamiento:[],
        interno_equipo_show:{},
        interno_equipos:[],
        instrumentos_mediciones:[],
        palpadores : [],
        vehiculos:[],
        interno_fuentes:[],
        fuentes:[],
        equipos:[],
        fuentePorInterno:{},
        penetrantes_tipo_liquido:[],
        reveladores_tipo_liquido:[],
        removedores_tipo_liquido:[],
        particulas:[],
        roles:[],
        permisos:[],
        iluminaciones:[],
        ejecutor_ensayos:[],
        CantInformes:0,
        CantOperadores :0,
        CantRemitos:0,
        CantSoldadores:0,
        CantUsuarios:0,
        CantInternoEquipos:0,
        CantPartes:0,
        CantCertificados:0,
        CantSoldadores:0,
        CantDocumentacionesTotal:0,
        CantDocumentaciones:0,
        CantProcedimientos:0,
        CantUsuariosCliente:0,
        CantVehiculos:0,
        curie:'0',
        ParametroGeneral:{},
        DDPPI:false,
        DiasDelMes:'0',
        operadores_dosimetria:[],
        dosimetria_operador:[],
        dosimetria_operadores:[],
        dosimetria_rx:[],
        dosimetria_estados:[],
        dosimetria_resumen:[],
        serviciosOt  : [],
        epss:[],
        pqrs:[],
        modelos_3d:[],
        documentos:[],

    },

actions : {
        getDashboard({commit}) {
          window.location.href =  '/';
        },
        loadFechaActual({
          commit}) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'fecha_actual'  + '?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
          axios.get(urlRegistros).then((response) => {
          commit('getFechaActual', response.data)
          resolve()
             })

        })
        },

        loadColores({
          commit}) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'colores'  + '?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
          axios.get(urlRegistros).then((response) => {
          commit('getColores', response.data)
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
            commit('getObraInforme', response.data)
            resolve()
            })
          })
        },

        loadPlantaInformes({
            commit},payload) {
            axios.defaults.baseURL = store.state.url ;
            var urlRegistros = 'informes/' + payload.informe_id + '/importado_sn/' + (payload.importado_sn ? 1 : 0) + '/get_planta/' +'?api_token=' + Laravel.user.api_token;
            return new Promise((resolve, reject) => {
            axios.get(urlRegistros).then((response) => {
              commit('getPlantaInforme', response.data)
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

        /* si  el operador  no tiene cliente asignado traigo todos los clientes*/

        loadClientesOperador({
            commit},user_id) {
            axios.defaults.baseURL = store.state.url ;
            var urlRegistros = 'clientes/operador/' + user_id  +'?api_token=' + Laravel.user.api_token;
            return new Promise((resolve, reject) => {
            axios.get(urlRegistros).then((response) => {
              commit('getClientesOperador', response.data)
              resolve();
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
            commit('getLocalidades', response.data)
          })
        },

        loadOtTipoSoldaduras({
          commit},ot_id) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'ot_tipo_soldaduras/ot/' + ot_id + '?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
          axios.get(urlRegistros).then((response) => {
            commit('getOtTipoSoldaduras', response.data)
            resolve();
          })
          })
        },

        loadOtObraTipoSoldaduras({
          commit},payload) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'ot_tipo_soldaduras/ot/' + payload.ot_id +'/obra/' + payload.obra.replace('/','--') +'?api_token=' + Laravel.user.api_token;
          console.log('url de loadOtObraTipoSoldaduras :',urlRegistros);
          return new Promise((resolve, reject) => {
          axios.get(urlRegistros).then((response) => {
              console.log('entro en loadOtObraTipoSoldaduras')
            console.log(response.data);
            commit('getOtObraTipoSoldaduras', response.data)
            resolve();
          })
          })
        },

        loadOtEpss({
          commit},ot_id) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'ot_tipo_soldaduras/ot/' + ot_id + '/epss/' +'?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
          axios.get(urlRegistros).then((response) => {
            commit('getOtEpss', response.data)
            resolve();
          })
          })
        },

        loadOtPqrs({
          commit},ot_id) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'ot_tipo_soldaduras/ot/' + ot_id + /pqrs/ +'?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
          axios.get(urlRegistros).then((response) => {
            commit('getOtPqrs', response.data)
            resolve();
          })
          })
        },

        loadMateriales({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'materiales' + '?api_token=' + Laravel.user.api_token;
          axios.get(urlRegistros).then((response) => {
            commit('getMateriales', response.data)
          })
        },

        loadDiametros({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'diametros' + '?api_token=' + Laravel.user.api_token;
          axios.get(urlRegistros).then((response) => {
            commit('getDiametros', response.data)
          })
        },

        loadEspesores({
          commit},diametro_code) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'espesor/' + diametro_code + '?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
          axios.get(urlRegistros).then((response) => {
            commit('getEspesores', response.data)
            resolve();
          })
          })
        },

        loadMedidasPlaca({
            commit
          }) {
            axios.defaults.baseURL = store.state.url ;
            var urlRegistros = 'medidas/cm/' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then((response) => {
              commit('getMedidasPlaca', response.data)
            })
          },

        loadProcedimietosOtMetodo({
          commit},payload) {
          axios.defaults.baseURL = store.state.url
          var urlRegistros = 'procedimientos_informes/ot/' + payload.ot_id + '/metodo/' + payload.metodo + '?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
            axios.get(urlRegistros).then((response) => {
              commit('getProcedimientosOtMetodo', response.data);
              resolve();
            })
          })
        },

        loadNormaEvaluaciones({
          commit}) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'norma_evaluaciones' + '?api_token=' + Laravel.user.api_token;
          axios.get(urlRegistros).then((response) => {
            commit('getNormaEvaluaciones', response.data)
          })
        },

        loadNormaEnsayos({
          commit}) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'norma_ensayos' + '?api_token=' + Laravel.user.api_token;
          axios.get(urlRegistros).then((response) => {
            commit('getNormaEnsayos', response.data)
          })
        },

        loadUnidadesMedidas({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'unidades_medidas/' + '?api_token=' + Laravel.user.api_token;
          axios.get(urlRegistros).then((response) => {
            commit('getUnidadesMedidas', response.data)
          })
        },

        loadMetodosEnsayos({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'metodo_ensayos' + '?api_token=' + Laravel.user.api_token;
          axios.get(urlRegistros).then((response) => {
            commit('getMetodosEnsayos', response.data)
          })
        },

        loadTiposEquipamiento({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'tipos_equipamiento' + '?api_token=' + Laravel.user.api_token;
          axios.get(urlRegistros).then((response) => {
            commit('getTiposEquipamiento', response.data)
          })
        },        

        loadInternoEquipos({
          commit},payload) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'interno_equipos/metodo/' + payload.metodo + '/activo_sn/' + payload.activo_sn + '/tipo_penetrante/' + payload.tipo_penetrante + '?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
          axios.get(urlRegistros).then((response) => {
            commit('getInternoEquipos', response.data)
            resolve()
          })
          })
        },

        loadInstrumentosMediciones({
          commit},payload) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'interno_equipos/metodo/' + payload.metodo + '/activo_sn/' + payload.activo_sn + '/tipo_penetrante/' + payload.tipo_penetrante + '?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
          axios.get(urlRegistros).then((response) => {
            commit('getInstrumentosMediciones', response.data)
            resolve()
          })
          })
        },

        loadVehiculos({
          commit}) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'vehiculos' + '?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
          axios.get(urlRegistros).then((response) => {
            commit('getVehiculos', response.data)
            resolve()
          })
          })
        },

        loadVehiculosOt({
            commit},ot_id) {
            axios.defaults.baseURL = store.state.url ;
            var urlRegistros = 'vehiculos' + '/ot/' + ot_id + '?api_token=' + Laravel.user.api_token;
            return new Promise((resolve, reject) => {
            axios.get(urlRegistros).then((response) => {
              commit('getVehiculos', response.data)
              resolve()
            })
            })
          },

        loadPalpadores({
          commit}) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'palpadores' + '?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
          axios.get(urlRegistros).then((response) => {
            commit('getPalpadores', response.data)
            resolve()
          })
          })
        },

        loadParticulas({
          commit},metodo_trabajo_pm_id) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'particulas/metodo_trabajo_pm/' + metodo_trabajo_pm_id + '?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
          axios.get(urlRegistros).then((response) => {
            commit('getParticulas', response.data)
            resolve()
          })
          })
        },

        loadUbicacionInternoEquipo({
          commit},id) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'interno_equipos/' + id + '?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
              axios.get(urlRegistros).then((response) => {
                commit('getUbicacionInternoEquipo', response.data) ;
                resolve()
              })
            })
        },

        loadInternoFuentes({
          commit},activo_sn) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'interno_fuentes/activo_sn/' + activo_sn + '?api_token=' + Laravel.user.api_token;
          axios.get(urlRegistros).then((response) => {
            commit('getInternoFuentes', response.data)
          })
        },

        loadEquipos({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'equipos' + '?api_token=' + Laravel.user.api_token;
          axios.get(urlRegistros).then((response) => {
            commit('getEquipos', response.data)
          })
        },

        loadFuentes({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'fuentes' + '?api_token=' + Laravel.user.api_token;
          axios.get(urlRegistros).then((response) => {
            commit('getFuentes', response.data)
          })
        },

        loadFuentePorInterno({
          commit},interno_fuente_id) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'fuentes/interno_fuente/' + interno_fuente_id  + '?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
          axios.get(urlRegistros).then((response) => {
            commit('getFuentePorInterno', response.data)
            resolve()
          })
          })
        },

        loadTipoLiquidos({
          commit},payload) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'tipo_liquidos/penetrante_sn/' + payload.penetrante_sn + '/revelador_sn/'+ payload.revelador_sn + '/removedor_sn/' + payload.removedor_sn + '/metodo_trabajo_lp_id/' +  payload.metodo_trabajo_lp_id + '?api_token=' + Laravel.user.api_token;
          axios.get(urlRegistros).then((response) => {
           commit('getTipoLiquidos',{ 'liquidos' :response.data,'payload' : payload })
          })
        },

        loadIluminaciones({
          commit}) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'iluminaciones' + '?api_token=' + Laravel.user.api_token;
          return new Promise((resolve, reject) => {
          axios.get(urlRegistros).then((response) => {
            commit('getIluminaciones', response.data)
            resolve()
          })
          })
        },

        loadEjecutorEnsayo({
          commit},ot_id) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'ot-operarios/ot/' + ot_id + '?api_token=' + Laravel.user.api_token;
          axios.get(urlRegistros).then((response) => {
            commit('getEjecutorEnsayo', response.data)
          })
        },

        loadOperadores({
          commit}) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros ='ot-operarios/users' + '?api_token=' + Laravel.user.api_token;
           return new Promise((resolve, reject) => {
           axios.get(urlRegistros).then((response) => {
           commit('getOperadores', response.data)
           resolve()
          })
          })
        },

        loadOperadoresEmpresa({
            commit}) {
             axios.defaults.baseURL = store.state.url ;
             var urlRegistros ='users/empresa' + '?api_token=' + Laravel.user.api_token;
             axios.get(urlRegistros).then((response) => {
             commit('getOperadoresEmpresa', response.data)
            })
          },

        loadOperadoresDisometria({
          commit}) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros ='dosimetria_operador/operadores' + '?api_token=' + Laravel.user.api_token;
           axios.get(urlRegistros).then((response) => {
           commit('getOperadoresDosimetria', response.data)
          })
        },

        loadDosimetriaResumen({
          commit},payload) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros ='dosimetria_resumen/year/'+ payload.year + '/operadores/' + payload.operadores + '?api_token=' + Laravel.user.api_token;
           return new Promise((resolve, reject) => {
            axios.get(urlRegistros).then((response) => {
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
           commit('getDosimetriaOperador', response.data)
           resolve()
          })
          })
        },

        loadDosimetriaMensualOperadores({
            commit},payload) {
             axios.defaults.baseURL = store.state.url ;
             var urlRegistros ='dosimetria_operador/operadores/year/' + payload.year + '/month/' + payload.month + '/operadores_ids/null' + '?api_token=' + Laravel.user.api_token;
             return new Promise((resolve, reject) => {
             axios.get(urlRegistros).then((response) => {
             commit('getDosimetriaMensualOperadores', response.data)
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

        loadContarVehiculos({
          commit},ot_id) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros = 'vehiculos/ot/' + ot_id + '/total' +'?api_token=' + Laravel.user.api_token;
           axios.get(urlRegistros).then((response) => {
           commit('ContarVehiculos', response.data)
          })
        },

        loadContarDocumentacionesTotal({
          commit}) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros = 'documentaciones/total' + '?api_token=' + Laravel.user.api_token;
           axios.get(urlRegistros).then((response) => {
           commit('ContarDocumentacionesTotal', response.data)
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

        loadContarCertificados({
          commit},ot_id) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros = 'certificados/ot/' + ot_id +'/total' + '?api_token=' + Laravel.user.api_token;
           axios.get(urlRegistros).then((response) => {
           commit('ContarCertificados', response.data)
          })
        },

        loadServiciosOt({
          commit},ot_id) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros = 'ot_servicios/ot/' + ot_id + '?api_token=' + Laravel.user.api_token;
           axios.get(urlRegistros).then((response) => {
           commit('getServiciosOt', response.data)
          })
        },

        loadCurie({
          commit},payload ) {
           axios.defaults.baseURL = store.state.url ;
           var urlRegistros = 'interno_fuentes/' + payload.interno_fuente_id + '/fecha_final/' + payload.fecha_final + '/curie' + '?api_token=' + Laravel.user.api_token;
           return new Promise((resolve, reject) => {
           axios.get(urlRegistros).then((response) => {
           commit('CalcularCurie', response.data)
           resolve()
          })
        })
        },

        loadModelos3d({
            commit} ) {
             axios.defaults.baseURL = store.state.url ;
             var urlRegistros = 'modelos_3d/' + '?api_token=' + Laravel.user.api_token;
             return new Promise((resolve, reject) => {
             axios.get(urlRegistros).then((response) => {
             commit('getModelos3d', response.data)
             resolve()
            })
          })
          },

        loadRoles({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'roles' + '?api_token=' + Laravel.user.api_token;
          axios.get(urlRegistros).then((response) => {
            commit('getRoles', response.data)
          })
        },

        loadPermisos({
          commit
        }) {
          axios.defaults.baseURL = store.state.url ;
          var urlRegistros = 'permissions' + '?api_token=' + Laravel.user.api_token;
          axios.get(urlRegistros).then((response) => {
            commit('getPermisos', response.data)
          })
        },

    },
    mutations: {


      loading(state, estado) {
          state.isLoading = estado
      },

      getFechaActual(state, fecha) {
        state.fecha = fecha
      },

      getColores(state, colores) {
        state.colores = colores
      },

      getObraInforme(state, obra_informe) {
        state.obra_informe = obra_informe
      },

      getPlantaInforme(state, planta_informe) {
        state.planta_informe = planta_informe
      },

      getParametroGeneral(state, ParametroGeneral) {
        state.ParametroGeneral = ParametroGeneral
      },

      getClientesOperador(state, clientesOperador) {
        state.clientesOperador = clientesOperador
      },

      getContratistas(state, contratistas) {
        state.contratistas = contratistas
      },

      getTiposEquipamiento(state, tipos_equipamiento) {
        state.tipos_equipamiento = tipos_equipamiento 
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

      getOtTipoSoldaduras(state, ot_tipo_soldaduras) {
        state.ot_tipo_soldaduras = ot_tipo_soldaduras
      },

      getOtObraTipoSoldaduras(state, ot_obra_tipo_soldaduras) {
        state.ot_obra_tipo_soldaduras = ot_obra_tipo_soldaduras
      },

      getOtEpss(state, epss) {
        state.epss = epss
      },

      getOtPqrs(state, pqrs) {
        state.pqrs = pqrs
      },

      getDiametros(state, diametros) {
        state.diametros = diametros
      },

      getEspesores(state, espesores) {
        state.espesores = espesores
      },

      getMedidasPlaca(state, medidas_placa) {
        state.medidas_placa = medidas_placa
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

      getInternoEquipos(state, interno_equipos) {
        state.interno_equipos = interno_equipos
      },

      getInstrumentosMediciones(state, instrumentos_mediciones) {
        state.instrumentos_mediciones = instrumentos_mediciones
      },

      getVehiculos(state, vehiculos) {
        state.vehiculos = vehiculos
      },

      getPalpadores(state, palpadores) {
        state.palpadores = palpadores
      },

      getParticulas(state, particulas) {
        state.particulas = particulas
      },

      getUbicacionInternoEquipo(state, interno_equipo_show) {
        state.interno_equipo_show = interno_equipo_show
      },

      getInternoFuentes(state, interno_fuentes) {
        state.interno_fuentes = interno_fuentes
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

        if(tipo_liquidos.payload.penetrante_sn){

          state.penetrantes_tipo_liquido = tipo_liquidos.liquidos;

        }else if(tipo_liquidos.payload.revelador_sn){

          state.reveladores_tipo_liquido = tipo_liquidos.liquidos;

        }else if(tipo_liquidos.payload.removedor_sn){

          state.removedores_tipo_liquido = tipo_liquidos.liquidos;

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

      getOperadoresEmpresa(state, operadores_empresa) {
        state.operadores_empresa = operadores_empresa
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

      ContarVehiculos(state, CantVehiculos) {
        state.CantVehiculos = CantVehiculos
      },

      ContarDocumentacionesTotal(state, CantDocumentacionesTotal) {
        state.CantDocumentacionesTotal = CantDocumentacionesTotal
      },

      ContarDocumentaciones(state, CantDocumentaciones) {
        state.CantDocumentaciones = CantDocumentaciones
      },

      ContarPartes(state, CantPartes) {
        state.CantPartes = CantPartes
      },

      ContarCertificados(state, CantCertificados) {
        state.CantCertificados = CantCertificados
      },

      getServiciosOt(state, serviciosOt) {
        state.serviciosOt = serviciosOt
      },

      ContarSoldadoes(state, CantSoldadores) {
        state.CantSoldadores = CantSoldadores
      },

      ContarUsuarios(state, CantUsuarios) {
        state.CantUsuarios = CantUsuarios
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

      getDosimetriaMensualOperadores(state, dosimetria_operadores){

        state.dosimetria_operadores = dosimetria_operadores;

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

      getModelos3d(state, modelos_3d){

        state.modelos_3d = modelos_3d;

      },

    },
})

import Permissions from './mixins/permissions';
Vue.mixin(Permissions);

import Alertas from './mixins/alertas';
Vue.mixin(Alertas);

export const eventNewRegistro = new Vue();
export const eventSetReferencia = new Vue();
export const eventEditRegistro = new Vue();

const app = new Vue({
    el: '#app',
    store,

});
