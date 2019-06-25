<template>
<div>
    <div class="col-sm-10">
        <a href="#" class="btn btn-primary pull-right" v-on:click.prevent="openNuevoRegisto()" >Nuevo</a>
    </div>
    
      <div class="col-sm-10">
          <component :is= setTablaComponente :registros="registros"  @confirmarDelete="confirmDeleteRegistro"/>               
          <delete-registro :datoDelete="datoDelete" :fillRegistro="fillRegistro" @close-modal="getRegistros" :modelo="modelo"></delete-registro>  
          <component :is= setNuevoComponente @store="getRegistros"/>      
      </div>
  
    <div class="col-sm-8">
      <pre>
        {{ $data }}
      </pre>
    </div>
</div> 
</template>

<script>
  import {mapState} from 'vuex'
  import { eventNewRegistro } from '../event-bus';
    export default {
      name: 'abm-maestro',
      props : {         
          modelo : {
            type : String,
            required : true,
            default : ''
          }
      },

      created : function(){

        this.getRegistros();

      },
      mounted () {

      //  $('#nuevo-user').modal('show');
      },

      data () { return {
        fillRegistro: {'id':'','name':''},
        errors:[],
        registros: [], 
        datoDelete: '',    
        obj :'',
   
        }
      },     
      computed :{

         setTablaComponente : function(){

             return 'table-' + this.modelo ;
         },
         setNuevoComponente : function(){

             return 'nuevo-' + this.modelo ;
         },
         ...mapState(['url'])
     },

      methods: {

           openNuevoRegisto : function(){

             eventNewRegistro.$emit('open');
           }, 

            getRegistros : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = this.modelo;    
                axios.get(urlRegistros).then(response =>{
                this.registros = response.data
                });
              },

          
            confirmDeleteRegistro: function(registro,dato){            
              this.fillRegistro.id = registro.id;
              this.datoDelete = dato;
             $('#delete-registro').modal('show');
          }
      }


    }
</script>

