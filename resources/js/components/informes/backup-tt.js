<template>
   <div class="row">
       <div class="col-md-12">
           <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
               <informe-header :otdata="otdata" :informe_id="dataForm.informe_id" :editmode="editmode" @set-obra="setObra($event)" @set-planta="setPlanta($event)"></informe-header>
                    <div class="box box-custom-enod">
                        <div class="box-body">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha">Fecha *</label>
                                    <div>
                                        <date-picker v-model="dataForm.fecha" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="DD-MM-YYYY" autocomplete="new-password" ></date-picker>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" >
                                    <label for="numero_inf">Informe N°</label>
                                    <input type="text"  v-model="numero_inf_code" class="form-control" id="numero_inf" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" >
                                    <label for="componente">Componente *</label>
                                    <input type="text" v-model="dataForm.componente" class="form-control" id="componente" maxlength="30">
                                </div>
                            </div>

                            <div class="col-md-3" >
                                <div class="form-group">
                                    <label for="material">Material *</label>
                                    <v-select v-model="dataForm.material" label="codigo" :options="materiales" id="material"></v-select>
                                </div>
                            </div>

                           <div class="clearfix"></div>

                            <div class="col-md-3" >
                                <div class="form-group">
                                <label for="material2">Material </label>
                                <input type="radio" id="caño" value="Caño" v-model="dataForm.material2_tipo" style="float:right">
                                <label for="caño" style="float:right;margin-right: 5px;margin-left:5px" title="Caño">Caño</label>
                                <input type="radio" id="accesorio" value="Accesorio" v-model="dataForm.material2_tipo" style="float:right">
                                <label for="accesorio" style="float:right;margin-right: 5px;margin-left:5px" title="Accesorio">Acces.</label>
                                    <v-select v-model="dataForm.material2" label="codigo" :options="materiales" id="material2"></v-select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="procRadio">Procedimiento TT *</label>
                                    <v-select v-model="dataForm.procedimiento" label="titulo" :options="procedimientos" id="procRadio" :appendToBody="'false'" :autoscroll="true"></v-select>
                                </div>
                            </div>

                         <div class="col-md-3">
                             <div class="form-group" >
                                 <label for="linea">Linea</label>
                                 <input type="text" v-model="dataForm.linea" class="form-control" id="linea" maxlength="30">
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group" >
                                 <label for="plano_isom">Plano / Isom *</label>
                                 <input type="text" v-model="dataForm.plano_isom" class="form-control" id="plano_isom" maxlength="30">
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group" >
                                 <label for="hoja">Hoja</label>
                                 <input type="text" v-model="dataForm.hoja" class="form-control" id="hoja" maxlength="10">
                             </div>
                         </div>

                        <div class="col-md-3">
                            <div class="form-group size-pqr-eps" >
                                <label for="procedimientos_soldadura">EPS / WPS</label>
                                <v-select v-model="dataForm.ot_tipo_soldadura" label="eps" :options="ot_obra_tipo_soldaduras" id="procedimientos_soldadura"></v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group size-pqr-eps">
                                <label for="pqr">PQR</label>
                                <v-select v-model="dataForm.ot_tipo_soldadura" label="pqr" :options="ot_obra_tipo_soldaduras" id="pqr"></v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Equipo *</label>
                                <v-select  v-model="dataForm.interno_equipo" :options="interno_equipos" label="nro_interno">
                                    <template slot="option" slot-scope="option">
                                        <span class="upSelect">{{ option.nro_interno }}</span> <br>
                                        <span class="downSelect"> {{ option.equipo.codigo }} </span>
                                    </template>
                                </v-select>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="temperatura_inicial">Temp. Inicial</label>
                                <input type="number" v-model="dataForm.temperatura_inicial" class="form-control" id="temperatura_inicial" step="0.1">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="temperatura_subida">Tempp9. Subida</label>
                                <input type="number" v-model="dataForm.temperatura_subida" class="form-control" id="temperatura_subida" step="0.1">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="temperatura_mantenimiento">Temp. Mantenimiento</label>
                                <input type="number" v-model="dataForm.temperatura_mantenimiento" class="form-control" id="temperatura_mantenimiento" step="0.1">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="temperatura_enfriamiento">Temp. Enfriado</label>
                                <input type="number" v-model="dataForm.temperatura_enfriamiento" class="form-control" id="temperatura_enfriamiento" step="0.1">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="temperatura_final">Temp.Final</label>
                                <input type="number" v-model="dataForm.temperatura_final" class="form-control" id="temperatura_final" step="0.1">
                            </div>
                        </div>

                         <div class="col-md-6">
                            <line-chart :chart-data="data_indicaciones_temperatura" :options="data_indicaciones_temperatura.options" ></line-chart>
                        </div>

                    </div>
                </div>
           </form>
            <loading
                :active.sync="isLoading"
                :loader="'bars'"
                :color="'red'">
            </loading>
       </div>
   </div>
