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
                           <v-select v-show="selOt" v-model="ot" label="numero" :options="ots" @input="CambioOt" ></v-select>
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
                           <div v-show="!selComponenteSeleccionado">
                           <span class="titulo-li">Componente</span>
                           <a @click="CambioComponente(); getComponentes();" class="pull-right">
                               <div v-if="componenteSeleccionado">{{componenteSeleccionado.componenteSeleccionado}}</div>
                               <div v-else><span class="seleccionar">Seleccionar</span></div>
                           </a>
                           </div>
                           <v-select v-show="selComponenteSeleccionado" v-model="componenteSeleccionado" label="componente" :options="componentesSeleccionado" @input="CambioComponente()"></v-select>
                       </li>
                       <li class="list-group-item pointer">
                            <input type="text"  v-model="plano" class="form-control" id="plano" placeholder="Plano Isométrico" maxlength="20">
                       </li>
                       <li class="list-group-item pointer">
                            <input type="text"  v-model="elemento" class="form-control" id="elemento" placeholder="Elemento" maxlength="10">
                       </li>
                   </ul>

                   <a  @click="Buscar()">
                       <button class="btn btn-enod  btn-block" :disabled="!ot "><span class="fa fa-search"></span>
                           Buscar
                       </button>
                   </a>

               </div>
           </div>
       </div>

       <div class="col-md-9">
           <tabs :options="{ useUrlFragment: false }" @clicked="tabClicked" @changed="tabChanged">
               <tab name="Elementos/Plano Isom">
                   <div class="row">
                       <div class="col-lg-12">
                           <div  v-if="(TablaElementos.data && TablaElementos.data.length)">
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
                                               <th class="col-md-2">Informe Nº	</th>
                                               <th class="col-md-1">Elemento</th>
                                               <th class="col-md-2">Línea</th>
                                               <th class="col-md-2">Detalle</th>
                                               <th class="col-md-1">CM</th>
                                               <th class="col-md-3">Plano Isométrico</th>
                                               <th class="col-md-1" style="text-align:center">Acept.</th>
                                           </tr>
                                           <tr v-for="(item,k) in TablaElementos.data" :key="k">
                                               <td>{{ item.fecha_formateada }}</td>
                                               <td>
                                                   <a :href="'/informes/ot/' + item.ot_id " target="_blank" title="Informe"><span>{{ item.nro_informe_formateado }}</span></a>
                                               </td>
                                               <td>{{ item.pieza }}</td>
                                               <td>{{ item.linea }}</td>
                                               <td>{{ item.detalle }}</td>
                                               <td>{{ item.cm }}</td>
                                               <td  v-if="item.hoja"><a href="" rel="tooltip" :title="' Hoja: '+ item.hoja">{{ item.plano_isom }}</a></td>
                                               <td v-else>{{ item.plano_isom }}</td>
                                               <td style="text-align:center">
                                                   <div v-if="item.aceptable_sn">
                                                       SI
                                                   </div>
                                                   <div v-else>
                                                       NO
                                                   </div>

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
                       </div>
                   </div>
               </tab>
           </tabs>
               <pagination :data="TablaElementos" @pagination-change-page="Buscar" :limit="3"><span slot="prev-nav">&lt; Previous</span>
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
import {mapState} from 'vuex';
import Loading from 'vue-loading-overlay';
import Tabs from 'vue-tabs-component';
import Vuetable from 'vuetable-2'

export default {

   components: {
     Loading,
     Vuetable
   },

   props: {

     user : {
       type : Object,
       required : true,
     },
     ot_prop : {
       type : Object,
     },
   },
   data() { return {
           cliente:'',
           ots:[],
           ot:'',
           obras:[],
           obra:'',
           componente:'',
           soldador : '',
           selCliente:false,
           selOt:false,
           selObra:false,
           selComponente:false,
           soldadores:[],
           elemento:'',
           plano:'',
           TablaElementos:{},
           componentesSeleccionado: [],
           componenteSeleccionado: '',
           selComponenteSeleccionado: false,
       }
   },

  async mounted() {
       await this.$store.dispatch('loadClientesOperador', this.user.id);
       if(this.ot_prop){
           let index = this.clientesOperador.findIndex(e => e.id == this.ot_prop.cliente.id);
           this.cliente = this.clientesOperador[index]
           await this.CambioCliente();
           this.selCliente = !this.selCliente;
           console.log(this.ots)
           let indexOt = this.ots.findIndex(e => e.id == this.ot_prop.id);
           console.log(indexOt)
           this.ot = this.ots[indexOt]
           this.CambioOt();
           this.selOt = !this.selOt;
       }
       console.log(this.cliente)
   },

  computed :{

   ...mapState(['isLoading','clientesOperador','url']),

 },

methods : {

   async Buscar(page = 1) {
   this.$store.commit('loading', true);
   this.TablaElementos = {};

   try {
       let url = 'elementos/ot/' + this.ot.id + '/plano/' + (this.plano ? this.plano.replace('/','--') : 'null') + '/elemento/' + (this.elemento ? this.elemento.replace('/','--') : 'null') + '/obra/' + (this.obra !='' ? this.obra.obra.replace('/','--') : 'null') + '/componente/' + (this.componenteSeleccionado && this.componenteSeleccionado.componente ? this.componenteSeleccionado.componente.replace('/','--'): 'null') + '?page=' + page + '&api_token=' + Laravel.user.api_token;
       let res = await axios.get(url);
       this.TablaElementos = res.data;
       
   } catch (error) {
       // Manejo de errores
   } finally {
       this.$store.commit('loading', false);
   }
},
   clienteProp: async function () {

   },
   async CambioCliente (){
       this.selCliente = !this.selCliente;
       this.ot = '';
       this.soldador = '';
       this.selOt =false;
       this.obra = '';
       this.selObra =false;
       this.obras=[]
       this.selComponente = false;
       this.TablaElementos = {};

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

   CambioOt: async function(){
       this.selOt = !this.selOt;
       this.obra = '';
       this.selObra = false;

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
       this.soldadores = [];
       let url = 'ot_soldadores/ot/' + this.ot.id + '?api_token=' + Laravel.user.api_token;
       let res = await axios.get(url);
       this.soldadores = res.data;
   },

   async seleccionarObra() {
   if (this.ot && !this.ot.obra) {
       this.selObra = !this.selObra;
   }
   // Llama a getComponentes solo si obra está definido
   if (this.obra && this.obra.obra) {
       await this.getComponentes();
   }
},
   async getComponentes() {
       this.$store.commit('loading', true);

       var urlRegistros = 'ots/' + this.ot.id + '/obra/' + this.obra.obra.replace('/','--') + '/componentes/' +'?api_token=' + Laravel.user.api_token;
       try {
           const res = await axios.get(urlRegistros);
           this.componentesSeleccionado = res.data;
           console.log(this.componentesSeleccionado);
       } catch (error) {
           // Manejo de errores
       } finally {
           this.$store.commit('loading', false);
       }
   },
   CambioComponente() {
     this.selComponenteSeleccionado = !this.selComponenteSeleccionado;
   },
   async CambioObra (){
       this.obra = this.obra == null ? '' : this.obra;
       this.selObra = !this.selObra;
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


</style>
