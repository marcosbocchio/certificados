
<template>
    <div class="row">
        <div class="col-md-3">
            <div class="box box-custom-enod">
                <div class="box-body box-profile">
                    <div v-if="cliente && cliente.path" style="text-align:center">
                        <img :src="'/' + cliente.path" alt="..." width="120">
                    </div>
                    <h4 v-if="cliente" class="profile-username text-center">
                        {{cliente.nombre_fantasia}}
                    </h4>

                    <p v-if="ot" class="text-muted text-center">
                        {{ot.proyecto}}
                    </p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item pointer">
                            <div v-show="!selCliente">
                                <span class="titulo-li">Cliente</span>
                                <a @click="selCliente = !selCliente" class="pull-right">
                                    <div v-if="cliente">{{cliente.nombre_fantasia}}</div>
                                    <div v-else><span class="seleccionar">Seleccionar</span></div>
                                </a>
                            </div>
                            <v-select v-show="selCliente" v-model="cliente" label="nombre_fantasia" :options="clientesOperador" @input="CambioCliente()" ></v-select>

                        </li>
                        <li class="list-group-item pointer">
                            <div v-show="!selOt">
                                <span class="titulo-li">OT</span>
                                <a @click="selOt = !selOt" class="pull-right">
                                    <div v-if="ot">{{ot.numero}}</div>
                                    <div v-else><span class="seleccionar">Seleccionar</span></div>
                                </a>
                            </div>
                            <v-select v-show="selOt" v-model="ot" label="numero" :options="ots" @input="CambioOt()" ></v-select>
                        </li>
                        <li class="list-group-item pointer">
                            <div v-show="!selObra">
                                <span class="titulo-li">Obra</span>
                                <a @click="seleccionarObra()" class="pull-right">
                                    <div v-if="obra || ot.obra">{{obra.obra}}</div>
                                    <div v-else><span class="seleccionar">Seleccionar</span></div>
                                </a>
                            </div>
                            <v-select v-show="selObra" v-model="obra" label="obra" :options="obras"></v-select>
                        </li>
                        <li class="list-fecha list-group-item pointer">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <date-picker v-model="fecha_desde" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="Desde" ></date-picker>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <date-picker v-model="fecha_hasta" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="Hasta" ></date-picker>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <a  @click="Buscar()">
                        <button class="btn btn-enod  btn-block"><span class="fa fa-plus-circle"></span>
                            Buscar
                        </button>
                    </a>

                </div>
            </div>
        </div>
        <div class="col-md-9">

            <tabs :options="{ useUrlFragment: false }">
                <tab name="Certificados">
                <div class="row">
                    <div class="col-lg-12">
                    <div v-if="(tablaCertificados.data && tablaCertificados.data.length)">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Detalle</h3>
                                </div>
                                <div class="box-body">
                                <div class="table-responsive">
                            <table class="table table-striped table-condensed">
                              <tbody>
                                  <tr>
                                      <th class="col-md-1">Fecha</th>
                                      <th  style="text-align:center" class="col-md-1">Certicado</th>
                                      <th style="text-align:center" class="col-md-2">Cliente</th>
                                      <th style="text-align:center" class="col-md-1">Obra</th>
                                      <th style="text-align:center" class="col-md-1">Ot</th>
                                      <th style="text-align:center" class="col-md-1">Fst</th>
                                      <th style="text-align:center" class="col-md-1">Facturado</th>
                                  </tr>
                                  <tr v-for="(item,k) in tablaCertificados.data" :key="k">
                                      <td> {{ item.fecha}}</td>
                                      <td style="text-align:center">
                                        <a :href="'/pdf/certificado/' + item.numero + '/original' " target="_blank" title="Informe"><span>{{ item.numero_formateado }}</span></a>
                                      </td>
                                      <td style="text-align:center"> {{ item.cliente}}</td>
                                      <td style="text-align:center"> {{ item.obra}}</td>
                                      <td style="text-align:center"> {{ item.ot}}</td>
                                      <td style="text-align:center"> {{ item.fst}}</td>
                                      <td style="text-align:center"> {{ item.facturado}}</td>
                                  </tr>
                              </tbody>
                            </table>
                          </div>
                                </div>
                            </div>
                        </div>

                    <div v-else>
                        <h4>No hay datos para mostrar</h4>
                    </div>
                    </div>
                </div>
                </tab>
            </tabs>
            <pagination :data="tablaCertificados" @pagination-change-page="Buscar"><span slot="prev-nav">&lt; Previous</span>
            <span slot="next-nav">Next &gt;</span> </pagination>
        </div>

         <loading
            :active.sync="isLoading"
            :loader="'bars'"
            :color="'red'">
         </loading>
    </div>