</template>
<script>
import uniq from 'lodash/uniq';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';
import {mapState} from 'vuex';
import { eventSetReferencia } from '../event-bus';
import { toastrInfo,toastrDefault } from '../toastrConfig';
import moment from 'moment';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import LineChart from '../chart.js/LineChart.js'

export default {
    components: {
        Loading,
        LineChart,
    },
    props:{
        editmode : {
            type : Boolean,
            required : true,
        },
        otdata : {
            type : Object,
            required : true
        },
        metodo : {
          type : String,
          required :true
        },
    },
    data() { return {
        procedimiento: [],
        data_indicaciones_temperatura : { options : []},
        dataForm: {
            obra:'',
            planta:'',
            fecha:'',
            informe_id:0,
            numero_inf:'',
            componente:'',
            material:'',
            material2:'',
            material2_tipo:'Accesorio',
            linea:'',
            plano_isom:'',
            hojas:'',
            ot_tipo_soldadura:'',
            temperatura_inicial:'',
            temperatura_subida:'',
            temperatura_mantenimiento:'',
            temperatura_enfriamiento:'',
            temperatura_final:'',
        }

    }},
    created : async function() {
        this.$store.commit('loading', true);
        await this.$store.dispatch('loadMateriales');
        await this.$store.dispatch('loadProcedimietosOtMetodo',
            { 'ot_id' : this.otdata.id, 'metodo' : this.metodo }).then(() =>{
                    if(this.procedimientos.length == 0  ){
                        toastr.options = toastrInfo;
                        toastr.info('No existe ningún procedimiento para el método de ensayo seleccionado');
                        toastr.options = toastrDefault;
                    }
            });
        await this.$store.dispatch('loadInternoEquipos',{ 'metodo' : this.metodo, 'activo_sn' : 1, 'tipo_penetrante' : 'null' });
        this.$store.commit('loading', false);
    },
    mounted : function() {
        this.getNumeroInforme();
     },
    computed :{

        ...mapState(['isLoading','url','materiales','ot_obra_tipo_soldaduras','procedimientos','norma_evaluaciones','particulas','norma_ensayos','iluminaciones','ejecutor_ensayos','interno_equipos','instrumentos_mediciones','modelos_3d']),

        numero_inf_code : function()  {
            if(this.dataForm.numero_inf)
                return this.metodo + (this.dataForm.numero_inf <10? '00' : this.dataForm.numero_inf<100? '0' : '') + this.dataForm.numero_inf ;
        },

     },
    methods : {
        generarGrafico : function() {
            const labels = [0,100,200,300,400,500,600,700,800,900,1000]
            this.data_indicaciones_temperatura = {
                labels : labels,
                datasets : [
                    {
                        backgroundColor: ['#3C8DBC' ,'#00C0EF','#0073B7','#FFCC56','#FF9F40','#FE6383','#AAEB16','#636864','#4CC0C0'],
                        label: 'titulo grafico',
                        data:[100,200,300],
                    },
                ],
                options: {},

            }
        },

        setObra : function(value){
            this.dataForm.obra = value;
            this.dataForm.ot_tipo_soldadura='';
            if(this.dataForm.obra){
                this.$store.dispatch('loadOtObraTipoSoldaduras',{ 'ot_id' : this.otdata.id, 'obra' : this.dataForm.obra });
                }
        },

        setPlanta : function(value){
            this.dataForm.planta = value;
        },

        getNumeroInforme:function(){
             if(!this.editmode) {
                 axios.defaults.baseURL = this.url ;
                 var urlRegistros = 'informes/ot/' + this.otdata.id + '/metodo/' + this.metodo + '/generar-numero-informe'  + '?api_token=' + Laravel.user.api_token;
                 axios.get(urlRegistros).then(response =>{
                    this.dataForm.numero_inf = response.data
                 });
              }
         },

    }
}
</script>
 <style scoped>
 .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
      background-color: #eee;
 }
 .checkbox-inline {
     margin-left: 0px;
 }
 @media (max-width: 767px) {
     .table-responsive .dropdown-menu {
         position: static !important;
     }
 }
 @media (min-width: 768px) {
     .table-responsive {
         overflow: inherit;
     }
 }

 .tabla-detalle tr:nth-child(4n+1), .tabla-detalle tr:nth-child(4n+2) {
 background: #f2f2f2;
}

 </style>

<style>

    .v-select .vs__selected-options{
        flex-wrap: nowrap;
        white-space: nowrap;
        overflow: hidden;
    }

 </style>
