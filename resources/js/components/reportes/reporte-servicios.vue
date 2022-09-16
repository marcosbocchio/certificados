
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
                <tab name="Servicios">
                <div class="row">
                    <div class="col-lg-12">
                    <div v-if="1">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Detalle</h3>
                                </div>
                                <div class="box-body">
                                <div class="table-responsive">
                            <table class="table table-striped table-condensed">
                              <tbody>
                                  <!-- <tr>
                                      <th class="col-md-1">Fecha</th>
                                      <th style="text-align:center" class="col-md-2">Cliente</th>
                                      <th style="text-align:center" class="col-md-1">Ot</th>
                                      <th style="text-align:center" class="col-md-1">Certicado</th>
                                      <th style="text-align:center" class="col-md-1">RI</th>
                                      <th style="text-align:center" class="col-md-1">LP</th>
                                      <th style="text-align:center" class="col-md-1">PM</th>
                                      <th style="text-align:center" class="col-md-1">US</th>
                                      <th style="text-align:center" class="col-md-1">EA</th>
                                      <th style="text-align:center" class="col-md-1">PMI</th>
                                      <th style="text-align:center" class="col-md-1">RG</th>
                                      <th style="text-align:center" class="col-md-1">CV</th>
                                      <th style="text-align:center" class="col-md-1">DZ</th>
                                      <th style="text-align:center" class="col-md-1">TT</th>
                                      <th style="text-align:center" class="col-md-1">RD</th>
                                      <th style="text-align:center" class="col-md-1">CI</th>
                                      <th style="text-align:center" class="col-md-1">IV</th>
                                      <th style="text-align:center" class="col-md-1">PH</th>
                                      <th style="text-align:center" class="col-md-1">GRAL</th>
                                      <th style="text-align:center" class="col-md-1">RM</th>
                                      <th style="text-align:center" class="col-md-1">VS</th>
                                      <th style="text-align:center" class="col-md-1">OG</th>
                                  </tr> -->
                                    <tr>
                                      <th class="col-md-1 col-sm-1 col-lg-2">Fecha</th>
                                      <th style="text-align:center" class="col-md-9 col-sm-9 col-lg-6">Cliente</th>
                                      <th style="text-align:center" class="col-md-1 col-sm-1 col-lg-2">Ot</th>
                                      <th style="text-align:center" class="col-md-1 col-sm-1 col-lg-2">Certicado</th>
                                      <th style="text-align:center" class="pepe">RI</th>
                                      <th style="text-align:center" class="pepe">LP</th>
                                      <th style="text-align:center" class="pepe">PM</th>
                                      <th style="text-align:center" class="pepe">US</th>
                                      <th style="text-align:center" class="pepe">PA</th>
                                      <th style="text-align:center" class="pepe">ME</th>
                                      <th style="text-align:center" class="pepe">EA</th>
                                      <th style="text-align:center" class="pepe">PMI</th>
                                      <th style="text-align:center" class="pepe">RG</th>
                                      <th style="text-align:center" class="pepe">CV</th>
                                      <th style="text-align:center" class="pepe">DZ</th>
                                      <th style="text-align:center" class="pepe">TT</th>
                                      <th style="text-align:center" class="pepe">RD</th>
                                      <th style="text-align:center" class="pepe">CI</th>
                                      <th style="text-align:center" class="pepe">IV</th>
                                      <th style="text-align:center" class="pepe">PH</th>
                                      <th style="text-align:center" class="pepe">GRAL</th>
                                      <th style="text-align:center" class="pepe">RM</th>
                                      <th style="text-align:center" class="pepe">VS</th>
                                      <th style="text-align:center" class="pepe">OG</th>
                                  </tr>
                                  <tr v-for="(item,k) in tablaCertificados" :key="k">
                                      <td> {{ item.fecha}}</td>
                                      <td style="text-align:center"> {{ item.cliente}}</td>
                                      <td style="text-align:center"> {{ item.ot}}</td>
                                      <td style="text-align:center"> {{ item.certificado}}</td>
                                      <td style="text-align:center"> {{ item.ri}}</td>
                                      <td style="text-align:center"> {{ item.lp}}</td>
                                      <td style="text-align:center"> {{ item.pm}}</td>
                                      <td style="text-align:center"> {{ item.us}}</td>
                                      <td style="text-align:center"> {{ item.pa}}</td>
                                      <td style="text-align:center"> {{ item.me}}</td>
                                      <td style="text-align:center"> {{ item.ea}}</td>
                                      <td style="text-align:center"> {{ item.pmi}}</td>
                                      <td style="text-align:center"> {{ item.rg}}</td>
                                      <td style="text-align:center"> {{ item.cv}}</td>
                                      <td style="text-align:center"> {{ item.dz}}</td>
                                      <td style="text-align:center"> {{ item.tt}}</td>
                                      <td style="text-align:center"> {{ item.rd}}</td>
                                      <td style="text-align:center"> {{ item.ci}}</td>
                                      <td style="text-align:center"> {{ item.iv}}</td>
                                      <td style="text-align:center"> {{ item.ph}}</td>
                                      <td style="text-align:center"> {{ item.gral}}</td>
                                      <td style="text-align:center"> {{ item.rm}}</td>
                                      <td style="text-align:center"> {{ item.vs}}</td>
                                      <td style="text-align:center"> {{ item.og}}</td>
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
        tablaCertificados:[
            {fecha: '1/1/2023',cliente:'ELECTROMONTAJES BADIA S.R.L',ot:'2933',certificado:'142875',ri:'0',lp:'12',pm:'23',us:'42',pa:'0',me:'32',ea:'0',pmi:'12',rg:'90',cv:'21',dz:'22',tt:'21',rd:'1',ci:'0',iv:'23',ph:'1',gral:'2',rm:'0',vs:'2',og:'9'}
        ],

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

   async seleccionarObra() {
        if(this.ot && !this.ot.obra){
            this.selObra = !this.selObra;
        }
    },

    async CambioObra (){

        this.obra = this.obra == null ? '' : this.obra;
        this.selObra = !this.selObra;

    },


}}

</script>
<style scoped>

 .checkbox-right {


    float: right ;
    margin-right: 15px;
  }
   .pepe {

    margin-left: 5px;
    margin-right: 5px;
  }
</style>
