
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
        fecha_desde:null,
        fecha_hasta:null,
        selCliente:false,
        selOt:false,
        selObra:false,
        informes : [],
        informes_ids :'',
        fecha_actual: moment(new Date()).format('DD-MM-YYYY'),

     }

    },
}

</script>
