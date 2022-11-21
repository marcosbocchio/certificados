<template>
    <div>
        <div class="container-fluid" v-show="!isLoading">
            <template v-if="documentaciones.length" class="vcenter">
                <h5 style="margin-top:20px"><strong>Equipo: N° Int {{documentaciones[0].nro_interno}} / N° Serie {{documentaciones[0].nro_serie}} </strong></h5>
                <ul>
                    <li v-for="item in documentaciones" :key="item.id" style="margin-top:15px; margin">
        
                        <a :href="'/' + item.path " target="_blank" title="documentación"> {{ item.titulo }} / {{ item.descripcion }}</a>
                        
                    </li>   
                </ul>
                <template v-if="documentacionesDuentes.length">
                    <h5 style="margin-top:20px"><strong>Fuente: N° Serie {{documentacionesFuentes[0].nro_serie}} </strong></h5>
                    <ul>
                        <li v-for="item in documentacionesFuentes" :key="item.id" style="margin-top:15px; margin">
            
                            <a :href="'/' + item.path " target="_blank" title="documentación"> {{ item.titulo }} / {{ item.descripcion }}</a>
                            
                        </li>   
                    </ul>    
                </template>
            </template>
            <template v-else>
                <h5>No se encontro documentacion para el equipo </h5>               
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
      interno_equipo_id: {
            type: Number,
            required : true,
            default : 0
        },
    },
    data () { return {

        documentaciones:[],
        documentacionesFuentes:[],

    }},

    mounted () {        
        this.getDocumentaciones();
    },
    computed :{

        ...mapState(['isLoading','url']),

     },

     methods: {

        async getDocumentaciones () {
            this.$store.commit('loading', true);
            this.documentaciones = [];
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'interno_equipos/' + this.interno_equipo_id + '/documentaciones/' + '?api_token=' + Laravel.user.api_token;
            var urlRegistros2 = 'interno_fuentes/' + this.interno_equipo_id + '/documentaciones/' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
               this.documentaciones = response.data
               console.log('data',response)
               this.$store.commit('loading', false)
            }).catch(function (error) {
                console.log(error.toJSON());
                this.$store.commit('loading', false)
            });    
            axios.get(urlRegistros2).then(response =>{
               this.documentacionesFuentes = response.data
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