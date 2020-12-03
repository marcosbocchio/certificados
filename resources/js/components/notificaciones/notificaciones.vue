<template>
    <div class="row">
        <div class="col-md-12">

            <ul class="timeline">

                <li v-for="(item,k) in notificaciones" :key="k" >

                        <i class="fa fa-bell-o bg-blue"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> {{  fecha_formateada(item.fecha) }} </span>

                            <h3 v-if="item.documentacion" class="timeline-header" ><a href="#">Vencimiento documentación de {{ item.documentacion.tipo }}</a></h3>

                            <div class="timeline-body"  :class="{marcado:item.notificado_sn}">
                                {{item.descripcion}}
                            </div>
                            <div class="timeline-footer">
                                <a class="btn btn-primary btn-xs"  @click="Marcar(k)">Marcar leído</a>
                                <a class="btn btn-danger btn-xs" @click="borrar(k)">Borrar</a>
                            </div>
                        </div>

                </li>

                <li>

                    <i class="fa fa-clock-o bg-gray"></i>

                </li>
            </ul>
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

       notificaciones:[],

        }

    },

   props :{

       user_data : {
       type : Object,
       required : true
       }

     },
  computed :{

       ...mapState(['url','isLoading']),

     },

    mounted : function(){

        this.getNotificaciones();

    },

    methods : {

     fecha_formateada: function(fecha) {

         return  moment(fecha).format('DD/MM/YYYY')
     },

    async getNotificaciones(){

       this.$store.commit('loading', true);
       axios.defaults.baseURL = this.url ;
       var urlRegistros = 'notificaciones/user/' + this.user_data.id + '?api_token=' + Laravel.user.api_token;
       await axios.get(urlRegistros).then(response =>{

            this.notificaciones = response.data;
            this.ActualizarNotificaciones();

       }).finally(()=> {this.$store.commit('loading', false);});
    },

    async Marcar(index){

        if(this.notificaciones[index].notificado_sn == 0){

            this.$store.commit('loading', true);
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'notificaciones/marcar/' + this.notificaciones[index].id + '?api_token=' + Laravel.user.api_token;
            await axios.put(urlRegistros).then(response => {

             this.notificaciones[index].notificado_sn = 1;
             this.ActualizarNotificaciones();


            }).finally(()=> {this.$store.commit('loading', false);});

           }
       },

    async borrar(index){

        this.$store.commit('loading', true);
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'notificaciones/' + this.notificaciones[index].id + '?api_token=' + Laravel.user.api_token;
        await axios.delete(urlRegistros).then(response => {

           this.getNotificaciones();

        }).finally(()=> {this.$store.commit('loading', false);});

    },

   async ActualizarNotificacionesResumen(){

        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'notificaciones_resumen/user/' + this.user_data.id + '?api_token=' + Laravel.user.api_token;
        await axios.get(urlRegistros).then(response =>{

           let notificaciones_resumen = response.data;
           let html_temp='';
           notificaciones_resumen.forEach(function(item){
               html_temp  += '<li><a href="#"><i class="fa fa-bell-o text-red"></i><span>' + item.total + '</span> notificaciones de <span>' + item.tipo + '</span></a></li>' ;
           });
           document.getElementById('menu-notificaciones').innerHTML=html_temp;
        //   console.log(html_temp);

        });
    },

    async ActualizarNotificaciones(){

        let total_notificacion = this.notificaciones.filter(function(elem){return elem.notificado_sn == 0 }).length;
        $(".notificacion_total").html(parseInt(total_notificacion));
        this.ActualizarNotificacionesResumen();

    },


}}
</script>

<style scoped>

    .marcado{

        color:#BBBABA;

    }
</style>
