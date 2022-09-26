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
                                                    <tr>
                                                        <th style="text-align:center" colspan="4">Total</th>
                                                        <td style="text-align:center" >{{valorMetodoTotal[0]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[1]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[2]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[3]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[4]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[5]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[6]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[7]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[8]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[9]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[10]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[11]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[12]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[13]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[14]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[15]}}</td>
                                                        <td style="text-align:center" >{{valorMetodoTotal[16]}}</td>
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
                                                    </tr>
                                                    <tr v-for="(item,k) in tablaPlacas.data" :key="k">
                                                        <th> {{item.fecha}} </th>
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
            tablaPlacas:{},

            /* Tabla CERTIFICADOS */
            tablaCertificados:{},

            valorMetodoTotal:{},
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
                await this.getTablaPlacas()
                await this.getTotales()
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
        async getTablaPlacas(page = 1) {
            this.tablaPlacas = {};
            try {
                let url = "reporte-placas-medidas" + "/cliente/" + (this.cliente ? this.cliente.id : "null") + "/ot/" + (this.ot ? this.ot.id : "null") + "/fecha_desde/" + this.fecha_desde + "/fecha_hasta/" + this.fecha_hasta + "?page=" + page + "&api_token=" + Laravel.user.api_token;
                let res = await axios.get(url);
                this.tablaPlacas = res.data;
                console.log(this.tablaPlacas)
            } catch (error) {
            } finally {
                this.$store.commit("loading", false);
            }
        },
        async getTotales(){
            var ri_m = 0;
            var lp_m = 0;
            var pm_m = 0;
            var us_m = 0;
            var pmi_m = 0;
            var rg_m = 0;
            var cv_m = 0;
            var dz_m = 0;
            var tt_m = 0;
            var rd_m = 0;
            var ci_m = 0;
            var iv_m = 0;
            var ph_m = 0;
            var gral_m = 0;
            var rm_m = 0;
            var vs_m = 0;
            var og_m = 0;
            this.tablaCertificados.data.forEach((item) =>{
                ri_m = ri_m + item.RI;
                lp_m = lp_m + item.LP;
                pm_m = pm_m + item.PM;
                us_m = us_m + item.US;
                pmi_m = pmi_m + item.PMI;
                rg_m = rg_m + item.RG;
                cv_m = cv_m + item.CV;
                dz_m = dz_m + item.DZ;
                tt_m = tt_m + item.TT;
                rd_m = rd_m + item.RD;
                ci_m = ci_m + item.CI;
                iv_m = iv_m + item.IV;
                ph_m = ph_m + item.PH;
                gral_m = gral_m + item.GRAL;
                rm_m = rm_m + item.RM;
                vs_m = vs_m + item.VS;
                og_m = og_m + item.OG;
            })
             var valorMTotal = [ri_m, lp_m, pm_m, us_m, pmi_m, rg_m, cv_m, dz_m, tt_m, rd_m, ci_m, iv_m, ph_m, gral_m, rm_m, vs_m, og_m]
             this.valorMetodoTotal = valorMTotal
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
    .total{
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }
</style>
