<template>
   <div class="row">
        <div class="col-md-12">
           <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
                <informe-header :otdata="otdata" :informe_id="informe_id" :editmode="editmode" @set-obra="setObra($event)" @set-planta="setPlanta($event)"></informe-header>
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
                                    <input type="text" v-model="numero_inf_code" class="form-control" id="numero_inf" disabled>
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
                                    <v-select v-model="dataForm.procedimiento" label="titulo" :options="procedimientos" id="procRadio" :appendToBody="false" :autoscroll="true"></v-select>
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
                                <input type="number" v-model="dataForm.temperatura_inicial" @input="generarGrafico" class="form-control" id="temperatura_inicial" step="0.1">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="temperatura_subida">Temp. Subida</label>
                                <input type="number" v-model="dataForm.temperatura_subida" @input="generarGrafico" class="form-control" id="temperatura_subida" step="0.1">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="temperatura_mantenimiento">Temp. Mantenimiento</label>
                                <input type="number" v-model="dataForm.temperatura_mantenimiento" @input="generarGrafico" class="form-control" id="temperatura_mantenimiento" step="0.1">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="temperatura_enfriado">Temp. Enfriado</label>
                                <input type="number" v-model="dataForm.temperatura_enfriado" @input="generarGrafico" class="form-control" id="temperatura_enfriado" step="0.1">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="temperatura_final">Temp. Final</label>
                                <input type="number" v-model="dataForm.temperatura_final" @input="generarGrafico"  class="form-control" id="temperatura_final" step="0.1">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Norma Evaluación *</label>
                                <v-select v-model="dataForm.norma_evaluacion" label="codigo" :options="norma_evaluaciones">
                                    <template slot="option" slot-scope="option">
                                        <span class="upSelect">{{ option.codigo }}</span> <br>
                                        <span class="downSelect"> {{ option.descripcion }} </span>
                                    </template>
                                </v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Norma Ensayo *</label>
                                <v-select v-model="dataForm.norma_ensayo" label="codigo" :options="norma_ensayos">
                                    <template slot="option" slot-scope="option">
                                        <span class="upSelect">{{ option.codigo }}</span> <br>
                                        <span class="downSelect"> {{ option.descripcion }} </span>
                                    </template>
                                </v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="ejecutor_ensayo">Ejecutor Ensayo *</label>
                                <v-select v-model="dataForm.ejecutor_ensayo" label="name" :options="ejecutor_ensayos"></v-select>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="ejecutor_ensayo">Solicitante </label>
                                <v-select v-model="dataForm.solicitado_por" label="name" :options="usuarios_cliente"></v-select>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                         <div class="col-md-4 col-md-offset-4">
                            <line-chart :chart-data="data_indicaciones_temperatura" :options="data_indicaciones_temperatura.options" :chart-id="'img_temp'"></line-chart>
                        </div>

                    </div>


                <div class="box box-custom-enod">
                    <div class="box-body">

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="elemento">ELEMENTO</label>
                                <input type="text" v-model="elemento" class="form-control" id="elemento"  maxlength="30">
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="Termocupla">Termocupla Nº</label>
                                <input type="number" v-model="termocupla" class="form-control" id="Termocupla">
                            </div>
                        </div>

                       <div class="clearfix"></div>

                        <div class="col-md-1">
                            <span>
                              <button type="button" @click="addDetalle()"><span class="fa fa-plus-circle"></span></button>
                            </span>
                        </div>

                         <div class="form-group">
                            &nbsp;
                        </div>

                        <div v-if="dataForm.detalle.length">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th class="col-md-4">Elemento</th>
                                                <th class="col-md-4">Termocupla</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in (dataForm.detalle)" :key="k" @click="selectPosDetalle(k)" :class="{selected: indexPosDetalle === k}" >
                                                <td>{{ item.elemento }}</td>
                                                <td>{{ item.termocupla }}</td>
                                                <td style="text-align:center"><span class="fa fa-minus-circle" @click="removeDetalle(k)"></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                       </div>

                  </div>
                </div>

                    <div class="box box-custom-enod">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <textarea v-model="dataForm.observaciones" class="form-control noresize" rows="3" placeholder="" maxlength="250"></textarea>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit" :disabled="isLoading">Guardar</button>

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
import ChartJsPluginDataLabels from 'chartjs-plugin-datalabels';
import html2canvas from 'html2canvas-render-offscreen';
import {sprintf} from '../../functions/sprintf.js'

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
        informe_id : {
           type : Number,
           required : false,
        }
    },
    data() { return {
        procedimiento: [],
        data_indicaciones_temperatura : { options : []},
        elemento:'',
        termocupla:'',
        indexPosDetalle:0,
        usuarios_cliente:[],
        dataForm: {
            ot: this.otdata,
            metodo_ensayo: this.metodo,
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
            hoja:'',
            ot_tipo_soldadura:'',
            norma_evaluacion:'',
            norma_ensayo:'',
            ejecutor_ensayo:'',
            solicitado_por:'',
            temperatura_inicial:'',
            temperatura_subida:'',
            temperatura_mantenimiento:'',
            temperatura_enfriado:'',
            temperatura_final:'',
            imgData:'',
            detalle: [],
            observaciones:'',
            TablaModelos3d : [],
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
        await this.$store.dispatch('loadNormaEvaluaciones');
        await this.$store.dispatch('loadNormaEnsayos');
        await this.$store.dispatch('loadEjecutorEnsayo', this.otdata.id);
        await this.getUsuariosCliente();
        await this.setEdit();
        this.$store.commit('loading', false);
    },
    mounted : function() {
        this.getNumeroInforme();
        this.generarGrafico();
     },
    computed :{

        ...mapState(['isLoading','url','materiales','ot_obra_tipo_soldaduras','procedimientos','norma_evaluaciones','particulas','norma_ensayos','iluminaciones','ejecutor_ensayos','interno_equipos','instrumentos_mediciones','modelos_3d']),

        numero_inf_code : function()  {
            if(this.dataForm.numero_inf)
                return this.metodo +  sprintf("%04d",this.dataForm.numero_inf);
            },

        existenTemperaturas : function() {

           return (this.dataForm.temperatura_inicial && this.dataForm.temperatura_subida && this.dataForm.temperatura_mantenimiento && this.dataForm.temperatura_enfriado && this.dataForm.temperatura_final)
        }

     },
    methods : {
        setEdit: function() {
           if(this.editmode){
                let data = {};
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'informes/metodo/' + this.metodo + '/id/' + this.informe_id + '/data/' + '?api_token=' + Laravel.user.api_token;
                axios.get(urlRegistros).then(response =>{
                    console.log(response.data)
                    data = response.data
                    this.dataForm.informe_id = this.informe_id
                    this.dataForm.ot = this.otdata
                    this.dataForm.obra = data.obra
                    this.dataForm.planta = data.planta
                    this.dataForm.fecha = data.fecha
                    this.dataForm.componente = data.componente
                    this.dataForm.metodo_ensayo = this.metodo
                    this.dataForm.numero_inf = data.numero
                    this.dataForm.material = data.material
                    this.dataForm.material2 = data.material2
                    this.dataForm.material2_tipo = data.material2_tipo
                    if(data.material2_tipo) { this.dataForm.material2_tipo = data.material2_tipo }
                    this.dataForm.linea = data.linea
                    this.dataForm.plano_isom = data.plano_isom
                    this.dataForm.hoja = data.hoja
                    this.dataForm.ot_tipo_soldadura = data.ot_tipo_soldadura
                    this.dataForm.procedimiento = data.procedimiento
                    this.dataForm.interno_equipo = data.interno_equipo
                    this.dataForm.norma_evaluacion = data.norma_evaluacion
                    this.dataForm.norma_ensayo = data.norma_ensayo
                    this.dataForm.ejecutor_ensayo = data.ejecutor_ensayo
                    this.dataForm.solicitado_por = data.solicitado_por
                    this.dataForm.temperatura_inicial  = data.informe_tt.temperatura_inicial,
                    this.dataForm.temperatura_subida = data.informe_tt.temperatura_subida
                    this.dataForm.temperatura_mantenimiento = data.informe_tt.temperatura_mantenimiento
                    this.dataForm.temperatura_enfriado =  data.informe_tt.temperatura_enfriado
                    this.dataForm.temperatura_final = data.informe_tt.temperatura_final
                    this.dataForm.detalle = data.informe_tt.detalle
                    this.generarGrafico();
                })
           }
        },
        generarGrafico : function() {
            if (!this.existenTemperaturas)
                return
            var PrimerPunto = 0;
            var SegundoPunto = (parseFloat(this.dataForm.temperatura_mantenimiento) - parseFloat(this.dataForm.temperatura_inicial)) / parseFloat(this.dataForm.temperatura_subida)
            var TercerPunto =  SegundoPunto + 1;
            var CuartosPunto = (parseFloat(this.dataForm.temperatura_mantenimiento) - parseFloat(this.dataForm.temperatura_final)) / parseFloat(this.dataForm.temperatura_enfriado)
            var data = []
            data.push({x:PrimerPunto.toFixed(2),y:parseFloat(this.dataForm.temperatura_inicial)})
            data.push({x:SegundoPunto.toFixed(2), y:parseFloat(this.dataForm.temperatura_mantenimiento)})
            data.push({x:TercerPunto.toFixed(2), y:parseFloat(this.dataForm.temperatura_mantenimiento)})
            data.push({x:(TercerPunto + CuartosPunto).toFixed(2),y:parseFloat(this.dataForm.temperatura_final)})

            this.data_indicaciones_temperatura = {
                datasets: [{
                    label: 'Tratamiento termico',
                    pointStyle: 'circle',
                    data: data,
                    borderColor: 'rgb(75, 192, 192)',
                    lineTension: 0,
                }],
                options: {
                    legend: {
                            display: false
                        },
                    scales: {
                        yAxes: [{
                            ticks: {
                            suggestedMax: parseFloat(this.dataForm.temperatura_mantenimiento) + 100,
                            suggestedMin: 0,
                            }
                        }],
                        xAxes: [{
                            type: 'linear',
                            ticks: {
                            suggestedMax: TercerPunto + CuartosPunto + 0.5,
                            suggestedMin: 0,
                            }

                        }]
                    },
                    plugins: {
                        datalabels: {
                            color: '#FFFFFF',
                            formatter: function (item, index) {
                                return  ('P' + (parseInt(index.dataIndex ) + 1) + ': ' + 'x=' + item.x + ', y=' + item.y);
                            }.bind(this),
                            display: true,
                            color: '#000000',
                            align: function(index) {
                                let position
                                if (index.dataIndex == 0)
                                   return 'right'
                                if(index.dataIndex == 3)
                                    return 'left'
                                return 'top'

                            }.bind(this),
                            font: {
                                weight: 'normal',
                                size: 12,
                            }
                        }
                    }
                }
            };

            setTimeout(() => {
                var newCanvas = document.getElementById('img_temp');
                this.dataForm.imgData = newCanvas.toDataURL('image/png',1.0);

            }, 1000);

        },
        getUsuariosCliente : async function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'users/ot_id/' + this.otdata.id + '?api_token=' + Laravel.user.api_token;
            await axios.get(urlRegistros).then(response =>{
               this.usuarios_cliente = response.data
            });

        },
        setObra : function(value){
            this.dataForm.obra = value;
            this.dataForm.ot_tipo_soldadura = '';
            if(this.dataForm.obra) {
                this.$store.dispatch('loadOtObraTipoSoldaduras',{ 'ot_id' : this.otdata.id, 'obra' : this.dataForm.obra });
                }
        },

        setPlanta : function(value){
            this.dataForm.planta = value;
        },

        getNumeroInforme:function(){
            console.log('entro en generar numero informe')
             if(!this.editmode) {
                 axios.defaults.baseURL = this.url ;
                 var urlRegistros = 'informes/ot/' + this.otdata.id + '/metodo/' + this.metodo + '/tecnica/0' + '/generar-numero-informe/'  + '?api_token=' + Laravel.user.api_token;
                 axios.get(urlRegistros).then(response =>{
                    this.dataForm.numero_inf = response.data
                    console.log('numero_inf: ',this.dataForm.numero_inf)
                 });
              }
         },

          addDetalle : function () {

            if (!this.elemento){
                toastr.error('El campo elemento es obligatorio');
                return ;
            }

            if (!this.termocupla){
                toastr.error('El campo termocupla es obligatorio');
                return ;
            }

            this.dataForm.detalle.push({
                elemento : this.elemento,
                termocupla:     this.termocupla,
            });
            this.elemento = '',
            this.termocupla = '';

        },

         removeDetalle(index) {
            this.indexPosDetalle = 0;
            this.dataForm.detalle.splice(index, 1);
        },

        Store : function () {

            var errors = [];
            this.$store.commit('loading', true);
            var urlRegistros = 'informes_tt' ;
            axios({
              method: 'post',
              url : urlRegistros,
              data : {
                ...this.dataForm
            }

          }).then(response => {

            let informe = response.data;
            toastr.success('informe N°' + this.numero_inf + ' fue creado con éxito ');
            window.open('/pdf/informe/tt/' + informe.id,'_blank');
            window.location.href =  '/informes/ot/' + this.otdata.id;

            }).catch(error => {
                errors = error.response.data.errors;
                console.log(error.response);
                $.each( errors, function( key, value ) {
                    toastr.error(value);
                    console.log( key + ": " + value );
                });

                if((typeof(errors)=='undefined') && (error)){
                    toastr.error("Ocurrió un error al procesar la solicitud");
                }

                }).finally( () => this.$store.commit('loading', false))
        },

        Update : function() {

            this.errors =[];

            this.$store.commit('loading', true);
            var urlRegistros = 'informes_tt/' + this.informe_id;
            axios({
              method: 'put',
              url : urlRegistros,
              data : {
                ...this.dataForm
              }
            }).then(response => {

            let informe = response.data;
            toastr.success('informe N°' + this.numero_inf + ' fue actualizado con éxito ');
            window.open('/pdf/informe/tt/' + informe.id,'_blank');
            window.location.href =  '/informes/ot/' + this.otdata.id;

            }).catch(error => {

                this.errors = error.response.data.errors;
                    console.log(error.response);
                $.each( this.errors, function( key, value ) {
                    toastr.error(value);
                    console.log( key + ": " + value );
                });

                if((typeof(this.errors)=='undefined') && (error)){
                    toastr.error("Ocurrió un error al procesar la solicitud");
                }
                }).finally( () => this.$store.commit('loading', false))
            }
    },
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
