<template>
    <div class="row">
        <div class="col-md-3">
            <div class="box box-custom-enod">
                <div class="box-body box-profile">
                    <div v-if="cliente && cliente.path" style="text-align:center">
                        <img :src="'/' + cliente.path" alt="..." width="120" />
                    </div>
                    <h4 v-if="cliente" class="profile-username text-center">
                        {{ cliente.nombre_fantasia }}
                    </h4>

                    <p v-if="ot" class="text-muted text-center">
                        {{ ot.proyecto }}
                    </p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item pointer">
                            <div v-show="!selCliente">
                                <span class="titulo-li">Cliente</span>
                                <a @click="selCliente = !selCliente" class="pull-right">
                                    <div v-if="cliente">
                                        {{ cliente.nombre_fantasia }}
                                    </div>
                                    <div v-else>
                                        <span class="seleccionar">Seleccionar</span>
                                    </div>
                                </a>
                            </div>
                            <v-select
                                v-show="selCliente"
                                v-model="cliente"
                                label="nombre_fantasia"
                                :options="clientesOperador"
                                @input="CambioCliente()"></v-select>
                        </li>
                        <li class="list-group-item pointer">
                            <div v-show="!selOt">
                                <span class="titulo-li">OT</span>
                                <a @click="selOt = !selOt" class="pull-right">
                                    <div v-if="ot">{{ ot.numero }}</div>
                                    <div v-else>
                                        <span class="seleccionar">Seleccionar</span>
                                    </div>
                                </a>
                            </div>
                            <v-select
                                v-show="selOt"
                                v-model="ot"
                                label="numero"
                                :options="ots"
                                @input="CambioOt()"></v-select>
                        </li>
                        <li class="list-fecha list-group-item pointer">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <date-picker
                                        v-model="fecha_desde"
                                        value-type="YYYY-MM-DD"
                                        format="DD-MM-YYYY"
                                        placeholder="Desde"></date-picker>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <date-picker
                                        v-model="fecha_hasta"
                                        value-type="YYYY-MM-DD"
                                        format="DD-MM-YYYY"
                                        placeholder="Hasta"></date-picker>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <a @click="Buscar()">
                        <button class="btn btn-enod  btn-block">
                            <span class="fa fa-plus-circle"></span>
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
                            <div v-if="(tablaCertificados.data && tablaCertificados.data.length)">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Detalle</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-condensed tabla">
                                                <tbody>
                                                    <tr >
                                                        <th style="text-aling:center" class=" col-md-1">Fecha</th>
                                                        <th style="text-align:center"  class=" col-md-2">Cliente</th>
                                                        <th style="text-align:center"  class="col-md-1">Ot</th>
                                                        <th style="text-align:center"  class=" col-md-1">Certificado</th>
                                                        <th style="text-align:center">RI</th>
                                                        <th style="text-align:center">LP</th>
                                                        <th style="text-align:center">PM</th>
                                                        <th style="text-align:center">US</th>
                                                        <th style="text-align:center">PMI</th>
                                                        <th style="text-align:center">RG</th>
                                                        <th style="text-align:center">CV</th>
                                                        <th style="text-align:center">DZ</th>
                                                        <th style="text-align:center">TT</th>
                                                        <th style="text-align:center">RD</th>
                                                        <th style="text-align:center">CI</th>
                                                        <th style="text-align:center">IV</th>
                                                        <th style="text-align:center">PH</th>
                                                        <th style="text-align:center">GRAL</th>
                                                        <th style="text-align:center">RM</th>
                                                        <th style="text-align:center">VS</th>
                                                        <th style="text-align:center">OG</th>
                                                    </tr>    
                                                    <tr v-for="(item,k) in tablaCertificados.data" :key="k">
                                                        <td>{{ dateFormat(item.fecha) }}</td>
                                                        <td style="text-align:center">{{ item.cliente }}</td>
                                                        <td style="text-align:center">{{ item.nro_ot }}</td>
                                                        <td style="text-align:center">
                                                        <a :href="'/pdf/certificado/' + item.certificado_id + '/final' " target="_blank" title="Informe"><span>{{ formatearCertificado(item.certificado) }}</span></a></td>
                                                        <td style="text-align:center">{{ item.RI }}</td>
                                                        <td style="text-align:center">{{ item.LP }}</td>
                                                        <td style="text-align:center">{{ item.PM }}</td>
                                                        <td style="text-align:center">{{ item.US }}</td>
                                                        <td style="text-align:center">{{ item.PMI }}
                                                        </td><td style="text-align:center">{{ item.RG }}</td>
                                                        <td style="text-align:center">{{ item.CV }}</td>
                                                        <td style="text-align:center">{{ item.DZ }}</td>
                                                        <td style="text-align:center">{{ item.TT }}</td>
                                                        <td style="text-align:center">{{ item.RD }}</td>
                                                        <td style="text-align:center">{{ item.CI }}</td>
                                                        <td style="text-align:center">{{ item.IV }}</td>
                                                        <td style="text-align:center">{{ item.PH }}</td>
                                                        <td style="text-align:center">{{ item.GRAL }}</td>
                                                        <td style="text-align:center">{{ item.RM }}</td>
                                                        <td style="text-align:center">{{ item.VS }}</td>
                                                        <td style="text-align:center">{{ item.OG }}</td>
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
                <tab name="Placas">
                    <div class="row">
                        <div class="col-lg-12">
                            <div v-if="1">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Detalle</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-condensed tabla">
                                                <tbody>
                                                    <tr>
                                                        <th style="text-aling:center" class="col-md-1 medidas_tabla_placas">Fecha</th>
                                                        <th style="text-align:center"  class="col-md-2  medidas_tabla_placas">Cliente</th>
                                                        <th style="text-align:center"  class="col-md-1  medidas_tabla_placas">Ot</th>
                                                        <th style="text-align:center"  class="col-md-1  medidas_tabla_placas">Certificado</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">7 x 21</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">7 x 29</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">7 x 35</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">7 x 43</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">7 x 53</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">7 x 68</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">9 x 21</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">9 x 29</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">9 x 43</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">9 x 48</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">17 x 43</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">35 x 43</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">1/2 "</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">04"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">06" a 08"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">3/4"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">1"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">2"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">3"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">4"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">6"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">8"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">10"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">12"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">14"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">16"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">10" a 14"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">10" a 16"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">18"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">20"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">16" a 20"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">24"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">21" a 2"4</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">28"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">30"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">32"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">36"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">42"</th>
                                                        <th style="text-align:center" class="medidas_tabla_placas">73"</th>
                                                    </tr>
                                                    <tr v-for="(item,k) in tablaPlacas" :key="k">
                                                        <td style="text-aling:center">{{item.fecha}}</td>
                                                        <td style="text-align:center">{{item.cliente}}</td>
                                                        <td style="text-align:center">{{item.OT}}</td>
                                                        <td style="text-align:center">{{item.certificado}}</td>
                                                        <td style="text-align:center">{{item.cm7x21}}</td>
                                                        <td style="text-align:center">{{item.cm7x29}}</td>
                                                        <td style="text-align:center">{{item.cm7x35}}</td>
                                                        <td style="text-align:center">{{item.cm7x43}}</td>
                                                        <td style="text-align:center">{{item.cm7x53}}</td>
                                                        <td style="text-align:center">{{item.cm7x68}}</td>
                                                        <td style="text-align:center">{{item.cm9x21}}</td>
                                                        <td style="text-align:center">{{item.cm9x29}}</td>
                                                        <td style="text-align:center">{{item.cm9x43}}</td>
                                                        <td style="text-align:center">{{item.cm9x48}}</td>
                                                        <td style="text-align:center">{{item.cm17x43}}</td>
                                                        <td style="text-align:center">{{item.cm35x43}}</td>
                                                        <td style="text-align:center">{{item.pMedio}}</td>
                                                        <td style="text-align:center">{{item.p04}}</td>
                                                        <td style="text-align:center">{{item.p0608}}</td>
                                                        <td style="text-align:center">{{item.pTresCuartos}}</td>
                                                        <td style="text-align:center">{{item.p1}}</td>
                                                        <td style="text-align:center">{{item.p2}}</td>
                                                        <td style="text-align:center">{{item.p3}}</td>
                                                        <td style="text-align:center">{{item.p4}}</td>
                                                        <td style="text-align:center">{{item.p6}}</td>
                                                        <td style="text-align:center">{{item.p8}}</td>
                                                        <td style="text-align:center">{{item.p10}}</td>
                                                        <td style="text-align:center">{{item.p12}}</td>
                                                        <td style="text-align:center">{{item.p14}}</td>
                                                        <td style="text-align:center">{{item.p16}}</td>
                                                        <td style="text-align:center">{{item.p1014}}</td>
                                                        <td style="text-align:center">{{item.p1016}}</td>
                                                        <td style="text-align:center">{{item.p18}}</td>
                                                        <td style="text-align:center">{{item.p20}}</td>
                                                        <td style="text-align:center">{{item.p1620}}</td>
                                                        <td style="text-align:center">{{item.p24}}</td>
                                                        <td style="text-align:center">{{item.p2124}}</td>
                                                        <td style="text-align:center">{{item.p28}}</td>
                                                        <td style="text-align:center">{{item.p30}}</td>
                                                        <td style="text-align:center">{{item.p32}}</td>
                                                        <td style="text-align:center">{{item.p36}}</td>
                                                        <td style="text-align:center">{{item.p42}}</td>
                                                        <td style="text-align:center">{{item.p73}}</td>
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
            <pagination
                :data="tablaCertificados" @pagination-change-page="Buscar" :limit="3"><span slot="prev-nav">&lt; Previous</span><span slot="next-nav">Next &gt;</span>
            </pagination>
        </div>

        <loading :active.sync="isLoading" :loader="'bars'" :color="'red'">
        </loading>
    </div>
