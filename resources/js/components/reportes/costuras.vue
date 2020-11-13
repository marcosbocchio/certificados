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
                             <input type="number"  v-model="pk" class="form-control" id="plano" placeholder="PK">
                        </li>
                        <li class="list-group-item pointer">
                             <input type="text"  v-model="plano" class="form-control" id="plano" placeholder="Plano Isométrico" maxlength="20">
                        </li>
                        <li class="list-group-item pointer">
                             <input type="text"  v-model="costura" class="form-control" id="costura" placeholder="Costura" maxlength="10">
                        </li>
                        <li class="list-group-item pointer">

                                <label>
                                <input type="checkbox" v-model="rechazados">
                                 <span style="margin-left:20px">Rechazados</span>
                                 </label>

                        </li>
                        <li class="list-group-item pointer">
                             <label>
                                 <input type="checkbox" v-model="reparaciones">
                                 <span style="margin-left:20px">Reparaciones</span>
                            </label>
                        </li>

                    </ul>

                    <a  @click="Buscar()">
                        <button class="btn btn-enod  btn-block" :disabled="!ot "><span class="fa fa-plus-circle"></span>
                            Buscar
                        </button>
                    </a>

                </div>
            </div>
        </div>

        <div class="col-md-9">

            <tabs :options="{ useUrlFragment: false }" @clicked="tabClicked" @changed="tabChanged">
                <tab name="Costuras/Plano Isom">
                    <div class="row">
                        <div class="col-lg-12">
                            <div  v-if="(TablaCosturas.data && TablaCosturas.data.length)">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Detalle</h3>
                                </div>

                                <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-condensed">
                                        <tbody>
                                            <tr>
                                                <th class="col-md-2">Fecha</th>
                                                <th class="col-md-2">Informe Nº	</th>
                                                <th class="col-md-1">Km</th>
                                                <th class="col-md-1">Costura</th>
                                                <th class="col-md-4">Plano Isométrico</th>
                                                <th class="col-md-2" style="text-align:center">Aprob. S/N</th>
                                            </tr>
                                            <tr v-for="(item,k) in TablaCosturas.data" :key="k">
                                                <td>{{ item.fecha_formateada }}</td>
                                                <td>
                                                    <a :href="'/pdf/informe/' + item.informe_id " target="_blank" title="Informe"><span>{{ item.nro_informe_formateado }}</span></a>
                                                </td>
                                                <td>{{ item.km }}</td>
                                                <td>{{ item.codigo_junta }}</td>
                                                <td  v-if="item.linea || item.hoja"><a href="" rel="tooltip" :title="'Linea:' + (item.linea ? item.linea : '-') + ' /' +' Hoja:'+ (item.hoja ? item.hoja :'-')">{{ item.plano_isom }}</a></td>
                                                <td v-else>{{ item.plano_isom }}</td>
                                                <td style="text-align:center">
                                                    <div v-if="item.aprobado_sn">
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
                <pagination :data="TablaCosturas" @pagination-change-page="Buscar" ><span slot="prev-nav">&lt; Previous</span>
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

    },
    data() { return {
            cliente:'',
            ots:[],
            ot:'',
            pk : null,
            plano:null,
            costura:null,
            rechazados:false,
            reparaciones:false,
            selCliente:false,
            selOt:false,
            TablaCosturas:{},
        }
    },

   mounted() {

          this.$store.dispatch('loadClientesOperador',this.user.id).then(response => {
             if(this.clientesOperador.length == 1){
                 this.cliente = this.clientesOperador[0];
                 this.CambioCliente();
                 this.selCliente = !this.selCliente;
             }
         });

   },

   computed :{

    ...mapState(['isLoading','clientesOperador','url']),

  },

methods : {

    async Buscar(page = 1) {

     this.$store.commit('loading', true);
     this.TablaCosturas = {};

    try {
        let url = 'costuras/ot/' + this.ot.id  + '/pk/' + (this.pk ? this.pk : 'null' ) + '/plano/' + (this.plano ? this.plano : 'null') + '/costura/' + (this.costura ? this.costura : 'null') + '/rechazados/' + this.rechazados + '/reparaciones/' + this.reparaciones + '?page='+ page + '&api_token=' + Laravel.user.api_token;
        let res = await axios.get(url);
        this.TablaCosturas = res.data;

        console.log(page);
        console.log(this.TablaCosturas.data);
        console.log(this.TablaCosturas.data.length);

    }catch(error){

    }finally  {this.$store.commit('loading', false);}


    },

    async CambioCliente (){

        this.selCliente = !this.selCliente;
        this.ot = '';
        this.selOt =false;
        this.obra = '';
        this.selObra =false;
        this.TablaCosturas = {};

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

    CambioOt (){
        this.selOt = !this.selOt;
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
