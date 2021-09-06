
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
                            <v-select v-show="selObra" v-model="obra" label="obra" :options="obras" @input="CambioObra()"></v-select>
                        </li>
                        <li class="list-group-item pointer">
                            <div v-show="!selComponente">
                                <span class="titulo-li">Componente</span>
                                <a @click="CambioComponente()" class="pull-right">
                                    <div v-if="componente">{{componente.componente}}</div>
                                    <div v-else><span class="seleccionar">Seleccionar</span></div>
                                </a>
                            </div>
                            <v-select v-show="selComponente" v-model="componente" label="componente" :options="componentes" @input="CambioComponente()"></v-select>
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
                <tab name="Placas Repetidas/Testigos">
                    <div v-if="total_placas_informes">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="div-grafico">
                                    <pie-chart  :chart-data="data_placas_repetidas" :options="data_placas_repetidas.options" ></pie-chart>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="div-grafico">
                                    <pie-chart  :chart-data="data_placas_testigos" :options="data_placas_testigos.options" ></pie-chart>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="div-grafico">
                                    <pie-chart  :chart-data="data_placas_rechazadas" :options="data_placas_rechazadas.options" ></pie-chart>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <h4>No hay datos para mostrar</h4>
                    </div>
                </tab>
            </tabs>
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
        ots:[],
        ot:'',
        obras:[],
        obra:'',
        componentes: [],
        componente:'',
        fecha_desde:null,
        fecha_hasta:null,
        selCliente:false,
        selOt:false,
        selObra:false,
        selComponente:false,
        fecha_actual: moment(new Date()).format('DD-MM-YYYY'),

        total_placas_informes : 0,
        total_placas_con_repetidas: 0,
        total_placas_con_testigos: 0,
        total_placas_testigos:0,
        total_placas_repetidas :0,
        total_placas_aprobadas:0,
        total_placas_rechazadas:0,
        total_placas_con_rechazadas:0,

       /* placas repetidas */
        data_placas_repetidas : { options : []},
        valores_placas_repetidas :[],

        /* Placas testigos */
        data_placas_testigos : { options : []},
        valores_placas_testigos:[],

        /* Placas Rechazadas*/
        data_placas_rechazadas : { options : []},
        valores_placas_rechazadas:[],
     }

    },

    mounted() {

        this.$store.dispatch('loadClientesOperador',this.user.id);

    },

    computed :{

        ...mapState(['isLoading','clientesOperador','url']),

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
            this.CambioObra()
        }
    },

    async Buscar() {
     this.$store.commit('loading', true);


     this.total_placas = 0;

        try {
            let url = 'reporte-placas' + '/cliente/' + (this.cliente ? this.cliente.id : 'null')  + '/ot/' + (this.ot ? this.ot.id : 'null' )  + '/obra/' + (this.obra ? this.obra.obra : 'null' ) + '/fecha_desde/' + this.fecha_desde + '/fecha_hasta/' + this.fecha_hasta   + '/total/' +'?api_token=' + Laravel.user.api_token;
            let url2 = 'reporte-placas' + '/cliente/' + (this.cliente ? this.cliente.id : 'null')  + '/ot/' + (this.ot ? this.ot.id : 'null' )  + '/obra/' + (this.obra ? this.obra.obra : 'null' ) + '/fecha_desde/' + this.fecha_desde + '/fecha_hasta/' + this.fecha_hasta  + '/repetidas-testigos/' +'?api_token=' + Laravel.user.api_token;
            let url3 = 'reporte-placas' + '/cliente/' + (this.cliente ? this.cliente.id : 'null')  + '/ot/' + (this.ot ? this.ot.id : 'null' )  + '/obra/' + (this.obra ? this.obra.obra : 'null' ) + '/fecha_desde/' + this.fecha_desde + '/fecha_hasta/' + this.fecha_hasta  + '/rechazadas/' +'?api_token=' + Laravel.user.api_token;

            let res = await axios.get(url);
            let res2 = await axios.get(url2);
            let res3 = await axios.get(url3);
            this.total_placas_informes = res.data;
            this.total_placas_repetidas = parseInt(res2.data[0].placas_repetidas);
            this.total_placas_testigos =  parseInt(res2.data[0].placas_testigos);
            this.total_placas_aprobadas = parseInt(res3.data[0].placas_aprobadas);
            this.total_placas_rechazadas = parseInt(res3.data[0].placas_rechazadas);

            this.total_placas_con_repetidas = parseInt(this.total_placas_informes) + parseInt(this.total_placas_repetidas);
            this.total_placas_con_testigos = parseInt(this.total_placas_informes) + parseInt(this.total_placas_testigos);
            this.total_placas_con_rechazadas = this.total_placas_aprobadas + this.total_placas_rechazadas;

            this.valores_placas_repetidas = [];
            this.valores_placas_repetidas.push(parseInt(this.total_placas_informes));
            this.valores_placas_repetidas.push(parseInt(this.total_placas_repetidas));
            this.valores_placas_testigos = [];
            this.valores_placas_testigos.push(parseInt(this.total_placas_informes));
            this.valores_placas_testigos.push(parseInt(this.total_placas_testigos));
            this.valores_placas_rechazadas = [];
            this.valores_placas_rechazadas.push(parseInt(this.total_placas_aprobadas));
            this.valores_placas_rechazadas.push(parseInt(this.total_placas_rechazadas));

            this.generateGraficoPlacasRepetidas();
            this.generateGraficoPlacasTestigos();
            this.generateGraficoPlacasRechazadas();

        }catch(error){

        }finally  {this.$store.commit('loading', false);}

    },


   async seleccionarObra(){

        if(this.ot && !this.ot.obra){
            this.selObra = !this.selObra;
        }

    },

    async CambioObra (){

        this.selObra = !this.selObra;

        this.componente = '';
        this.$store.commit('loading', true);
        var urlRegistros = 'ots/' + this.ot.id + '/obra/' + this.obra.obra + '/componentes/' +'?api_token=' + Laravel.user.api_token;
        try {
            let res = await axios.get(urlRegistros);
            this.componentes = res.data;
        }catch(error){

            }finally  {this.$store.commit('loading', false);}

    },

    CambioComponente() {

        this.selComponente = !this.selComponente;
    }
    ,
    generateGraficoPlacasRepetidas() {

            this.data_placas_repetidas = {

                labels: ["Placas informadas" ,"Placas repetidas"],

                datasets: [
                    {
                        backgroundColor: ['#3C8DBC' ,'#00C0EF'],
                        data: this.valores_placas_repetidas
                    }
                ],
                options :{

                    title : {   display : true,
                                text :'Placas Repetidas',
                        },

                    legend: {
                        labels: {
                            boxWidth: 12,
                            padding: 5
                        }
                    },

                    plugins: {
                                datalabels: {

                                    color: '#FFFFFF',
                                    formatter: function (value) {
                                    return  ((Math.round(value*100/this.total_placas_con_repetidas)) + '%');
                                    }.bind(this),
                                    font: {
                                        weight: 'bold',
                                        size: 14,
                                    }
                                }
                            }
                },
            }
    },

    generateGraficoPlacasTestigos() {

            this.data_placas_testigos = {

                labels: ["Placas informadas" ,"Placas Testigos"],

                datasets: [
                    {
                        backgroundColor: ['#3C8DBC' ,'#00C0EF'],
                        data: this.valores_placas_testigos
                    }
                ],
                options :{

                    title : {   display : true,
                                text :'Placas Testigos',
                        },

                    legend: {
                        labels: {
                            boxWidth: 12,
                            padding: 5
                        }
                    },

                    plugins: {
                                datalabels: {

                                    color: '#FFFFFF',
                                    formatter: function (value) {
                                    return  ((Math.round(value*100/this.total_placas_con_testigos)) + '%');
                                    }.bind(this),
                                    font: {
                                        weight: 'bold',
                                        size: 14,
                                    }
                                }
                            }
                },
            }
    },

    generateGraficoPlacasRechazadas() {

            this.data_placas_rechazadas = {

                labels: ["Placas Aprobadas" ,"Placas Rechazadas"],

                datasets: [
                    {
                        backgroundColor: ['#3C8DBC' ,'#00C0EF'],
                        data: this.valores_placas_rechazadas
                    }
                ],
                options :{

                    title : {   display : true,
                                text :'Placas Rechazadas',
                        },

                    legend: {
                        labels: {
                            boxWidth: 12,
                            padding: 5
                        }
                    },

                    plugins: {
                                datalabels: {

                                    color: '#FFFFFF',
                                    formatter: function (value) {
                                    return  ((Math.round(value*100/this.total_placas_con_rechazadas)) + '%');
                                    }.bind(this),
                                    font: {
                                        weight: 'bold',
                                        size: 14,
                                    }
                                }
                            }
                },
            }
    },

}}

</script>
