<template>
  <div>

    <div class="row">
      <div class="col-md-10 col-md-offset-1">

       <div class="col-lg-3 col-xs-6">
         <a @click="EntrarCuadro('operadores')">
          <cuadro-enod
              :titulo = "'OPERADORES'"
              :class_color_titulo = "'color_3'"
              :class_color_sub_titulo = "'color_2'"
              :cantidad_1 ="CantOperadores"
              :src_icono ="'/img/tablero/icono-enod-operador.svg'"
              :class_color_cuadro = "'bg-custom-1'"
              :habilitado_sn =" $can('T_operador_acceder') ?  true : false"
              :class_footer_img ="'footer-oper-inf'"
          >
          </cuadro-enod>
         </a>
       </div>

       <div class="col-lg-3 col-xs-6">
         <a @click="EntrarCuadro('equipos')">
          <cuadro-enod
              :titulo = "'EQUIPOS'"
              :class_color_titulo = "'color_3'"
              :class_color_sub_titulo = "'color_2'"
              :cantidad_1 ="CantInternoEquipos"
              :src_icono ="'/img/tablero/icono-enod-equipos.svg'"
              :class_color_cuadro = "'bg-custom-2'"
              :habilitado_sn =" $can('T_equipos_acceder') ?  true : false"
              :class_footer_img ="'footer-equipos-partes'"

          >
          </cuadro-enod>
          </a>
       </div>

       <div class="col-lg-3 col-xs-6">
         <a @click="EntrarCuadro('procedimientos')">
          <cuadro-enod
              :titulo = "'PROCEDIMIENTOS'"
              :class_color_titulo = "'color_2'"
              :class_color_sub_titulo = "'color_1'"
              :cantidad_1 ="CantProcedimientos"
              :src_icono ="'/img/tablero/icono-enod-procedimientos.svg'"
              :class_color_cuadro = "'bg-custom-3'"
              :habilitado_sn =" $can('T_proc_acceder') ?  true : false"
              :class_footer_img ="'footer-proc-cert'"
          >
          </cuadro-enod>
         </a>
       </div>

       <div class="col-lg-3 col-xs-6">
         <a @click="EntrarCuadro('documentaciones')">
          <cuadro-enod
              :titulo = "'VEHÍCULOS'"
              :titulo_2 ="'DOC.'"
              :class_color_titulo = "'color_2'"
              :class_color_sub_titulo = "'color_3'"
              :cantidad_1 ="CantVehiculos"
              :cantidad_2 ="CantDocumentaciones"
              :src_icono ="'/img/tablero/icono-enod-vehiculos-doc.svg'"
              :class_color_cuadro = "'bg-custom-4'"
              :habilitado_sn =" $can('T_doc_acceder') ?  true : false"
              :class_footer_img ="'footer-doc-remitos'"
              :invertir_cantidad_sn ="true"            >
          </cuadro-enod>
          </a>
       </div>

       <div class="col-lg-3 col-xs-6">
         <a @click="EntrarCuadro('soldadores')">
          <cuadro-enod
              :titulo = "'CUÑOS'"
              :titulo_2 ="'USUARIOS'"
              :class_color_titulo = "'color_2'"
              :class_color_sub_titulo = "'color_3'"
              :cantidad_1 ="CantUsuariosCliente"
              :cantidad_2 ="CantSoldadores"
              :src_icono ="'/img/tablero/icono-enod-soldadores.svg'"
              :class_color_cuadro = "'bg-custom-5'"
              :habilitado_sn =" $can('T_soldadores_acceder') ?  true : false"
              :class_footer_img ="'footer-doc-remitos'"

          >
          </cuadro-enod>
         </a>
       </div>

       <div class="col-lg-3 col-xs-6">
         <a @click="EntrarCuadro('informes')">
          <cuadro-enod
              :titulo = "'INFORMES'"
              :class_color_titulo = "'color_3'"
              :class_color_sub_titulo = "'color_2'"
              :cantidad_1 ="CantInformes"
              :src_icono ="'/img/tablero/icono-enod-informes.svg'"
              :class_color_cuadro = "'bg-custom-6'"
              :habilitado_sn =" $can('T_informes_acceder') ?  true : false"
              :class_footer_img ="'footer-oper-inf'"

          >
          </cuadro-enod>
         </a>
       </div>

       <div class="col-lg-3 col-xs-6">
         <a @click="EntrarCuadro('partes')">
          <cuadro-enod
              :titulo = "'PARTES'"
              :class_color_titulo = "'color_3'"
              :class_color_sub_titulo = "'color_2'"
              :cantidad_1 ="CantPartes"
              :src_icono ="'/img/tablero/icono-enod-partes.svg'"
              :class_color_cuadro = "'bg-custom-7'"
              :habilitado_sn =" $can('T_partes_acceder') ?  true : false"
              :class_footer_img ="'footer-equipos-partes'"
          >
          </cuadro-enod>
         </a>
       </div>

       <div class="col-lg-3 col-xs-6">
         <a @click="EntrarCuadro('certificados')">
          <cuadro-enod
              :titulo = "'CERTIFICADOS'"
              :class_color_titulo = "'color_2'"
              :class_color_sub_titulo = "'color_1'"
              :cantidad_1 ="CantCertificados"
              :src_icono ="'/img/tablero/icono-enod-certificados.svg'"
              :class_color_cuadro = "'bg-custom-8'"
              :habilitado_sn =" $can('T_certif_acceder') ?  true : false"
              :class_footer_img ="'footer-proc-cert'"
          >
          </cuadro-enod>
         </a>
       </div>
  </div>
  </div>
  <div class="row">
    <div class="col-md-2 col-sm-12 col-xs-12">
        <div v-show="$can('O_alta')">
            <button @click="NuevaOt()" class="btn pull-left btn-enod"> <span class="fa fa-plus-circle"></span> Nueva OT</button>
        </div>
    </div>
    <div class="col-md-2 col-md-offset-8 col-sm-12 col-xs-12">
      <div class="form-group">
          <div class="input-group">
              <input type="text" v-model="search" class="form-control" v-on:keyup.13="aplicarFiltro" placeholder="Buscar...">
              <span class="input-group-addon btn" @click="aplicarFiltro()" style="background-color: rgb(255, 204, 0);"><i class="fa fa-search"></i></span>
          </div>
      </div>
    </div>
  </div>
  <div v-if="(ots.data && ots.data.length) || loading">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-custom-enod">
            <div class="box-header with-border">
                <h3 class="box-title">Ordenes de trabajo</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="col-lg-1">OT N°</th>
                                <th class="col-lg-3" >Cliente</th>
                                <th class="col-lg-4">Proyecto</th>
                                <th class="col-lg-1">Obra N°</th>
                                <th class="col-lg-1">Fecha</th>
                                <th class="col-lg-1">Estado</th>
                                <th class="col-lg-1" colspan="4">
                                 <small style="margin-left: -2px;">Editar</small>
                                 <small style="margin-left: 4px;">Informe</small>
                                 <small style="margin-left: 4px;">Acción</small>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(ot,k) in ots.data" :key="k" @click="selectOt(k)" :class="{selected: ot_id_selected === ots.data[k].id}"  class="pointer" >
                                <td> {{ot.numero}}</td>
                                <td> {{ot.cliente.nombre_fantasia}}</td>
                                <td> {{ot.proyecto}}</td>
                                <td> {{ot.obra}}</td>
                                <td> {{ot.fecha_formateada}}</td>
                                <td> {{ot.estado}}</td>

                                <td width="10px">
                                  <button class="btn btn-warning btn-sm" title="Editar" @click="openEditarOt(ot.id)" :disabled="!$can('T_edita')">
                                    <span class="fa fa-edit">
                                    </span>
                                  </button>
                                </td>

                                <td width="10px"> <a :href="'/pdf/ot/' + ot.id " target="_blank"  class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a></td>

                                <td width="10px">
                                  <div v-if="ot.estado == 'EDITANDO'">
                                      <button class="btn btn-default btn-sm" title="Firmar"  @click="CambiarEstado(k,'EDITANDO')" :disabled="!$can('T_accion')">
                                      <span class="glyphicon glyphicon-pencil"></span>
                                      </button>
                                  </div>
                                  <div v-else-if="ot.estado == 'ACTIVA'">
                                      <button class="btn btn-default btn-sm" title="Cerrar" @click="CambiarEstado(k,'ACTIVA')" :disabled="!$can('T_accion')">
                                      <span class="glyphicon glyphicon-arrow-right"></span>
                                      </button>
                                  </div>
                                  <div v-else-if="ot.estado == 'CERRADA'">
                                      <button class="btn btn-default btn-sm" title='Cerrada'  disabled>
                                      <span class="glyphicon glyphicon-check"></span>
                                      </button>
                                  </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>

                <pagination :data="ots" @pagination-change-page="getResults" :limit="3" ><span slot="prev-nav">&lt; Previous</span>
                <span slot="next-nav">Next &gt;</span> </pagination>
            </div>

            <div v-if="loading" class="overlay">
               <loading-spin></loading-spin>
            </div>

        </div>
      </div>
    </div>
  </div>
    <div class="clearfix"></div>
    <confirmar-modal></confirmar-modal>
