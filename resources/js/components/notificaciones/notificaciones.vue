<template>
    <div class="row">
        <div v-if="notificaciones.length || isLoading">
             <div class="col-md-12">
                <div class="box box-custom-enod">
                     <div class="box-header with-border">


                            <div class="form-gruop" style="float:left;margin-left:20px;">
                                <div class="btn-group">
                                    <a type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v" style="color: gray;"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" @click="BorrarTodos()"><span class="fa fa-trash"></span> Borrar todos</a></li>
                                        <li><a href="#" @click="MarcarTodos()"><span class="fas fa-check-circle"></span> Marcar todos como leídos</a></li>
                                        <li><a href="#" @click="DesmarcarTodos()"><span class="far fa-check-circle"></span> Desmarcar todos como leídos</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group">
                                      <a class="form-group"><span class="text-titulo" style="margin-left: 12px;">Notificaciones</span> </a>
                                </div>
                            </div>



                        </div>
                    <div class="box-body">

                        <ul class="timeline">

                            <li v-for="(item,k) in notificaciones" :key="k" >

                                <i class="fa fa-bell-o bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> {{  fecha_formateada(item.fecha) }} </span>

                                        <h3 v-if="item.documentacion" class="timeline-header" ><a href="#">Vencimiento documentación de {{ item.documentacion.tipo }}</a></h3>
                                        <h3 v-if="!item.documentacion" class="timeline-header" ><a href="#">Aviso demora en carga de dosimetría</a></h3>
                                        <div class="timeline-body"  :class="{marcado:item.notificado_sn}">
                                            {{item.descripcion}}
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-xs"  @click="MarcarDesmarcar(k)">
                                             <span  v-if="!item.notificado_sn">Marcar leído</span>
                                             <span v-else>Desmarcar leído</span>
                                            </a>
                                            <a class="btn btn-danger btn-xs" @click="Borrar(k)">Borrar</a>
                                        </div>
                                    </div>
                                </li>

                            <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                         </ul>
                    </div>
                </div>
             </div>
        </div>
        <div v-else>
            <div class="col-md-12 abs-center">
                <h4 class="text-center text-mensaje">No tienes notificaciones</h4>
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

    created : function(){

        this.getNotificaciones();

    },

    mounted : function(){


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

    async MarcarDesmarcar(index){

            console.log("antes de marcar/desmarcar",this.isLoading);
            this.$store.commit('loading', true);
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'notificaciones/marcar/' + this.notificaciones[index].id + '?api_token=' + Laravel.user.api_token;
            await axios.put(urlRegistros).then(response => {

             this.notificaciones[index].notificado_sn = !this.notificaciones[index].notificado_sn;
             this.ActualizarNotificaciones();
              console.log("cuando marco",this.isLoading);


            });
            this.$store.commit('loading', false);
            console.log("despues de marcar/desmarcar",this.isLoading);

       },

    async Borrar(index){

        this.$store.commit('loading', true);
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'notificaciones/' + this.notificaciones[index].id + '?api_token=' + Laravel.user.api_token;
        await axios.delete(urlRegistros).then(response => {


           this.getNotificaciones();

        });
        this.$store.commit('loading', false);
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

        });
    },

    async ActualizarNotificaciones(){

        let total_notificacion = this.notificaciones.filter(function(elem){return elem.notificado_sn == 0 }).length;
        $(".notificacion_total").html(parseInt(total_notificacion));
        this.ActualizarNotificacionesResumen();

    },

     async MarcarTodos(){

          await this.notificaciones.forEach(function(item,index){

                if (!item.notificado_sn) {

                    this.MarcarDesmarcar(index);

                }

            }.bind(this))

    },

    async DesmarcarTodos(){

        await this.notificaciones.forEach(function(item,index){

                if (item.notificado_sn) {

                   this.MarcarDesmarcar(index);

                }

            }.bind(this))

    },

    BorrarTodos(){

        this.notificaciones.forEach(function(item,index){

                this.Borrar(index);

        }.bind(this))

    }

}}

</script>

<style scoped>

    .marcado{

        color:#BBBABA;

    }

    .text-titulo {

            font-family: 'Montserrat',sans-serif;
            font-weight: 400 !important;
            color:#6E6A6A ;
            font-size: 18px;
            font-style: oblique;
        }




</style>
