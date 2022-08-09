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
                            <div v-show="!selComponente">
                                <span class="titulo-li">Componente</span>
                                <a @click="CambioComponente()" class="pull-right">
                                    <div v-if="componente">{{componente.componente}}</div>
                                    <div v-else><span class="seleccionar">Seleccionar</span></div>
                                </a>
                            </div>
                            <v-select v-show="selComponente" v-model="componente" label="componente" :options="componentes" @input="CambioComponente()"></v-select>
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
                            <div v-show="!selSoldador">
                                <span class="titulo-li">Soldador</span>
                                <a @click="selSoldador = !selSoldador" class="pull-right">
                                    <div v-if="soldador">{{soldador.codigo}}</div>
                                    <div v-else><span class="seleccionar">Seleccionar</span></div>
                                </a>
                            </div>
                             <v-select v-show="selSoldador" v-model="soldador" id="soldador" label="codigo" :options="soldadores" @input="CambioSoldador()"></v-select>
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
                                                <th class="col-md-1">Fecha</th>
                                                <th class="col-md-2">Informe Nº	</th>
                                                <th class="col-md-1">Costura</th>
                                                <th class="col-md-3">Línea</th>
                                                <th class="col-md-3">Plano Isométrico</th>
                                                <th class="col-md-1" style="text-align:center">Aprob.</th>
                                            </tr>
                                            <tr v-for="(item,k) in TablaCosturas.data" :key="k">
                                                <td>{{ item.fecha_formateada }}</td>
                                                <td>
                                                    <a :href="'/pdf/informe/' + item.informe_id " target="_blank" title="Informe"><span>{{ item.nro_informe_formateado }}</span></a>
                                                </td>
                                                <td>{{ item.codigo_junta }}</td>
                                                <td>{{ item.linea }}</td>
                                                <td  v-if="item.hoja"><a href="" rel="tooltip" :title="' Hoja: '+ item.hoja">{{ item.plano_isom }}</a></td>
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
                <pagination :data="TablaCosturas" @pagination-change-page="Buscar" :limit="3"><span slot="prev-nav">&lt; Previous</span>
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
            obras:[],
            obra:'',
            componentes: [],
            componente:'',
            pk : null,
            plano:null,
            soldador : '',
            costura:null,
            rechazados:false,
            reparaciones:false,
            selCliente:false,
            selOt:false,
            selObra:false,
            selComponente:false,
            selSoldador:false,
            soldadores:[],
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
        let url = 'costuras/ot/' + this.ot.id  + '/pk/' + (this.pk ? this.pk : 'null' ) + '/plano/' + (this.plano ? this.plano : 'null') + '/costura/' + (this.costura ? this.costura : 'null') + '/rechazados/' + this.rechazados + '/reparaciones/' + this.reparaciones + '/soldador/' + (this.soldador ? this.soldador.id : 0 ) + '/obra/' + (this.obra !='' ? this.obra.obra.replace('/','--') : 'null') + '/componente/' + (this.componente !='' ? this.componente.componente.replace('/','--') : 'null') + '?page='+ page + '&api_token=' + Laravel.user.api_token;
        let res = await axios.get(url);
        this.TablaCosturas = res.data;

    }catch(error){

    }finally  {this.$store.commit('loading', false);}


    },

    async CambioCliente (){

        this.selCliente = !this.selCliente;
        this.ot = '';
        this.soldador = '';
        this.selOt =false;
        this.obra = '';
        this.selObra =false;
        this.obras=[]
        this.componentes = []
        this.componente = '';
        this.selComponente = false;
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

    CambioOt: async function(){
        this.selOt = !this.selOt;
        this.obra = '';
        this.selObra = false;
        this.componente = '';
        this.selComponente = false;
        this.componentes = [];
        this.$store.commit('loading', true);
        var urlRegistros = 'ots/' + this.ot.id + '/obras/' +'?api_token=' + Laravel.user.api_token;
        try {
            let res = await axios.get(urlRegistros);
            this.obras = res.data;
        }catch(error){

        }finally  {this.$store.commit('loading', false);}

        if(this.ot.obra){
            this.obra = { obra : this.ot.obra}
            this.getComponentes();
        }
        this.soldadores = [];
        let url = 'ot_soldadores/ot/' + this.ot.id + '?api_token=' + Laravel.user.api_token;
        let res = await axios.get(url);
        this.soldadores = res.data;
    },

    async seleccionarObra(){

        this.componente = '';
        this.selComponente = false;
        if(this.ot && !this.ot.obra){
            this.selObra = !this.selObra;
        }
    },

    async CambioObra (){

        this.obra = this.obra == null ? '' : this.obra;
        this.selObra = !this.selObra;
        this.componente = '';
        this.getComponentes();

    },
    async getComponentes () {

        this.componente = '';
        this.$store.commit('loading', true);
        var urlRegistros = 'ots/' + this.ot.id + '/obra/' + this.obra.obra.replace('/','--') + '/componentes/' +'?api_token=' + Laravel.user.api_token;
        try {
            let res = await axios.get(urlRegistros);
            this.componentes = res.data;
        }catch(error){ }finally  {this.$store.commit('loading', false);}
    },

    CambioComponente() {
        this.selComponente = !this.selComponente;
    },

    CambioSoldador: function() {
        this.selSoldador = !this.selSoldador;
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