</div>

</template>
<script>

import { eventModal } from './../event-bus';
import {mapState} from 'vuex';
export default {

    data() { return {

        ots :{},
        ot_id_selected : '0',
        search:'',
        loading:false,
        index_ot:0,
        }

    },

    computed :{

        ...mapState(['url',
                     'CantInformes',
                     'CantInternoEquipos',
                     'CantOperadores',
                     'CantSoldadores',
                     'CantUsuariosCliente',
                     'CantProcedimientos',
                     'CantPartes',
                     'CantVehiculos',
                     'CantDocumentaciones',
                     'CantCertificados'])
     },

     watch: {

      ot_id_selected: function (ot_id) {

        this.cambiarTituloHeader(ot_id);
        this.$store.dispatch('loadContarOperadores',ot_id);
        this.$store.dispatch('loadContarInternoEquipos',ot_id);
        this.$store.dispatch('loadContarProcedimientos',ot_id);
        this.$store.dispatch('loadContarVehiculos',ot_id);
        this.$store.dispatch('loadContarDocumentaciones',ot_id);
        this.$store.dispatch('loadContarSoldadores',ot_id);
        this.$store.dispatch('loadContarUsuariosCliente',ot_id);
        this.$store.dispatch('loadContarInformes',ot_id);
        this.$store.dispatch('loadContarPartes',ot_id);
        this.$store.dispatch('loadContarCertificados',ot_id);

      }
    },

    created : function() {

        eventModal.$on('confirmar_accion',function(accion) {

            switch (accion) {
                case 'firmar':
                    this.firmar();
                    break;
                case 'cerrar':
                    this.cerrar();
                    break;
                default:
                    break;
            }

        }.bind(this));
    },

    mounted : function() {

       this.getResults();

    },

    methods : {

        cambiarTituloHeader : function(ot_id){

          let numero='';
          let estado='';
          this.ots.data.forEach(function(item){
            if(item.id == ot_id){
              numero = item.numero;
              estado = item.estado;
            }
          }.bind(this));
          if(numero && estado){
            document.getElementsByClassName('sub-titulo')[0].innerHTML = '/ OT N°: ' + numero + ' / ESTADO: ' + estado;
          }
        },

        aplicarFiltro : function(){

          console.log(this.search);
          this.getResults(1,this.search);

        },

        getResults : function(page = 1,filtro =''){

            this.loading = true;
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ots?page='+ page + '&search=' + filtro ;
            axios.get(urlRegistros).then(response =>{

            this.ots = response.data

              if(this.ots.data.length){

                 this.ot_id_selected = this.ots.data[0].id;

              }else{

                this.ot_id_selected = -1;

              }

            }).finally(() => this.loading = false)

        },

         selectOt : function(index){

            this.ot_id_selected = this.ots.data[index].id;

         },


         CambiarEstado : function(k,estado){

             switch (estado) {
                 case 'EDITANDO':
                     this.confirmarfirma(k);
                     break;

                 case 'ACTIVA':
                     this.confirmarCierre(k);
                     break;

                 default:
                     break;
             }

         },

        confirmarfirma : function(k){
            this.index_ot = k ;
            eventModal.$emit('abrir_confirmar_accion','Está seguro de firmar la orden de trabajo N° ' + this.ots.data[this.index_ot].numero + ' ?','firmar' );

        },

        confirmarCierre : function(k){
            this.index_ot = k ;
            eventModal.$emit('abrir_confirmar_accion','Está seguro de cerrar la orden de trabajo N° ' + this.ots.data[this.index_ot].numero + ' ?','cerrar' );

        },

        firmar: function(){
            this.loading = true;
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ots/' + this.ots.data[this.index_ot].id  + '/firmar';
            axios.put(urlRegistros).then(response => {
            this.getResults(this.ots.current_page);
            toastr.success('La OT N° '+ this.ots.data[this.index_ot].numero +' fue firmada con éxito');

            }).catch(error => {
                this.errors = error.response.data.errors;
                $.each( this.errors, function( key, value ) {
                    toastr.error(value);
                    console.log( key + ": " + value );
                });

                  if((typeof(this.errors)=='undefined') && (error)){

                  toastr.error("Ocurrió un error al procesar la solicitud");

            }
            }).finally(()=> {this.loading = false;});
        },

        cerrar : function(){

            this.loading = true;
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ots/' + this.ots.data[this.index_ot].id + '/cerrar';
            axios.put(urlRegistros).then(response => {
            this.getResults(this.ots.current_page);
            toastr.success('La OT N° '+ this.ots.data[this.index_ot].numero +' fue cerrada con éxito');

            }).catch(error => {
                this.errors = error.response.data.errors;
                $.each( this.errors, function( key, value ) {
                    toastr.error(value);
                    console.log( key + ": " + value );
                });

                  if((typeof(this.errors)=='undefined') && (error)){

                  toastr.error("Ocurrió un error al procesar la solicitud");

            }
            }).finally(()=> {this.loading = false;});
        },

      openEditarOt: function(id){

        window.location.href =  '/area/enod/ots/' + id + '/edit';

      },

      openUsuariosOt: function(id){

        window.location.href =  '/soldadores/ot/' + id;

      },

      NuevaOt : function(){

        window.location.href =  '/area/enod/ots';

      },

      alerta : function(){  this.$showMessagePreset('success','code-200');this.$showMessagePreset('error','code-500');this.$showMessages('info',['Este mensaje de info es personalizado']) },

      EntrarCuadro : function(seccion){

        console.log(seccion);

        switch (seccion) {

          case 'operadores':
            if(this.$can('T_operador_acceder')){
              window.location.href =  '/operadores/ot/' + this.ot_id_selected;
            }
          break;

          case 'equipos':
            if(this.$can('T_equipos_acceder')){
              window.location.href =  '/interno_equipos/ot/' + this.ot_id_selected;
            }
          break;

          case 'procedimientos':
            if(this.$can('T_proc_acceder')){
              window.location.href =  '/procedimientos/ot/' + this.ot_id_selected;
            }
          break;

          case 'documentaciones':
            if(this.$can('T_doc_acceder')){
              window.location.href =  '/documentaciones/ot/' + this.ot_id_selected;
            }
          break;

          case 'soldadores':
            if(this.$can('T_soldadores_acceder')){
              window.location.href =  '/soldadores/ot/' + this.ot_id_selected;
            }
          break;

          case 'informes':
            if(this.$can('T_informes_acceder')){
              window.location.href =  '/informes/ot/' + this.ot_id_selected;
            }
          break;

          case 'partes':
            if(this.$can('T_partes_acceder')){
              window.location.href =  '/partes/ot/' + this.ot_id_selected;
            }
          break;

          case 'certificados':
            if(this.$can('T_certif_acceder')){
              window.location.href =  '/certificados/ot/' + this.ot_id_selected;
            }
           break;

          default:
            break;
        }


      }

    }
}

</script>

<style >

  @media (max-width: 970px) {
    .col-xs-12, .col-sm-12 {
        margin-top:10px;
    }
  }

</style>
