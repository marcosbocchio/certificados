<template>
<div>
    <div class="col-sm-10">
        <a href="#" class="btn btn-primary pull-right" v-on:click.prevent="openNuevoRegistro()" >Nuevo</a>
    </div>    
    <div class="col-sm-10">
        <component :is= setTablaComponente :registros="registros" @confirmarDelete="confirmDeleteRegistro" @editar="editRegistro"/>               
        <delete-registro :datoDelete="datoDelete" :fillRegistro="fillRegistro" @close-modal="getRegistros" :modelo="modelo"></delete-registro>  
        <component :is= setNuevoComponente @store="getRegistros"/>
        <component :is= setEditarComponente :selectRegistro="selectRegistro" @update="getRegistros"/>      
    </div> 

</div> 
</template>

<script>
  import {mapState} from 'vuex'
  import { eventNewRegistro, eventEditRegistro } from '../event-bus';
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
        fillRegistro: {},
        errors:[],
        registros: [], 
        datoDelete: '',    
        obj :'',
        registro_id: '',
        registro: {},       
        selectRegistro: {},        
   
        }
      },     
      computed :{

         setTablaComponente : function(){

             return 'table-' + this.modelo ;
         },
         setNuevoComponente : function(){

             return 'nuevo-' + this.modelo ;
         },
         setEditarComponente : function(){

             return 'editar-' + this.modelo ;
         },
         
         ...mapState(['url'])
     },  

      methods: {

           openNuevoRegistro : function(){

             eventNewRegistro.$emit('open');
           }, 

            getRegistros : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = this.modelo;   
                axios.get(urlRegistros).then(response =>{
                this.registros = response.data
                });
              },
            
            editRegistro : function(registro){
                console.log('entro en editar principal');             
                this.selectRegistro = registro;               
               eventEditRegistro.$emit('editar',this.selectRegistro);                  
                    
            },     
                 
            confirmDeleteRegistro: function(registro,dato){            
              this.fillRegistro.id = registro.id;
              this.datoDelete = dato;             
             $('#delete-registro').modal('show');
          }
      }


    }
</script>

