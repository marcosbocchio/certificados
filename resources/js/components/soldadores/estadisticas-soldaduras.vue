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
                            <v-select v-show="selCliente" v-model="cliente" label="nombre_fantasia" :options="clientes" @input="CambioCliente()" ></v-select>

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
                        <button class="btn btn-enod  btn-block" :disabled="!cliente || !ot || !obra"><span class="fa fa-plus-circle"></span>
                            Buscar
                        </button>
                    </a>

                </div>
                <!-- /.box-body -->
            </div>
            <div v-if="ot">
                <div class="box box-custom-enod">
                    <div class="box-body box-profile">
                        <div v-if="ot.contratista">
                            <div v-if="ot.contratista.path_logo" style="text-align:center">
                                <img :src="'/' + ot.contratista.path_logo" alt="..." width="120">
                            </div>
                            <h3 class="profile-username text-center">
                                {{ot.contratista.razon_social}}
                            </h3>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item pointer">
                                    <b>Comitente</b>
                                    <a  class="pull-right">
                                        <div>{{ot.contratista.nombre}}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <ul class="list-group list-group-unbordered">
                            <span class="fa fa-book"><p style="margin-left:15px;display:inline-block;margin-bottom:20x">Informes incluidos</p></span>
                            <div v-for="(item,k) in (informes)" :key="k" class="list-informes">
                                <div v-if="item.gasoducto_sn">
                                   <p>Informe {{item.km}}-{{item.tipo_soldadura_codigo}}-{{item.numero_formateado}} {{ item.componente }} </p>
                                </div>
                                <div v-else>
                                   <p>Informe {{item.numero_formateado}} {{ item.componente }} </p>
                                </div>
                            </div>
                        </ul>
                      </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <div class="col-md-9">

                  <div class="estadisticas-soldaduras">
                    <tabs :options="{ useUrlFragment: false }" @clicked="tabClicked" @changed="tabChanged">
                        <tab name="Indices de rechazos">

                            <div v-if="data_indice_rechazos.options.length != []">

                                <div class="col-lg-12">
                                    <div class="div-grafico">
                                        <pie-chart :chart-data="data_indice_rechazos" :options="data_indice_rechazos.options" ></pie-chart>
                                    </div>
                                </div>

                                <div v-if="TablaAnalisisRechazosDiametro.length">
                                    <div class="row">
                                        <div class="col-lg-6 col-lg-offset-3">
                                            <div class="col-lg-12 titulo-tabla-tabs" >
                                                <h5>Análisis de rechazos por Diametro</h5>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="box box-primary">
                                                <div class="box-header with-border">
                                                    <i class="fas fa-bars"></i>

                                                    <h3 class="box-title"><strong>DETALLE</strong></h3>

                                                    <div class="box-tools pull-right">
                                                        <download-excel
                                                            :data   = "TablaAnalisisRechazosDiametro"
                                                            :fields = "rechazos_diametro_json_fields"
                                                            :meta   = "json_meta"
                                                            name    = "filename.xls">
                                                            <button class="btn btn-sm btn-default"><i class="fas fa-lg fa-file-excel"></i></button>

                                                        </download-excel>
                                                    </div>
                                                </div>
                                                <div class="stat-sol">
                                                    <table class="table table-striped table-condensed">
                                                        <tbody>
                                                            <tr>
                                                                <th class="col-lg-2">Ø</th>
                                                                <th class="col-lg-3">Aprobados</th>
                                                                <th class="col-lg-3">Rechazados</th>
                                                                <th class="col-lg-2">Total</th>
                                                                <th class="col-lg-2">%</th>
                                                            </tr>
                                                            <tr v-for="(item,k) in TablaAnalisisRechazosDiametro" :key="k">
                                                                <td>{{ item.diametro }}</td>
                                                                <td>{{ item.aprobados }}</td>
                                                                <td>{{ item.rechazados }}</td>
                                                                <td>{{ item.total }}</td>
                                                                <td>{{ item.porcentaje_rechazados }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total</th>
                                                                <th>{{ total_aprobados_soldaduras}}</th>
                                                                <th>{{ total_rechazos_soldaduras}}</th>
                                                                <th>{{ total_soldaduras_informes}}</th>
                                                                <th>{{ total_porcentaje_rechazados}}</th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="TablaAnalisisRechazosEspesor.length">
                                    <div class="row">
                                        <div class="col-lg-6 col-lg-offset-3">
                                            <div class="col-lg-12 titulo-tabla-tabs" >
                                                <h5>Análisis de rechazos por espesor</h5>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="box box-primary">
                                                <div class="box-header with-border">
                                                    <i class="fas fa-bars"></i>

                                                    <h3 class="box-title"><strong>DETALLE</strong></h3>

                                                    <div class="box-tools pull-right">
                                                        <download-excel
                                                            :data   = "TablaAnalisisRechazosEspesor"
                                                            name    = "filename.xls">
                                                            <button class="btn btn-sm btn-default"><i class="fas fa-lg fa-file-excel"></i></button>

                                                        </download-excel>
                                                    </div>
                                                </div>
                                                <div class="stat-sol">
                                                    <table class="table table-striped table-condensed">
                                                        <tbody>
                                                            <tr>
                                                                <th class="col-lg-2">#</th>
                                                                <th class="col-lg-3">Aprobados</th>
                                                                <th class="col-lg-3">Rechazados</th>
                                                                <th class="col-lg-2">Total</th>
                                                                <th class="col-lg-2">%</th>
                                                            </tr>
                                                            <tr v-for="(item,k) in TablaAnalisisRechazosEspesor" :key="k">
                                                                <td>{{ item.espesor }}</td>
                                                                <td>{{ item.aprobados }}</td>
                                                                <td>{{ item.rechazados }}</td>
                                                                <td>{{ item.total }}</td>
                                                                <td>{{ item.porcentaje_rechazados }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total</th>
                                                                <th>{{ total_aprobados_soldaduras}}</th>
                                                                <th>{{ total_rechazos_soldaduras}}</th>
                                                                <th>{{ total_soldaduras_informes}}</th>
                                                                <th>{{ total_porcentaje_rechazados}}</th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-else>
                                <h4>No hay datos para mostrar</h4>
                            </div>
                        </tab>
                        <tab name="Defectología">
                            <div v-if="TablaDetalleDefectos.length">
                                <div class="row">
                                    <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                        <div class="col-lg-12 titulo-tabla-tabs" >
                                            <h5>Defectos</h5>
                                        </div>
                                         <div class="clearfix"></div>
                                            <div class="box box-primary">
                                                <div class="box-header with-border">
                                                    <i class="fas fa-bars"></i>

                                                    <h3 class="box-title"><strong>DETALLE</strong></h3>

                                                    <div class="box-tools pull-right">
                                                        <download-excel
                                                            :data   = "TablaDetalleDefectos"
                                                            name    = "filename.xls">
                                                            <button class="btn btn-sm btn-default"><i class="fas fa-lg fa-file-excel"></i></button>

                                                        </download-excel>
                                                    </div>
                                                </div>
                                                <table class="table table-striped table-condensed">
                                                    <tbody>
                                                        <tr>
                                                            <th class="col-lg-2 col-md-1">Abrev.</th>
                                                            <th class="col-lg-5 col-md-4">Descripción</th>
                                                            <th class="col-lg-2 col-md-2" style="text-align: center;">Cant.</th>
                                                            <th colspan="2" class="col-lg-3 col-md-5" style="text-align: center;">Porcentaje</th>
                                                        </tr>
                                                        <tr v-for="(item,k) in TablaDetalleDefectos" :key="k">
                                                            <td>{{ item.abreviatura }}</td>
                                                            <td>{{ item.descripcion }}</td>
                                                            <td style="text-align: center;">{{ item.cantidad }}</td>
                                                            <td class="col-lg-2 col-md-4" >
                                                                <div class="progress progress-xs">
                                                                    <div class="progress-bar" :style="{width:item.porcentaje,background:colores[k].color}"></div>
                                                                </div>
                                                            </td>
                                                            <td >
                                                                <span class="badge" :style="{background:colores[k].color}">{{ item.porcentaje_formateado }}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total</th>
                                                            <th></th>
                                                            <th style="text-align: center;">{{ total_defectos }}</th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>

                                   <div class="clearfix"></div>
                                   <div class="col-lg-3" >
                                        <div class="form-group">
                                            <label for="diametro">Diámetro</label>
                                            <v-select v-model="DiametroDefecto"  :options="DiametrosDefectos" @input="GenerarGraficoDefectosPosicion" id="diametro"></v-select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="div-grafico">
                                            <doughnut-chart :chart-data="data_defectologia" :options="data_defectologia.options" ></doughnut-chart>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 totales_posiciones">
                                        <p><strong>Total defectos : </strong>{{ total_defectos_posicion}}</p>
                                    </div>
                                </div>
                            </div>
                             <div v-else>
                                <h4>No hay datos para mostrar</h4>
                            </div>
                        </tab>
                        <tab name="Defectología/Producción">
                            <div v-if="TablaDefectosSoldador.length">
                                <div class="row">
                                    <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                        <div class="col-lg-12 titulo-tabla-tabs" >
                                            <h5>Defectos por Soldador</h5>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <i class="fas fa-bars"></i>

                                                <h3 class="box-title"><strong>DETALLE</strong></h3>

                                                <div class="box-tools pull-right">
                                                    <download-excel
                                                        :data   = "TablaDefectosSoldador"
                                                        name    = "filename.xls">
                                                        <button class="btn btn-sm btn-default"><i class="fas fa-lg fa-file-excel"></i></button>

                                                    </download-excel>
                                                </div>
                                            </div>
                                            <table class="table table-striped table-hover">
                                                <tbody>
                                                    <tr>
                                                        <th class="col-lg-3 col-md-3">Cuño</th>
                                                        <th class="col-lg-3 col-md-2">Cord.</th>
                                                        <th class="col-lg-3 col-md-2" style="text-align: center;">Cant.</th>
                                                        <th colspan="2" class="col-lg-3 col-md-5" style="text-align: center;">Porcentaje</th>
                                                    </tr>
                                                    <tr v-for="(item,k) in TablaDefectosSoldador" :key="k" @click="getDetalleDefectosSoldador(item,k)" class="pointer"  :class="{selected: indexDefectosSoldador === k}">
                                                        <td>{{item.codigo_soldador}} - {{item.nombre_soldador }}</td>
                                                        <td>{{ item.cordones }}</td>
                                                        <td style="text-align: center;">{{ item.cantidad }}</td>
                                                        <td class="col-lg-2 col-md-4" >
                                                            <div class="progress progress-xs">
                                                                <div class="progress-bar" :style="{width:item.porcentaje,background:colores[k].color}"></div>
                                                            </div>
                                                        </td>
                                                        <td >
                                                            <span class="badge" :style="{background:colores[k].color}">{{ item.porcentaje_formateado }}</span>
                                                        </td>

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
                            <div v-if="TablaDetalletDefectosSoldador.length">
                                 <div class="row">
                                    <div class="col-lg-10 col-lg-offset-1">
                                        <div style="max-height:350px;">
                                            <bar-chart :chart-data="data_detalle_defectos_soldador" :options="data_detalle_defectos_soldador.options" style="height: 400px;"  ></bar-chart>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </tab>
                        <tab name="Indicaciones">
                            <div v-if="TablaIndicaciones.length">
                                <div class="row">
                                    <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                        <div class="col-lg-12 titulo-tabla-tabs" >
                                            <h5>Indicaciones</h5>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <i class="fas fa-bars"></i>

                                                <h3 class="box-title"><strong>DETALLE</strong></h3>

                                                <div class="box-tools pull-right">
                                                    <download-excel
                                                        :data   = "TablaIndicaciones"
                                                        name    = "filename.xls">
                                                        <button class="btn btn-sm btn-default"><i class="fas fa-lg fa-file-excel"></i></button>

                                                    </download-excel>
                                                </div>
                                            </div>
                                            <table class="table table-striped table-hover">
                                                <tbody>
                                                    <tr>
                                                        <th class="col-lg-2 col-md-1">Abrev.</th>
                                                        <th class="col-lg-4 col-md-4">Descripción</th>
                                                        <th class="col-lg-3 col-md-2" style="text-align: center;">Cant.</th>
                                                        <th colspan="2" class="col-lg-3 col-md-5" style="text-align: center;">Porcentaje</th>
                                                    </tr>
                                                    <tr v-for="(item,k) in TablaIndicaciones" :key="k" class="pointer">
                                                        <td>{{item.defecto_codigo}}</td>
                                                        <td>{{ item.defecto_descripcion }}</td>
                                                        <td style="text-align: center;">{{ item.cantidad }}</td>
                                                        <td class="col-lg-2 col-md-4" >
                                                            <div class="progress progress-xs">
                                                                <div class="progress-bar" :style="{width:item.porcentaje,background:colores[k].color}"></div>
                                                            </div>
                                                        </td>
                                                        <td >
                                                            <span class="badge" :style="{background:colores[k].color}">{{ item.porcentaje_formateado }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th></th>
                                                        <th style="text-align: center;">{{ total_indiciones }}</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                <div class="clearfix"></div>
                                <div class="col-lg-3" >
                                    <div class="form-group">
                                        <label for="diametro_indicaciones">Diámetro</label>
                                        <v-select v-model="DiametroIndicaciones"  :options="DiametrosIndicaciones" @input="GenerarGraficoIndicacionesPosicion" id="diametro_indicaciones"></v-select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="div-grafico">
                                        <doughnut-chart :chart-data="data_indicaciones_posicion" :options="data_indicaciones_posicion.options" ></doughnut-chart>
                                    </div>
                                </div>
                                <div class="col-lg-12 totales_posiciones">
                                    <div>
                                        <p><strong>Total Indicaciones : </strong>{{ total_indicaciones_posicion}}</p>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div v-else>
                               <h4>No hay datos para mostrar</h4>
                            </div>
                            <div v-if="TablaIndicacionesPosicionDetalle.length">
                                 <div class="row">
                                    <div class="col-lg-10 col-lg-offset-1">
                                        <div style="max-height:350px;">
                                            <bar-chart :chart-data="data_indicaciones_posicion_detalle" :options="data_indicaciones_posicion_detalle.options" ></bar-chart>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </tab>
                    </tabs>
                </div>
            </div>
         <loading
                  :active.sync="isLoading"
                  :loader="'bars'"
                  :color="'red'">
         </loading>
    </div>
</template>

<script>
Vue.use(Tabs);
import moment from 'moment';
import Datepicker from 'vuejs-datepicker';
import {mapState} from 'vuex';
import {en, es} from 'vuejs-datepicker/dist/locale'
import Tabs from 'vue-tabs-component';
import 'vue-tabs-component/docs/resources/tabs-component.css';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import DatePicker from 'vue2-datepicker';
import ChartJsPluginDataLabels from 'chartjs-plugin-datalabels';
import DoughnutChart from '../chart.js/DoughnutChart.js'
import BarChart from '../chart.js/BarChart.js'
import PieChart from '../chart.js/PieChart.js'

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
        clientes:[],
        ots:[],
        ot:'',
        obras:[],
        obra:'',
        fecha_desde:null,
        fecha_hasta:null,
        selCliente:false,
        selOt:false,
        selObra:false,
        informes : [],
        informes_ids :'',

        /* Indices de rechazos */
        data_indice_rechazos : { options : []},
        total_soldaduras_informes : 0,
        total_porcentaje_rechazados : 0,
        total_rechazos_soldaduras : 0,
        total_aprobados_soldaduras : 0,
        TablaAnalisisRechazosEspesor:[],
        TablaAnalisisRechazosDiametro:[],
        valores_indice_rechazos :[],

        /* Defectologia */
        data_defectologia : { options : []},
        total_defectos_posicion : 0,
        total_defectos : 0,
        valores_defectologia : [],
        TablaDefectosPosicion:[],
        DiametrosDefectos:[],
        DiametroDefecto:'',
        TablaDetalleDefectos:[],

        /* Defectoligía/Producción */
        TablaDDSTemp:[],
        data_detalle_defectos_soldador: { options : []},
        TablaDefectosSoldador:[],
        TablaDetalletDefectosSoldador:[],
        total_defectos_soldador:0,
        cantidad_defectos_soldador : 0,
        valores_detalle_defectos_soldador:[],
        indexDefectosSoldador : -1,

        /*Indicaciones  */
        TablaIndicaciones : [] ,
        TablaIndicacionesPosicion: [],
        total_indiciones : 0,
        total_indicaciones_posicion:0,
        DiametrosIndicaciones :[],
        DiametroIndicaciones:'',
        data_indicaciones_posicion : { options : []},
        data_indicaciones_posicion_detalle : { options : []},
        valores_indicaciones:[],
        TablaIndicacionesPosicionDetalle : [],
        valores_indicaciones_posicion:0,
        valores_totales_indicaciones_posicion: [],

        /* Exportación excel */
        rechazos_diametro_json_fields : {
            'Diametro'  : 'diametro',
            'Aprobados' : 'aprobados',
            'Rechazados' : 'rechazados',
            'Total'     : 'total',
            '%':'porcentaje_rechazados'
        },
        rechazos_espesor_json_fields : {},
        defectos_json_fields : {},
        defectos_soldador_json_fields : {},
        indicaciones_json_fields : {},
        json_meta: [
                    [
                        {
                            'key': 'charset',
                            'value': 'utf-8'
                        }
                    ]
                ],

     }

    },

    created: function () {

        this.getClienteOperador();

    },

    mounted() {

       this.$store.dispatch('loadColores');

   },

   computed :{

    ...mapState(['isLoading','colores','url']),

  },

methods : {

    generateIndicesRechazos() {

            this.data_indice_rechazos = {

                labels: ["Rechazados" ,"Aprobados"],

                datasets: [
                    {
                        backgroundColor: ['#3C8DBC' ,'#00C0EF'],
                        data: this.valores_indice_rechazos
                    }
                ],
                options :{

                    title : {   display : true,
                                text :'Indices de rechazos de soldaduras',
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
                                    return  ((Math.round(value*100/this.total_soldaduras_informes)) + '%');
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

    generateDefectologia() {

            let labels_aux = [];
            this.TablaDefectosPosicion.forEach(function(item) {

                if(item.diametro == this.DiametroDefecto){

                    labels_aux.push(item.posicion_placa);
                }

            }.bind(this))

            let long_aux = this.valores_defectologia.length;
            let data_aux = [];
            for (let index = 0; index < long_aux; index++) {
                data_aux.push(1);
            }

            this.data_defectologia = {

                labels: labels_aux,

                datasets: [
                    {
                        backgroundColor: ['#3C8DBC' ,'#00C0EF','#0073B7','#FFCC56','#FF9F40','#FE6383','#AAEB16','#636864','#4CC0C0'],
                        data: data_aux,
                    }
                ],
                options :{

                    title : {   display : true,
                                text :'Defectos por posición',
                        },

                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem,data) {
                                var label = data.labels[tooltipItem.index] || '';

                                if (label) {
                                    label += ': ';
                                }
                                label += this.valores_defectologia[tooltipItem.index];
                                return label;
                            }.bind(this)
                        }
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
                                    formatter: function (value,context) {
                                    if(this.total_defectos_posicion == 0)
                                        return 0 + '%';
                                    else
                                         return  ((Math.round(value*this.valores_defectologia[context.dataIndex]*100/this.total_defectos_posicion)) + '%');
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

    GenerarGraficoDefectosSoldador(soldador){
        this.data_detalle_defectos_soldador = {};
        let labels_aux = this.TablaDetalletDefectosSoldador.map(item => item.defecto_codigo);
        this.valores_detalle_defectos_soldador = this.TablaDetalletDefectosSoldador.map(item => parseFloat(item.cantidad));
        let titulo = 'Defectos producción ' + soldador.codigo_soldador + ' - ' + soldador.nombre_soldador;
        this.data_detalle_defectos_soldador = {

                labels: labels_aux,

                datasets: [
                    {
                        data: this.valores_detalle_defectos_soldador,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor : 'rgb(153, 102, 255)',
                        borderWidth : 1,                                  }
                ],
                options :{

                    title : {   display : true,
                                text :titulo,
                        },
                    legend: {
                            display: false
                        },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    maintainAspectRatio: false,

                    plugins: {
                                datalabels: {

                                    color: '#616161',
                                    formatter: function (value,context) {
                                    return  ((Math.round(value*100/this.cantidad_defectos_soldador)) + '%');
                                    }.bind(this),
                                    font: {
                                        weight: 'bold',
                                        size: 14,
                                    }
                                }
                            },

                    tooltips: {
                        displayColors:  false,
                        callbacks: {

                           title: function(tooltipItem,data) {
                                var title  = this.TablaDetalleDefectos[this.TablaDetalleDefectos.findIndex(item => item.abreviatura == tooltipItem[0].label)].descripcion;
                                title += ': ';
                                title += tooltipItem[0].value;
                                return title;


                            }.bind(this),

                            label : ()=> null,
                        }
                    },

                },
            }

    },

    generateIndicacionesPosicion() {

            let labels_aux = []
            this.TablaIndicacionesPosicion.forEach(function(item) {

                if(item.diametro == this.DiametroIndicaciones){

                    labels_aux.push(item.posicion_placa);
                }

            }.bind(this))

            console.log('Labels Aux : ',labels_aux);

            let long_aux = this.valores_indicaciones.length;
            let data_aux = [];
            for (let index = 0; index < long_aux; index++) {
                data_aux.push(1);
            }
            let labels_reverse = labels_aux.reverse();
            let valores_indicaciones_reverse = this.valores_indicaciones.reverse();
            this.data_indicaciones_posicion = {

                labels: labels_aux,
                datasets: [
                    {
                        backgroundColor: ['#3C8DBC' ,'#00C0EF','#0073B7','#FFCC56','#FF9F40','#FE6383','#AAEB16','#636864','#4CC0C0'],
                        data: data_aux,
                    }
                ],
                options :{

                events: ['mousemove', 'click'],
                onHover: (event, chartElement) => {
                          event.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                },

                onClick: function(evt,data) {
                        this.getIndicacionesPosicion(evt,labels_aux[data[0]._index]);
                    }.bind(this),

                    title : {   display : true,
                                text :'Indicaciones por posición',
                        },

                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem,data) {
                                var label = data.labels[tooltipItem.index] || '';

                                if (label) {
                                    label += ': ';
                                }
                                label += valores_indicaciones_reverse[tooltipItem.index];
                                return label;
                            }.bind(this)
                        }
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
                                    formatter: function (value,context) {
                                       if(this.total_indicaciones_posicion == 0)
                                          return 0 + '%';
                                       else
                                          return ((Math.round(value*this.valores_indicaciones[context.dataIndex]*100/this.total_indicaciones_posicion)) + '%');
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

    GenerarGraficoIndicacionesSoldadorDetalle(posicion){

        this.data_indicaciones_posicion_detalle = {};
        let labels_aux = this.TablaIndicacionesPosicionDetalle.map(item => item.defecto_codigo);
        this.valores_indicaciones_posicion = this.TablaIndicacionesPosicionDetalle.map(item => parseFloat(item.cantidad));
        this.valores_totales_indicaciones_posicion = this.TablaIndicacionesPosicionDetalle.map(item => item.total);

        let titulo = 'Indicaciones por posición ' + posicion;
        this.data_indicaciones_posicion_detalle = {

                labels: labels_aux,

                datasets: [
                    {
                        data: this.valores_totales_indicaciones_posicion,
                        backgroundColor: 'rgba(210, 214, 222)',
                        borderColor : 'rgba(210, 214, 222)',
                        borderWidth : 1

                    },
                    {
                        data: this.valores_indicaciones_posicion,
                        backgroundColor: 'rgba(0, 166,90)',
                        borderColor : 'rgba(0, 166,90)',
                        borderWidth : 1

                    }
                ],
                options :{

                    title : {   display : true,
                                text :titulo,
                        },
                    legend: {
                            display: false
                        },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    maintainAspectRatio: false,

                    tooltips: {
                        displayColors:  false,
                        callbacks: {

                           title: function(tooltipItem,data) {
                                var title  = this.TablaIndicacionesPosicionDetalle[this.TablaIndicacionesPosicionDetalle.findIndex(item => item.defecto_codigo == tooltipItem[0].label)].defecto_descripcion;
                                if(tooltipItem[0].datasetIndex == 0){
                                    title+= ' total';
                                }
                                title += ': ';
                                title += tooltipItem[0].value;
                                return title;

                            }.bind(this),

                            label: function(tooltipItem,data) {
                                if(tooltipItem.datasetIndex == 0) {
                                   return ['Diametro: ' + this.DiametroIndicaciones ] ;
                                }else {
                                    return ['Posición: ' + posicion, 'Porcentaje: ' +(Math.round(tooltipItem.value*100/data.datasets[0].data[tooltipItem.index])) + '%']
                                }

                            }.bind(this),


                        }
                    },

                },
            }

    },

    getClienteOperador(){

        this.$store.commit('loading', true);
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'clientes/operador/' + this.user.id  +'?api_token=' + Laravel.user.api_token;
        axios.get(urlRegistros).then(response =>{
            this.clientes = response.data
            if(this.user.cliente_id != null) {
                this.cliente = response.data;
            }
        }).finally(()=> {this.$store.commit('loading', false)});
    },

    async Buscar(){

     this.$store.commit('loading', true);
     this.TablaAnalisisRechazosEspesor = [];
     this.selCliente = false;
     this.selOt = false;
     this.selObra = false;

    try {
        let url = 'informes/ot/' + this.ot.id  + '/obra/' +  this.obra.obra.replace('/','--') + '/fecha_desde/' + this.fecha_desde + '/fecha_hasta/' + this.fecha_hasta + '?api_token=' + Laravel.user.api_token;
        let res = await axios.get(url);
        this.informes = res.data;
        this.informes_ids = this.informes.map(item => item.id).toString();
        this.valores_indice_rechazos= [];
        await this.getIndicesDeRechazos();
        await this.getDefectologia();
        await this.getDefectologiaProduccion();
        await this.getIndicaciones();
        this.generateIndicesRechazos();

    }catch(error){

    }
    finally  {this.$store.commit('loading', false);}

    },

    async CambioCliente (){

        this.selCliente = !this.selCliente;
        this.ot = '';
        this.selOt =false;
        this.obra = '';
        this.selObra =false;
        this.fecha_desde = null;
        this.fecha_hasta = null;
        this.resetVariables();
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
        this.resetVariables();
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

    seleccionarObra(){

        this.resetVariables();
        if(this.ot && !this.ot.obra){
            this.selObra = !this.selObra;
        }
    },

    async CambioObra (){

        this.TablaAnalisisRechazosEspesor = [];
        this.selObra = !this.selObra;

    },

    resetVariables(){

        this.informes                      = [];
        this.TablaAnalisisRechazosEspesor  = [];
        this.TablaAnalisisRechazosDiametro      = [];
        this.TablaDefectosPosicion         = [];
        this.TablaDetalleDefectos          = [];
        this.TablaDefectosSoldador         = [];
        this.TablaDetalletDefectosSoldador = [];
        this.valores_detalle_defectos_soldador = null;
        this.data_detalle_defectos_soldador = null;
        this.data_indice_rechazos = { options : []},
        this.TablaIndicaciones = [];
        this.TablaIndicacionesPosicion = [];
        this.TablaIndicacionesPosicionDetalle = [];
        this.indexDefectosSoldador = -1;

    },

    async getIndicesDeRechazos(){

        this.$store.commit('loading', true);
        try {
            let url = 'estadisticas-soldaduras/analisis_rechazos_espesor/' + this.informes_ids;
            let res= await axios.get(url);
            this.TablaAnalisisRechazosEspesor =  res.data;
            this.TablaAnalisisRechazosEspesor.forEach(function(item){item.espesor = item.espesor + ' mm'})
            url = 'estadisticas-soldaduras/analisis_rechazos_diametro/' + this.informes_ids;
            res= await axios.get(url);
            this.TablaAnalisisRechazosDiametro =  res.data;
            this.TablaAnalisisRechazosDiametro.forEach(function(item){item.diametro = item.diametro + ' "'})
            await this.calcularIndicesRechazosSoldaduras(this.TablaAnalisisRechazosEspesor);

        }catch(error){

        }finally  { this.$store.commit('loading', false); }


    },

    async getDefectologia(){

        this.$store.commit('loading', true);
        try {

            let url = 'estadisticas-soldaduras/analisis_defectos_posicion/' + this.informes_ids;
            let res= await axios.get(url);
            this.TablaDefectosPosicion = res.data;
            url = 'estadisticas-soldaduras/analisis_detalle_defectos/' + this.informes_ids;
            res= await axios.get(url);
            this.TablaDetalleDefectos = res.data;
            this.total_defectos = this.TablaDetalleDefectos.map(item =>parseInt(item.cantidad)).reduce((a,b) => a + b,0);
            this.TablaDetalleDefectos.forEach(function(item){
                item.porcentaje =  parseFloat(item.cantidad*100/this.total_defectos).toFixed(1) + '%';
                item.porcentaje_formateado = item.porcentaje.length < 5 ? (String.fromCharCode(160)+ String.fromCharCode(160) + item.porcentaje)  : item.porcentaje;
            }.bind(this))
            this.DiametrosDefectos =[...new Set(this.TablaDefectosPosicion.map(item=> item.diametro))];
            this.DiametroDefecto = this.DiametrosDefectos.length ? this.DiametrosDefectos[0] : '';
            await this.GenerarGraficoDefectosPosicion();

        }catch(error){

        }finally  {this.$store.commit('loading', false);}


    },

    async getDefectologiaProduccion(){

        this.$store.commit('loading', true);
        try {
            let url = 'estadisticas-soldaduras/analisis_defectos_soldador/' + this.informes_ids;
            let res = await axios.get(url);
            this.TablaDDSTemp = res.data;
            await this.GenerarTablaDefectosSoldador()
            this.total_defectos_soldador = this.TablaDefectosSoldador.map(item =>parseInt(item.cantidad)).reduce((a,b) => a + b,0);

            this.TablaDefectosSoldador.forEach(function(item){
                item.porcentaje =  parseFloat(item.cantidad*100/item.cordones).toFixed(1) + '%';
                item.porcentaje_formateado = item.porcentaje.length < 5 ? (String.fromCharCode(160)+ String.fromCharCode(160) + item.porcentaje)  : item.porcentaje;
            }.bind(this));

          if(this.TablaDefectosSoldador.length > 0) {
                await this.getDetalleDefectosSoldador(this.TablaDefectosSoldador[0]);
            }

        }catch(error){

        }finally  {
            this.$store.commit('loading', false);

            }
    },

    async getDetalleDefectosSoldador(soldador,index = 0){

        this.indexDefectosSoldador = index;
        this.$store.commit('loading', true);
        this.TablaDetalletDefectosSoldador = [];
        this.valores_detalle_defectos_soldador = [];
        this.cantidad_defectos_soldador  = 0;

        this.TablaDDSTemp.forEach(function(item){

            if(parseFloat(item.cantidad) > 0 && parseInt(item.soldador_id) == parseInt(soldador.soldador_id)){

                this.TablaDetalletDefectosSoldador.push({

                    'cantidad'  : item.cantidad,
                    'defecto_codigo' : item.defecto_codigo,
                    'defecto_descripcion' : item.defecto_descripcion

                })
                this.cantidad_defectos_soldador += parseFloat(item.cantidad);
            }

        }.bind(this));

        this.TablaDetalletDefectosSoldador.sort((a, b) => (a.cantidad < b.cantidad) ? 1 : -1)
        this.GenerarGraficoDefectosSoldador(soldador);
        this.$store.commit('loading', false);
    },

    async GenerarTablaDefectosSoldador(){


       let TablaDefectosSoldadorUnique = [...new Set(this.TablaDDSTemp.map(item=> item.soldador_id))];
       this.TablaDefectosSoldador = [];

       TablaDefectosSoldadorUnique.forEach(function(item_u){

            this.TablaDDSTemp.forEach(function(item_t){


                    if(parseFloat(item_t.cantidad) > 0  && item_u == item_t.soldador_id){

                           if(this.TablaDefectosSoldador.findIndex(elem => elem.soldador_id == item_t.soldador_id)!= -1){

                               this.TablaDefectosSoldador[this.TablaDefectosSoldador.findIndex(elem => elem.soldador_id == item_t.soldador_id)].cantidad += parseFloat(item_t.cantidad);

                           }else{

                               this.TablaDefectosSoldador.push({

                                   'cantidad':parseFloat(item_t.cantidad),
                                   'codigo_soldador': item_t.codigo_soldador,
                                   'defecto_codigo': item_t.defecto_codigo,
                                   'nombre_soldador': item_t.nombre_soldador,
                                   'soldador_id' : item_t.soldador_id,
                                   'cordones' : item_t.cordones,
                               });

                           }
                    }
            }.bind(this));

       }.bind(this));

     this.TablaDefectosSoldador.sort((a, b) => (a.cantidad < b.cantidad) ? 1 : -1)

    },

    async GenerarGraficoDefectosPosicion(){

        this.total_defectos_posicion = 0;
        this.valores_defectologia = this.TablaDefectosPosicion.filter(item => item.diametro == this.DiametroDefecto);
        this.valores_defectologia = this.valores_defectologia.map(item => item.cantidad);
        this.valores_defectologia.forEach(function(item){
            this.total_defectos_posicion += parseInt(item)
        }.bind(this))

        this.generateDefectologia();
    },



    async calcularIndicesRechazosSoldaduras(tabla){

        this.total_soldaduras_informes = 0;
        this.total_rechazos_soldaduras = 0;
        this.total_aprobados_soldaduras = 0;
        this.total_porcentaje_rechazados = 0;

        tabla.forEach(function(item){

            this.total_rechazos_soldaduras   +=  parseInt(item.rechazados);
            this.total_aprobados_soldaduras  +=  parseInt(item.aprobados);
            this.total_soldaduras_informes   +=  parseInt(item.total);

        }.bind(this));

        this.total_porcentaje_rechazados = parseFloat(this.total_rechazos_soldaduras * 100 /  this.total_soldaduras_informes).toFixed(2);
        this.valores_indice_rechazos.push(this.total_rechazos_soldaduras);
        this.valores_indice_rechazos.push(this.total_aprobados_soldaduras);

    },

    async getIndicaciones(){

        this.$store.commit('loading', true);
        try {

            let url = 'estadisticas-soldaduras/analisis_indicaciones/' + this.informes_ids;
            let res= await axios.get(url);
            this.TablaIndicaciones = res.data;
            url = 'estadisticas-soldaduras/analisis_detalle_indicaciones/' + this.informes_ids;
            res= await axios.get(url);
            this.TablaIndicacionesPosicion = res.data;
            this.total_indiciones = this.TablaIndicaciones.map(item =>parseInt(item.cantidad)).reduce((a,b) => a + b,0);
            this.TablaIndicaciones.forEach(function(item){
                  item.porcentaje =  parseFloat(item.cantidad*100/this.total_indiciones).toFixed(1) + '%';
                  item.porcentaje_formateado = item.porcentaje.length < 5 ? (String.fromCharCode(160)+ String.fromCharCode(160) + item.porcentaje)  : item.porcentaje;
             }.bind(this))
           this.DiametrosIndicaciones =[...new Set(this.TablaIndicacionesPosicion.map(item=> item.diametro))];
           this.DiametroIndicaciones = this.TablaIndicacionesPosicion.length ? this.DiametrosIndicaciones[0] : '';
            await this.GenerarGraficoIndicacionesPosicion();

        }catch(error){

        }finally  {this.$store.commit('loading', false);}

    },

    async GenerarGraficoIndicacionesPosicion(){

        this.total_indicaciones_posicion = 0;
        this.TablaIndicacionesPosicionDetalle = [];
        this.valores_indicaciones = this.TablaIndicacionesPosicion.filter(item => item.diametro == this.DiametroIndicaciones);
        this.valores_indicaciones = this.valores_indicaciones.map(item => item.cantidad);
        this.valores_indicaciones.forEach(function(item){
            this.total_indicaciones_posicion += parseInt(item)
        }.bind(this))

        this.generateIndicacionesPosicion();

    },

    async getIndicacionesPosicion(event,posicion){

        this.$store.commit('loading', true);
        try {

            let url = 'estadisticas-soldaduras/analisis_indicaciones_posicion/posicion/' + posicion + '/diametro/'+ this.DiametroIndicaciones.replace('/','--') + '/' + this.informes_ids ;
            console.log(url);
            let res= await axios.get(url);
            this.TablaIndicacionesPosicionDetalle = res.data;
            await this.GenerarGraficoIndicacionesSoldadorDetalle(posicion);

        }catch(error){

        }finally  {this.$store.commit('loading', false);}

    },

    tabClicked (selectedTab) {
          console.log('Current tab re-clicked:' + selectedTab.tab.name);
    },

    tabChanged (selectedTab) {
          console.log('Tab changed to:' + selectedTab.tab.name);
    },
 }
}
</script>


<style>

/* Page styles */

.tabs-component {
    margin: 0;

}

.tabs-component-tabs {

    padding-left: 0;
    margin-left: 0;
}

.tabs-component-panels
 {
    position: relative;
}

body {
    background-color: #efefef;
    padding: 1em;
}

.page {
    background-color: #fff;
    border-radius: 3px;
    box-shadow: 0 2px 20px rgba(0, 0, 0, .025);
    margin: 0 auto;
    max-width: 66em;
    padding: 4em 2em;
}

@media (min-width: 700px) {
    .page {
        padding: 4em;
    }
}

.page-title {
    font-size: 2.4rem;
    margin-bottom: 1em;
}

.page-title a {
    color: inherit;
    text-decoration: none;
}

.page-title a:hover {
    color: #007593;
}

.page-subtitle {
    font-size: 1.25rem;
    margin-bottom: 1em;
    padding-top: .25em;
}

.page-about {
    background-color: #d1e8eb;
    margin: 0 -2em;
    padding: 2em 1em;
}

@media (min-width: 700px) {
    .page-about {
        border-radius: 3px;
        margin: 0;
        padding: 2em;
    }
}

.page-about h2 {
    color: #003345;
}

.page-about p {
    color: #003345;
    line-height: 1.45;
    margin-bottom: 1em;
}

.page-about a {
    color: #007593;
}

.page-about code {
    background-color: rgba(255, 255, 255, .75);
    border-radius: 3px;
    padding: 0 .25em;
}

.page-outro {
    color: #999;
    display: block;
    margin-top: 4em;
    text-align: center;
}

.page-outro a {
    color: #999;
}

.prefix,
.suffix {
    align-items: center;
    border-radius: 1.25rem;
    display: flex;
    font-size: .75rem;
    flex-shrink: 0;
    height: 1.25rem;
    justify-content: center;
    line-height: 1.25rem;
    min-width: 1.25rem;
    padding: 0 .1em;
}

.prefix {
    background-color: #d1e8eb;
    color: #0c5174;
    margin-right: .35em;
}

.suffix {
    background-color: #c03;
    color: #fff;
    margin-left: .35em;

}

@media (min-width: 700px) {
    .suffix {
        position: absolute;
        right: -.725em;
        top: -.725em;
    }
}
.seleccionar {
   /* font-size: 14px; */
    font: inherit;
    font-family: inherit;
    color:#8e8e8e ;
}

.list-fecha .mx-input,.list-fecha .mx-datepicker,.list-fecha .mx-input-wrapper {
    box-shadow : none !important;
   -webkit-box-shadow : none !important;
    border-top: none !important;
    border-left: none !important;
    border-right: none !important;
    border-radius: 0px !important;
    padding-left: 0px;

    }
.is-active{

    border-top:3px solid rgb(255, 204, 0) !important;
    box-shadow: 0 -2px 0 #000;
}

ul li .titulo-li {
    font-weight: 600 !important;
}

 .list-fecha {
     border-bottom: none !important;
 }

 .list-informes {

     font-size: 14px;
     color: gray;
     font-weight: 500;
     line-height: 10px;
 }

.btn-enod {
    border: 1px solid black;
}

.box-custom-enod {

    box-shadow: 0 -2px 0 #000;
}

.profile-username {

    font-size: 16px !important ;
    font-weight: 500 !important ;
    line-height: 1.1 !important ;
    font-family: 'Montserrat',sans-serif;

}

.stat-sol table tbody tr th,.stat-sol table tbody tr td {
    text-align: center;
}

.titulo-tabla-tabs{
    text-align: center !important;
}

.titulo-tabla-tabs h5{

    font-weight: 700 !important;
    color: #666 !important;
    font-size: 12px;
    font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
}

  .div-grafico {
    max-width:375px;

    margin:  0px auto 15px auto;
  }

  .totales_posiciones {

      color:#666;
      font-size: 14px;
  }
</style>
