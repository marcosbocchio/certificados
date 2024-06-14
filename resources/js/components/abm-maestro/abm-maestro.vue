<template>
  <div class="row">

         <div class="form-group">

            <div class="col-md-1 col-xs-2">
              <button class="btn btn-enod" v-on:click.prevent="openNuevoRegistro()" :disabled="!$can(permiso_create)"><span class="fa fa-plus-circle"></span> Nuevo</button>
            </div>

            <div v-show="inputSearch.includes(modelo)">
              <div class="col-md-3 col-md-offset-8 col-xs-9 col-xs-offset-1">
                <div class="input-group">
                    <input type="text" v-model="search" class="form-control" v-on:keyup.13="aplicarFiltro" placeholder="Buscar...">
                    <span class="input-group-addon btn" @click="aplicarFiltro()" style="background-color: #F9CA33;"><i class="fa fa-search"></i></span>
                </div>
              </div>
            </div>

        </div>

      <div class="clearfix"></div>

      <div class="col-md-12">
          <component :is= setTablaComponente :registros="registros.data" @confirmarDelete="confirmDeleteRegistro" @editar="editRegistro" @trazabilidad="open_trazabilidad_fuente" :loading="loading"/>
          <delete-registro :datoDelete="datoDelete" :fillRegistro="fillRegistro" @close-modal="getResults" :modelo="modelo"></delete-registro>
          <component :is= setNuevoComponente :modelo ="modelo" @store="getResults"/>
          <component :is= setEditarComponente :selectRegistro="selectRegistro" @update="getResults"/>
          <pagination
                    :data="registros" @pagination-change-page="getResults" :limit="3" >
                    <span slot="prev-nav">&lt; Previous</span>
                    <span slot="next-nav">Next &gt;</span>
          </pagination>

      </div>
    <div class="clearfix"></div>

  </div>
</template>

<script>
  import {mapState} from 'vuex'
  import { eventNewRegistro, eventEditRegistro, eventModal } from '../event-bus';
    export default {
      name: 'abm-maestro',
      props : {

          modelo : {
            type : String,
            required : true,
            default : ''
          },

          permiso_create : {
           type : String,
           required : true
          }
      },

      created : function(){

        this.getResults();

      },

      data () { return {

        inputSearch : ['users','interno_equipos','clientes','equipos','servicios'],
        fillRegistro: {},
        errors:[],
        registros: {},
        datoDelete: '',
        obj :'',
        registro_id: '',
        registro: {},
        selectRegistro: {},
        search:'',
        loading : false,

        }
      },

      watch : {

        modelo : function(){

            this.getResults();

        },

    },
      computed :{

         setTablaComponente : function(){

             return 'table-' + this.modelo.substring(0, (this.modelo.indexOf("/") >-1) ? this.modelo.indexOf("/") : this.modelo.length) ;
         },
         setNuevoComponente : function(){

             return 'nuevo-' + this.modelo.substring(0, (this.modelo.indexOf("/") >-1) ? this.modelo.indexOf("/") : this.modelo.length) ;
         },
         setEditarComponente : function(){

             return 'editar-' + this.modelo.substring(0, (this.modelo.indexOf("/") >-1) ? this.modelo.indexOf("/") : this.modelo.length) ;
         },

         ...mapState(['url'])
     },

      methods: {

           openNuevoRegistro : function(){

             eventNewRegistro.$emit('open',this.modelo);
           },
           

           aplicarFiltro : function(){

              this.getResults(1,this.search);

            },

            getResults : function(page = 1){

                this.loading = true;
                axios.defaults.baseURL = this.url ;
                console.log('modelo',this.modelo)
                var urlRegistros = this.modelo + '/paginate' + '?page='+ page + '&search=' + this.search;
                console.log(urlRegistros)
                axios.get(urlRegistros).then(response =>{
                     this.registros = response.data
                     console.log(this.registros)
                }).finally(() =>
                    this.loading = false,
                    )
              },

            editRegistro : function(item){

               this.selectRegistro = item;
               eventEditRegistro.$emit('editar',this.selectRegistro);

            },

            open_trazabilidad_fuente : function(registro){

              eventModal.$emit('trazabilidad_fuente', registro);

            },

            confirmDeleteRegistro: function(registro,dato){

              this.fillRegistro.id = registro.id;
              this.datoDelete = dato;
              $('#delete-registro').modal('show');
          }
      }
    }
</script>

