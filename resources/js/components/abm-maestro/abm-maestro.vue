<template>
<div>
    <div class="col-sm-10">
        <a href="#" class="btn btn-primary pull-right" v-on:click.prevent="openNuevoRegistro()" >Nuevo</a>
    </div>    
    <div class="col-sm-10">
        <component :is= setTablaComponente :registros="registros" @confirmarDelete="confirmDeleteRegistro" @editar="editRegistro"/>               
        <delete-registro :datoDelete="datoDelete" :fillRegistro="fillRegistro" @close-modal="getRegistros" :modelo="modelo"></delete-registro>  
        <component :is= setNuevoComponente :modelo ="modelo" @store="getRegistros"/>
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

            getRegistros : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = this.modelo;   
                axios.get(urlRegistros).then(response =>{
                this.registros = response.data
                });
              },
            
            editRegistro : function(item){
                console.log('entro en editar principal');             
                this.selectRegistro = item;    
                console.log(item);           
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