</template>

<script>
import moment from 'moment';
import Datepicker from 'vuejs-datepicker';
import {mapState} from 'vuex';
import {en, es} from 'vuejs-datepicker/dist/locale'
import Tabs from 'vue-tabs-component';
import Loading from 'vue-loading-overlay';
import ChartJsPluginDataLabels from 'chartjs-plugin-datalabels';
import DoughnutChart from '../chart.js/DoughnutChart.js'
import BarChart from '../chart.js/BarChart.js'
import PieChart from '../chart.js/PieChart.js'
import html2canvas from 'html2canvas-render-offscreen';
export default {

    components: {

      Datepicker,
      Loading,
      DoughnutChart,
      BarChart,
      PieChart,
      ChartJsPluginDataLabels
    },

    props: {

      user : {
        type : Object,
        required : true,
      },

    },

    data() { return {

        en: en,
        es: es,
        cliente:'',
        filtrado: false,
        ots:[],
        ot:'',
        obras:[],
        obra:'',
        fecha_desde:null,
        fecha_hasta:null,
        selCliente:false,
        selOt:false,
        selObra:false,
        selComponente:false,
        fecha_actual: moment(new Date()).format('DD-MM-YYYY'),

        /* Tabla PARTES */
        tablaPartes:{},

        /* Tabla CERTIFICADOS */
        tablaCertificados:{},

     }

    },

    mounted() {

        this.$store.dispatch('loadClientesOperador',this.user.id);

    },

    computed :{

        ...mapState(['isLoading','clientesOperador','url']),
        partes_filter : function(){
        return (this.filtrado === true) ? this.tablaPartes.data.filter(e => !e.certificado) : this.tablaPartes.data;
        },
        mostrar_tabla : function(){
            return (this.tablaCertificados.lenght) ? (this.tablaCertificados.data.lenght > 0 ? true : false) : false;
        },
    },

methods :{

    async CambioCliente (){

        this.selCliente = !this.selCliente;
        this.ot = '';
        this.selOt =false;
        this.obra = '';
        this.selObra =false;
        this.componente = '';
        this.selComponente = false;
        this.fecha_desde = null;
        this.fecha_hasta = null;
        if(this.cliente){

            this.$store.commit('loading', true);
            var urlRegistros = 'clientes/' + this.cliente.id + '/ots/' +'?api_token=' + Laravel.user.api_token;
            try {
                let res = await axios.get(urlRegistros);
                this.ots = res.data;
            }catch(error){

            }finally {this.$store.commit('loading', false);}

        }
    },

    async CambioOt (){

        this.selOt = !this.selOt;
        this.obra = '';
        this.selObra = false;
        this.componente = '';
        this.selComponente = false;
        this.$store.commit('loading', true);
        var urlRegistros = 'ots/' + this.ot.id + '/obras/' +'?api_token=' + Laravel.user.api_token;
        try {
            let res = await axios.get(urlRegistros);
            this.obras = res.data;
        }catch(error){

        }finally  {this.$store.commit('loading', false);}

        if(this.ot.obra){
            this.obra = { obra : this.ot.obra}
            this.selObra = !this.selObra
        }
    },

   async Buscar(page = 1) {
     this.$store.commit('loading', true);
     this.tablaCertificados = {};

        try {
            let url3 = 'reporte-certificados' + '/cliente/' + (this.cliente ? this.cliente.id : 'null')  + '/ot/' + (this.ot ? this.ot.id : 'null' )  + '/obra/' + (this.obra ? this.obra.obra.replace('/','--') : 'null' ) + '/fecha_desde/' + this.fecha_desde + '/fecha_hasta/' + this.fecha_hasta + '?page='+ page + '&api_token=' + Laravel.user.api_token;
            let res3 = await axios.get(url3);
            this.tablaCertificados = res3.data;

        }catch(error){

        }finally  {this.$store.commit('loading', false);}

   },

   async seleccionarObra(){

        if(this.ot && !this.ot.obra){
            this.selObra = !this.selObra;
        }

    },


}}

</script>
<style scoped>

 .checkbox-right {


    float: right ;
    margin-right: 15px;
  }
</style>
