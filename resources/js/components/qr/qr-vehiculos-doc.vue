<template>
    <div>
        <div class="container-fluid" v-show="!isLoading">
            <template v-if="documentaciones.length" class="vcenter">
            <h5 style="margin-top:20px"><strong>N° Int {{vehiculo.nro_interno}} / Patente {{vehiculo.patente}} </strong></h5>
                <ul>
                    <li v-for="item in documentaciones" :key="item.id" style="margin-top:15px; margin">

                        <a :href="'/' + item.path " target="_blank" title="documentación"> {{ item.titulo }} / {{ item.descripcion }}</a>

                    </li>
                </ul>
            </template>
            <template v-else>
                <h5>No se encontro documentacion para el vehiculo </h5>
            </template>
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
      vehiculo_id: {
            type: Number,
            required : true,
            default : 0
        },
    },
    data () { return {

        documentaciones:[],
        vehiculo:[],
    }},

    mounted () {
        this.getDocumentaciones();
        this.getVehiculo();
    },
    computed :{

        ...mapState(['isLoading','url']),

     },

     methods: {
        async getVehiculo () {
            console.log('llega')
            this.$store.commit('loading', true);
            this.vehiculo = [];
            var urlRegistros = 'vehiculo/id/' + this.vehiculo_id + '/' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
               this.vehiculo = response.data
               console.log('data',response)
               this.$store.commit('loading', false)
            }).catch(function (error) {
                console.log(error.toJSON());
                this.$store.commit('loading', false)
            });
        },
        async getDocumentaciones () {
            this.$store.commit('loading', true);
            this.documentaciones = [];
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'documentaciones/vehiculos/' + this.vehiculo_id + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
               this.documentaciones = response.data
               console.log('data',response)
               this.$store.commit('loading', false)
            }).catch(function (error) {
                console.log(error.toJSON());
                this.$store.commit('loading', false)
            });
        }
    }
}
</script>

<style scoped>
.vcenter {
    display: inline-block;
    vertical-align: middle;
    float: none;
}

</style>
