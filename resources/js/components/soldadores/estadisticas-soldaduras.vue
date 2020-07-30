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
                            <div v-if="TablaAnalisisRechazos.length">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="div-grafico">
                                            <pie-chart :chart-data="data_indice_rechazos" :options="data_indice_rechazos.options" ></pie-chart>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="col-lg-12 titulo-tabla-tabs" >
                                            <h5>Análisis de rechazos por espesor</h5>
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
                                                    <tr v-for="(item,k) in TablaAnalisisRechazos" :key="k">
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
                            <div v-else>
                                <h4>No hay datos para mostrar</h4>
                            </div>
                        </tab>
                        <tab name="Defectología">
                            Defectología
                        </tab>
                        <tab name="Defectología/Producción">
                            Defectología/Producción
                        </tab>
                        <tab name="Indicaciones">
                            Indicaciones
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

        data_indice_rechazos : null,
        total_soldaduras_informes : 0,
        total_porcentaje_rechazados : 0,
        total_rechazos_soldaduras : 0,
        total_aprobados_soldaduras : 0,
        TablaAnalisisRechazos:[],
        valores_indice_rechazos : [],

     }

    },

 created: function () {

        this.getClienteOperador();

 },

   mounted() {

        this.generateIndicesRechazos();

  },

     computed :{

        ...mapState(['isLoading','url']),
       
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
    this.TablaAnalisisRechazos = [];
     this.selCliente = false;
     this.selOt = false;
     this.selObra = false;
     var urlRegistros = 'informes/ot/' + this.ot.id  + '/obra/' +  this.obra.obra.replace('/','--') + '/fecha_desde/' + this.fecha_desde + '/fecha_hasta/' + this.fecha_hasta + '?api_token=' + Laravel.user.api_token;      
     console.log(urlRegistros);
        try {
            let res = await axios.get(urlRegistros);
            this.informes = await res.data;
            this.valores_indice_rechazos= [];
            await this.getIndicesDeRechazos();
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
                this.ots = await res.data;      
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
            this.obras = await res.data;           
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

        this.TablaAnalisisRechazos = [];
        this.selObra = !this.selObra;

    },

    resetVariables(){

        this.informes = [];
        this.TablaAnalisisRechazos = [];

    },

    async getIndicesDeRechazos(){

        this.$store.commit('loading', true);
        let informes_ids = this.informes.map(item => item.id).toString();    
        var url = 'estadisticas-soldaduras/analisis_rechazos_espesor/' + informes_ids;
        var urlRegistros  = 'estadisticas-soldaduras/total_soldaduras_informes/' + informes_ids;  
        var urlRegistros2 = 'estadisticas-soldaduras/total_rechazos_soldaduras/' + informes_ids;  

        try {

            let res= await axios.get(url);
            this.TablaAnalisisRechazos = await res.data;  
            await this.calcularIndicesRechazosSoldaduras(this.TablaAnalisisRechazos);

        }catch(error){
           
        }finally  {this.$store.commit('loading', false);}

        
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

    tabClicked (selectedTab) {
          console.log('Current tab re-clicked:' + selectedTab.tab.name);
    },
    
    tabChanged (selectedTab) {
          console.log('Tab changed to:' + selectedTab.tab.name);
    },
 }
}
</script>


<style >

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

/*
  .style-chooser .vs__search::placeholder,
  .style-chooser .vs__dropdown-toggle,
  .style-chooser .vs__dropdown-menu {
    background: #dfe5fb;
    border: none;
    color: #394066;
    text-transform: lowercase;
    font-variant: small-caps;
  }

  .style-chooser .vs__clear,
  .style-chooser .vs__open-indicator {
    fill: #394066;
  }
*/
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

    font-weight: bold !important;
    color: #6B6B6B !important;
}

  .div-grafico {
    max-width:350px;
    
    margin:  0px auto 15px auto;
  }
</style>