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

                                    <div class="col-lg-4">
                                        <button @click="downloadPdf_tab1">Exportar PDF</button>
                                    </div>
                                    <div class="div-grafico">
                                        <pie-chart :chart-id="'img_rechazos'" :chart-data="data_indice_rechazos" :options="data_indice_rechazos.options" ></pie-chart>
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
                                                            :title = "excel_titulo"
                                                            worksheet = "Indices de rechazos"
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
                                                            :fields = "rechazos_espesor_json_fields"
                                                            :meta   = "json_meta"
                                                            :title = "excel_titulo"
                                                             worksheet = "Indices de rechazos"
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
                                <div class="col-lg-4">
                                    <button @click="downloadPdf_tab2">Exportar PDF</button>
                                </div>

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
                                                            :fields = "defectos_json_fields"
                                                            :meta   = "json_meta"
                                                            :title = "excel_titulo"
                                                             worksheet = "Defectología"
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
                                            <div>
                                                <doughnut-chart :chart-id="'img_defectologia'" :chart-data="data_defectologia" :options="data_defectologia.options" ></doughnut-chart>
                                            </div>
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
                                <div class="col-lg-4">
                                    <button @click="downloadPdf_tab3">Exportar PDF</button>
                                </div>
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
                                                        :fields = "defectos_soldador_json_fields"
                                                        :meta   = "json_meta"
                                                        :title = "excel_titulo"
                                                        worksheet = "Defectología - Producción"
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
                                            <bar-chart :chart-id="'img_defectologia_produccion'" :chart-data="data_detalle_defectos_soldador" :options="data_detalle_defectos_soldador.options" style="height: 400px;"  ></bar-chart>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </tab>
                        <tab name="Indicaciones">
                            <div v-if="TablaIndicaciones.length">
                                <div class="col-lg-4">
                                    <button @click="downloadPdf_tab4">Exportar PDF</button>
                                </div>
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
                                                        :fields = "indicaciones_json_fields"
                                                        :meta   = "json_meta"
                                                        :title = "excel_titulo"
                                                        worksheet = "Indicaciones"
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
                                        <doughnut-chart :chart-id="'img_indicaciones'" :chart-data="data_indicaciones_posicion" :options="data_indicaciones_posicion.options" ></doughnut-chart>
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
                                    <div class="col-lg-12">
                                        <div class="div-grafico">
                                            <div>
                                                <bar-chart :chart-data="data_indicaciones_posicion_detalle" :options="data_indicaciones_posicion_detalle.options" ></bar-chart>
                                            </div>
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
import html2canvas from 'html2canvas-render-offscreen';
//import html2canvas from 'html2canvas';

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
        fecha_actual: moment(new Date()).format('DD-MM-YYYY'),

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
        soldador : {},

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
            'Diametro'    : 'diametro',
            'Aprobados'   : 'aprobados',
            'Rechazados'  : 'rechazados',
            'Total'       : 'total',
            '%'           :'porcentaje_rechazados'
        },

        excel_titulo : "",

        rechazos_espesor_json_fields : {
            'Espesor'     : 'espesor',
            'Aprovados'   : 'aprobados',
            'Rechazados'  : 'rechazados',
            'Total'       : 'total',
            '%'           :'porcentaje_rechazados'

        },

        defectos_json_fields : {
            'Abrev.'      : 'abreviatura',
            'Descripción' : 'descripcion',
            'Cantidad'    : 'cantidad',
            'Porcentaje'  : 'porcentaje'
        },

        defectos_soldador_json_fields : {
            'Cuño'      : 'codigo_soldador',
            'Nombre'    : 'nombre_soldador',
            'Cordones'  : 'cordones',
            'Cantidad'  : 'cantidad',
            '%'         : 'porcentaje',

        },

        indicaciones_json_fields : {
            'Defecto':'defecto_codigo',
            'Descripción':'defecto_descripcion',
            'Cantidad':'cantidad',
            '%':'porcentaje'
        },

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

     this.prepareTituloExcel();

    try {
        let url = 'informes/ot/' + this.ot.id  + '/obra/' +  this.obra.obra.replace('/','--') + '/fecha_desde/' + this.fecha_desde + '/fecha_hasta/' + this.fecha_hasta + '?api_token=' + Laravel.user.api_token;
        let res = await axios.get(url);
        this.informes = res.data;
        this.informes_ids = this.informes.map(item => item.id).toString();
        console.log(this.informes_ids);
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

    prepareTituloExcel : function() {

    this.excel_titulo = ["Cliente: " + this.cliente.nombre_fantasia + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + "OT Nº: " + this.ot.numero + "&nbsp;&nbsp;&nbsp;&nbsp;" +  "Obra Nº: " + this.obra.obra]
    this.excel_titulo.push("Desde: " + (this.fecha_desde ? moment( this.fecha_desde).format("DD/MM/YYYY") : '-'));
    this.excel_titulo.push("Hasta: " + (this.fecha_hasta ? moment( this.fecha_hasta).format("DD/MM/YYYY") : '-'));

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
        this.TablaAnalisisRechazosDiametro = [];
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
        this.soldador  = soldador;
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
                                   'soldador_codigo_nombre' : item_t.codigo_soldador + ' - ' + item_t.nombre_soldador,
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

    prepareHeaderPdf(doc){

        const imgDataLogo = 'data:image/jpeg;base64,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ZW51bQAAAABQZ1BzAAAAAFBnUEMAAAAATGVmdFVudEYjUmx0AAAAAAAAAAAAAAAAVG9wIFVudEYjUmx0AAAAAAAAAAAAAAAAU2NsIFVudEYjUHJjQFkAAAAAAAAAAAAQY3JvcFdoZW5QcmludGluZ2Jvb2wAAAAADmNyb3BSZWN0Qm90dG9tbG9uZwAAAAAAAAAMY3JvcFJlY3RMZWZ0bG9uZwAAAAAAAAANY3JvcFJlY3RSaWdodGxvbmcAAAAAAAAAC2Nyb3BSZWN0VG9wbG9uZwAAAAAAOEJJTQPtAAAAAAAQAEgAAAABAAIASAAAAAEAAjhCSU0EJgAAAAAADgAAAAAAAAAAAAA/gAAAOEJJTQPyAAAAAAAKAAD///////8AADhCSU0EDQAAAAAABAAAAB44QklNBBkAAAAAAAQAAAAeOEJJTQPzAAAAAAAJAAAAAAAAAAABADhCSU0nEAAAAAAACgABAAAAAAAAAAE4QklNA/UAAAAAAEgAL2ZmAAEAbGZmAAYAAAAAAAEAL2ZmAAEAoZmaAAYAAAAAAAEAMgAAAAEAWgAAAAYAAAAAAAEANQAAAAEALQAAAAYAAAAAAAE4QklNA/gAAAAAAHAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAAAAP////////////////////////////8D6AAAOEJJTQQIAAAAAAAQAAAAAQAAAkAAAAJAAAAAADhCSU0EHgAAAAAABAAAAAA4QklNBBoAAAAAA08AAAAGAAAAAAAAAAAAAACDAAABqwAAAA0AbABvAGcAbwAtAGUAbgBvAGQALQB3AGUAYgAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAABqwAAAIMAAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAQAAAAAQAAAAAAAG51bGwAAAACAAAABmJvdW5kc09iamMAAAABAAAAAAAAUmN0MQAAAAQAAAAAVG9wIGxvbmcAAAAAAAAAAExlZnRsb25nAAAAAAAAAABCdG9tbG9uZwAAAIMAAAAAUmdodGxvbmcAAAGrAAAABnNsaWNlc1ZsTHMAAAABT2JqYwAAAAEA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Lm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1sbnM6aWxsdXN0cmF0b3I9Imh0dHA6Ly9ucy5hZG9iZS5jb20vaWxsdXN0cmF0b3IvMS4wLyIgeG1sbnM6cGRmPSJodHRwOi8vbnMuYWRvYmUuY29tL3BkZi8xLjMvIiB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iIGRjOmZvcm1hdD0iaW1hZ2UvanBlZyIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAxNi0xMS0wNFQxMjo1MS0wMzowMCIgeG1wOk1vZGlmeURhdGU9IjIwMTYtMTEtMDRUMTI6NTEtMDM6MDAiIHhtcDpDcmVhdGVEYXRlPSIyMDE1LTEyLTIxVDE4OjQ1OjEyLTAzOjAwIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NzM0OUM2MjJFMEExRTYxMThGRjY5OUY1NkU4RTI0QjUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RjhGM0ZCMDA4QTIwNjgxMTgyMkE4REVCQTc4OTEzRTciIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0idXVpZDo1RDIwODkyNDkzQkZEQjExOTE0QTg1OTBEMzE1MDhDOCIgeG1wTU06UmVuZGl0aW9uQ2xhc3M9InByb29mOnBkZiIgaWxsdXN0cmF0b3I6U3RhcnR1cFByb2ZpbGU9IlByaW50IiBwZGY6UHJvZHVjZXI9IkFkb2JlIFBERiBsaWJyYXJ5IDkuOTAiIHBob3Rvc2hvcDpMZWdhY3lJUFRDRGlnZXN0PSJFQjMwRTFDOEEwQzIzRkYxRERCN0REQjlDQjVBODgxRiIgcGhvdG9zaG9wOkNvbG9yTW9kZT0iMyI+IDxkYzp0aXRsZT4gPHJkZjpBbHQ+IDxyZGY6bGkgeG1sOmxhbmc9IngtZGVmYXVsdCI+bG9nby1lbm9kMjAxMy1jdXJ2YXM8L3JkZjpsaT4gPC9yZGY6QWx0PiA8L2RjOnRpdGxlPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0idXVpZDpjMThkMzFlYy1iNmMzLWI1NGItOWEwOS00YTQxYmJkMWZmOTUiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NTcyQ0Y5NTYxMjIwNjgxMThDMTQ5NDlDMUVFMERDMzEiIHN0UmVmOm9yaWdpbmFsRG9jdW1lbnRJRD0idXVpZDo1RDIwODkyNDkzQkZEQjExOTE0QTg1OTBEMzE1MDhDOCIgc3RSZWY6cmVuZGl0aW9uQ2xhc3M9InByb29mOnBkZiIvPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo1NzJDRjk1NjEyMjA2ODExOEMxNDk0OUMxRUUwREMzMSIgc3RFdnQ6d2hlbj0iMjAxMy0wOC0zMFQxNzo1MDoyNi0wMzowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgSWxsdXN0cmF0b3IgQ1M1IiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo3MzQ5QzYyMkUwQTFFNjExOEZGNjk5RjU2RThFMjRCNSIgc3RFdnQ6d2hlbj0iMjAxNi0xMS0wNFQxMjo1MS0wMzowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPC9yZGY6U2VxPiA8L3htcE1NOkhpc3Rvcnk+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDw/eHBhY2tldCBlbmQ9InciPz7/7gAhQWRvYmUAZEAAAAABAwAQAwIDBgAAAAAAAAAAAAAAAP/bAIQAAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQICAgICAgICAgICAwMDAwMDAwMDAwEBAQEBAQEBAQEBAgIBAgIDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMD/8IAEQgAgwGrAwERAAIRAQMRAf/EASQAAAEEAwEBAQEAAAAAAAAAAAAHCQoLAQYIBQQDAgEBAAMBAAMBAQEAAAAAAAAAAAECAwQHCAkFBgoQAAAEBAQFAwQAAwgBBQAAAAABAggDBgcJERIEBRAgExkKITIaMDEYOUEiFEBQMxYXNzgpFXBCIyg6EQAABgECAgQHCAoKDAoKAwABAgMEBQYHEQgAEiExExRBFTWX15gJEFFhIhbWODkg8HGBkbEyIxe3ocHRtHXVlhh4uDDhQmJyMySVdic3h/GSQ9NEVSZnSNhAUoMlRcVmR3doWIioEgABAgMGAwQGBgYHBwUAAAABAgMAEQQQITESMgUgkQZBYSITMFFxgaEH8LHR4SMUQMFCM9QIUNOUFZU2N3DxYnLSJRZkdHUXJ//aAAwDAQECEQMRAAAAn8AAH8jbqXJEAABwrJOLMIAADJusT2BVwLeP1T0BV1jAA4ItGizODs+pY4AloxVeeBEaHQph21Y6tDuGGQGk5JXL1j0T6ZKcLHV2RD1wAAACPZGkM/038rWSvuT4m6uQABXZujinSikzQMABiHfCsvrOav3To7zYr+pOtzdmAVoboTjTL27UnH4nWSOwvX2zohC/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'

        var pageCount = doc.internal.getNumberOfPages();
            for(let i = 0; i < pageCount; i++) {
                doc.setPage(i);

                /* header logo */
                doc.setFontSize(16);
                doc.setFontType("bold");
                doc.text("Indices de rechazos", 77,15)
                doc.setFontSize(8);
                doc.text("FECHA :",165,13)
                doc.text("PAGINA:",165,18);
                doc.setFontType("normal");
                doc.text(this.fecha_actual,177,13)
                doc.text(doc.internal.getCurrentPageInfo().pageNumber + " de " + pageCount,179,18);
                doc.addImage(imgDataLogo, 'PNG', 13, 10,39.12, 12);

                /* linea amarilla */

                doc.setLineWidth(0.8);
                doc.setDrawColor(255,204,0);
                doc.line(11, 33, 200, 33);

                /* header entre lineas */
                doc.setFontSize(10);
                doc.setFontType("bold");
                doc.text("Cliente", 14, 39);
                doc.text("Obra", 150, 39);
                doc.text("Desde", 170, 39);

                doc.setLineWidth(0.3);
                doc.setDrawColor(32,178,170);
                doc.line(11, 47, 200, 47);

                doc.text("Proyecto", 14, 53);
                doc.text("OT Nº", 150, 53);
                doc.text("Hasta", 170, 53);

                /* Datos del header*/
                doc.setFontType("normal");
                doc.setFontType("italic");

                doc.text(this.cliente.nombre_fantasia, 14, 44)
                doc.text(this.obra.obra, 150, 44)
                doc.text((this.fecha_desde ? moment( this.fecha_desde).format("DD/MM/YYYY") : ' '), 170, 44)

                doc.text(this.ot.proyecto, 14, 58)
                doc.text(this.ot.numero.toString(), 150, 58)
                doc.text((this.fecha_hasta ? moment( this.fecha_hasta).format("DD/MM/YYYY") : ' '), 170, 58)

                /* linea amarilla */

                doc.setLineWidth(0.8);
                doc.setDrawColor(255,204,0);
                doc.line(11, 62, 200, 62);

            }
    },

    async downloadPdf_tab1 (){

        const doc = new jsPDF("p", "mm", "a4");
        doc.setFont("serif");

        var newCanvas = document.getElementById('img_rechazos');
        var imgData = newCanvas.toDataURL('image/png',1.0);
        doc.addImage(imgData,'PNG',60,75,90,90);

        doc.setFontSize(11);
        doc.text("Análisis de rechazos por Diámetro", 15, 171)

        doc.autoTable({
            startY: 173,
            body: this.TablaAnalisisRechazosDiametro,
            columns: [
                { header: 'Ø', dataKey: 'diametro' },
                { header: 'Aprobados', dataKey: 'aprobados' },
                { header: 'Rechazados', dataKey: 'rechazados' },
                { header: 'Total', dataKey: 'total' },
                { header: '%', dataKey: 'porcentaje_rechazados' },
            ],
            margin: { top: 70 },
            })

       doc.text("Análisis de rechazos por Espesor", 15,doc.lastAutoTable.finalY + 14)
        doc.autoTable({
            startY: doc.lastAutoTable.finalY + 16,
            body: this.TablaAnalisisRechazosEspesor,
            columns: [
                { header: '#', dataKey: 'espesor' },
                { header: 'Aprobados', dataKey: 'aprobados' },
                { header: 'Rechazados', dataKey: 'rechazados' },
                { header: 'Total', dataKey: 'total' },
                { header: '%', dataKey: 'porcentaje_rechazados' },
            ],
            margin: { top: 70 },
            })

            this.prepareHeaderPdf(doc);

        doc.save("Indices_de_rechazos.pdf")

    },

     async downloadPdf_tab2 (){

        const doc = new jsPDF("p", "mm", "a4");
        doc.setFont("serif");

        doc.setFontSize(11);
        doc.text("Defectos", 15, 72)

        doc.autoTable({
            startY:74,
            body: this.TablaDetalleDefectos,
            columns: [
                { header: 'Abrev.', dataKey: 'abreviatura' },
                { header: 'Descripción', dataKey: 'descripcion' },
                { header: 'Cantidad', dataKey: 'cantidad' },
                { header: '%', dataKey: 'porcentaje' },
            ],
            margin: { top: 70 },
            })

        doc.text("Diámetro: "  + this.DiametroDefecto, 14,doc.lastAutoTable.finalY + 14)

        var newCanvas = document.getElementById('img_defectologia');
        var imgData = newCanvas.toDataURL('image/png',1.0)
        doc.addImage(imgData,'PNG',60,doc.lastAutoTable.finalY + 25,90,90)

        this.prepareHeaderPdf(doc);

        doc.save("defectologia.pdf")

    },

    async downloadPdf_tab3(){

        const doc = new jsPDF("p", "mm", "a4");
        doc.setFont("serif");

        doc.setFontSize(11);
        doc.text("Defectos por soldador", 15, 72)

        doc.autoTable({
            startY:74,
            body: this.TablaDefectosSoldador,
            columns: [
                { header: 'Cuño.', dataKey: 'soldador_codigo_nombre' },
                { header: 'Cord.', dataKey: 'cordones' },
                { header: 'Cantidad', dataKey: 'cantidad' },
                { header: '%', dataKey: 'porcentaje' },
            ],
            margin: { top: 70 },
            })

       var newCanvas = document.getElementById('img_defectologia_produccion');
       var imgData = newCanvas.toDataURL('image/png',1.0)
       doc.addImage(imgData,'PNG',20,doc.lastAutoTable.finalY + 15,170,80)

       this.prepareHeaderPdf(doc);

       doc.save("defectologia.pdf")

    },

    async downloadPdf_tab4 (){

        const doc = new jsPDF("p", "mm", "a4");
        doc.setFont("serif");

        doc.setFontSize(11);
        doc.text("Indicaciones", 15, 72)

        doc.autoTable({
            startY:74,
            body: this.TablaIndicaciones,
            columns: [
                { header: 'Abrev.', dataKey: 'defecto_codigo' },
                { header: 'Descripción', dataKey: 'defecto_descripcion' },
                { header: 'Cantidad', dataKey: 'cantidad' },
                { header: '%', dataKey: 'porcentaje' },
            ],
            margin: { top: 70 },
            })

        doc.text("Diámetro: "  + this.DiametroIndicaciones, 15,doc.lastAutoTable.finalY + 14)

        var newCanvas = document.getElementById('img_indicaciones');
        var imgData = newCanvas.toDataURL('image/png',1.0)
        doc.addImage(imgData,'PNG',60,doc.lastAutoTable.finalY + 25,90,90)

        doc.text("Total Indicaciones: "  + this.total_indiciones, 15,doc.lastAutoTable.finalY + 120)

        this.prepareHeaderPdf(doc);

        doc.save("indicaciones.pdf")

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
