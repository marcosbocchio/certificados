<template>
    <div class="container-fluid">
            <template v-if="documentaciones.length" class="vcenter">
                <h4>Int N {{documentaciones[0].nro_interno}}</h4>
                <ul>
                    <li v-for="item in documentaciones" :key="item.id" style="margin-top:15px; margin">
        
                        <a :href="'/' + item.path " target="_blank"> {{ item.titulo }} / {{ item.descripcion }}</a>
                        
                    </li>   
                </ul>
            </template>
            <template v-else>
                <h5>No se encontro documentacion para el equipo </h5>               
            </template>

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
            await axios.get(urlRegistros)
            .then(response =>{
               this.documentaciones = response.data
               console.log('data',response)
            }).finally(this.$store.commit('loading', false));            
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