</template>

<script>
import moment from "moment";
import Datepicker from "vuejs-datepicker";
import { mapState } from "vuex";
import { en, es } from "vuejs-datepicker/dist/locale";
import Loading from "vue-loading-overlay";
import ChartJsPluginDataLabels from "chartjs-plugin-datalabels";
import DoughnutChart from "../chart.js/DoughnutChart.js";
import BarChart from "../chart.js/BarChart.js";
import PieChart from "../chart.js/PieChart.js";
import dayjs from "dayjs"
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
        user: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            en: en,
            es: es,
            cliente: "",
            filtrado: false,
            ots: [],
            ot: "",
            fecha_desde: null,
            fecha_hasta: null,
            selCliente: false,
            selOt: false,
            selObra: false,
            selComponente: false,
            fecha_actual: moment(new Date()).format('DD-MM-YYYY'),

            /* Tabla placas */
            tablaPlacas: [{
                fecha: '15/10/2022',
                cliente: 'VMC',
                OT: '2987',
                certificado: "00000021",
                cm7x21: '8',
                cm7x29: '0',
                cm7x35: '0',
                cm7x43: '12',
                cm7x53: '8',
                cm7x68: '0',
                cm9x21: '3',
                cm9x29: '0',
                cm9x43: '2',
                cm9x48: '0',
                cm17x43: '1',
                cm35x43: '1',
                pMedio: '0',
                p04: '0',
                p0608: '0',
                pTresCuartos: '0',
                p1: '0',
                p2:'0',
                p3:'0',
                p4:'0',
                p6:'0',
                p8: '7',
                p10:'0',
                p12: '9',
                p14: '0',
                p16:'0',
                p1014: '0',
                p1016:'0' ,
                p18:'0',
                p20: '5',
                p1620: '1',
                p24: '1',
                p2124: '3',
                p28: '0',
                p30: '0',
                p32: '0',
                p36: '0',
                p42: '0',
                p73: '2',
            }],

            /* Tabla CERTIFICADOS */
            tablaCertificados:{},
        };
    },

    mounted() {
        this.$store.dispatch("loadClientesOperador", this.user.id);
    },
 
    computed :{
        ...mapState(['isLoading','clientesOperador','url']),
        mostrar_tabla : function(){
            return (this.tablaCertificados.lenght) ? (this.tablaCertificados.data.lenght > 0 ? true : false) : false;
        },
    },

    methods: {
        async CambioCliente() {
            this.selCliente = !this.selCliente;
            this.ot = "";
            this.selOt = false;
            this.componente = "";
            this.selComponente = false;
            this.fecha_desde = null;
            this.fecha_hasta = null;
            if (this.cliente) {
                this.$store.commit("loading", true);
                var urlRegistros =
                    "clientes/" +
                    this.cliente.id +
                    "/ots/" +
                    "?api_token=" +
                    Laravel.user.api_token;
                try {
                    let res = await axios.get(urlRegistros);
                    this.ots = res.data;
                } catch (error) {
                } finally {
                    this.$store.commit("loading", false);
                }
            }
        },

        async CambioOt() {
            this.selOt = !this.selOt;
            this.componente = "";
            this.selComponente = false;
            this.$store.commit("loading", true);
            var urlRegistros =
                "ots/" +
                this.ot.id +
                "/obras/" +
                "?api_token=" +
                Laravel.user.api_token;
            try {
                let res = await axios.get(urlRegistros);
                this.obras = res.data;
            } catch (error) {
            } finally {
                this.$store.commit("loading", false);
            }

            if (this.ot.obra) {
                this.obra = { obra: this.ot.obra };
            }
        },

        async Buscar(page = 1) {
            this.$store.commit("loading", true);
            this.tablaCertificados = {};

            try {
                let url = "reporte-servicios" +
                 "/cliente/" +
                  (this.cliente ? this.cliente.id : "null") +
                   "/ot/" +
                    (this.ot ? this.ot.id : "null") + 
                    "/fecha_desde/" + this.fecha_desde +
                     "/fecha_hasta/" +
                      this.fecha_hasta +
                       "?page=" +
                        page +
                         "&api_token=" +
                          Laravel.user.api_token;
                let res = await axios.get(url);
                this.tablaCertificados = res.data;
            } catch (error) {
            } finally {
                this.$store.commit("loading", false);
            }
        },
         dateFormat(fecha){
            let fechaFormateda = dayjs(fecha).format('DD-MM-YYYY');
            return fechaFormateda
        },
        formatearCertificado(certificado){
            let certificadoFormateado = certificado.toString().padStart(8,'0');
            return certificadoFormateado
        },

    }
};
</script>
<style scoped>
    .tabla{
        min-width: max-content;
    }
    .medidas_tabla_placas{
        min-width: max-content;
        padding-left: 5px;
        padding-right: 5px;
    }
</style>
