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
                            <v-select v-show="selOt" v-model="ot" label="numero" :options="ots" ></v-select>
                        </li>
                        <li class="list-group-item pointer">
                             <input type="number"  v-model="pk" class="form-control" id="plano" placeholder="PK">
                        </li>
                        <li class="list-group-item pointer">
                             <input type="text"  v-model="plano" class="form-control" id="plano" placeholder="Plano Isométrico" maxlength="10">
                        </li>
                        <li class="list-group-item pointer">
                             <input type="text"  v-model="plano" class="form-control" id="costura" placeholder="Costura" maxlength="10">
                        </li>
                        <li class="list-group-item pointer">

                                <label>
                                <input type="checkbox" v-model="rechazados_a_la_fecha">
                                 <span style="margin-left:20px">Rechazados a la fecha</span>
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

export default {

    components: {
      Loading,
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
            pk : '',
            plano:'',
            rechazados_a_la_fecha:false,
            reparaciones:false,
            selCliente:false,
            selOt:false,
            selObra:false,
        }
    },

   mounted() {

       this.$store.dispatch('loadClientesOperador',this.user.id);

   },

   computed :{

    ...mapState(['isLoading','clientesOperador','url']),

  },

methods : {

    async CambioCliente (){

        this.selCliente = !this.selCliente;
        this.ot = '';
        this.selOt =false;
        this.obra = '';
        this.selObra =false;
      //  this.resetVariables();
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
}
}
</script>
