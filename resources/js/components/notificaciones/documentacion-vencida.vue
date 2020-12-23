<template>
    <div class="row">
         <div class="col-md-12">
               <div class="box box-custom-enod top-buffer">
                   <div class="box-header with-border">
                        <h3 class="box-title">Documentaciones Vencidas</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                             <table class="table table-hover table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th class="col-md-2">tipo</th>
                                        <th class="col-md-2">Titulo</th>
                                        <th class="col-md-4">Descripción</th>
                                        <th class="col-md-2">Int Nº</th>
                                        <th class="col-md-2">Fecha Vencimiento</th>
                                    </tr>
                                </thead>
                                 <tr v-for="(item,k) in documentacion_vencida.data" :key="k">
                                    <td>{{ item.tipo }}</td>
                                    <td>{{ item.titulo }}</td>
                                    <td>{{ item.descripcion }}</td>
                                    <td>{{ item.Int_Nro }}</td>
                                    <td>{{ item.fecha_caducidad }}</td>
                                </tr>

                             </table>
                        </div>
                        <pagination :data="documentacion_vencida" @pagination-change-page="Buscar" :limit="3"><span slot="prev-nav">&lt; Previous</span>
                            <span slot="next-nav">Next &gt;</span> </pagination>
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
import moment from 'moment';
import 'moment/locale/es';
import Loading from 'vue-loading-overlay';
var mo = require('moment');

export default {

    components: {

       Loading

    },

   data() { return {

        documentacion_vencida:{},

        }

    },

    created : function(){

        this.Buscar();

    },

   computed :{

       ...mapState(['url','isLoading']),

     },

    methods : {


    async Buscar(page = 1){

       this.$store.commit('loading', true);
       axios.defaults.baseURL = this.url ;
       var urlRegistros = 'documentacion/vencida' + '?page='+ page + '&api_token=' + Laravel.user.api_token;
       await axios.get(urlRegistros).then(response =>{

            this.documentacion_vencida = response.data
            console.log(response.data)

       }).finally(()=> {this.$store.commit('loading', false);});
    },

    }
}
</script>
