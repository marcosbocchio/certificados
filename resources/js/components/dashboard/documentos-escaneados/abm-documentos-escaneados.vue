<template>
    <div>
        <div class="col-sm-10">
            <div v-show="$can('T_informes_edita')">
                 <button class="btn btn-enod pull-right" v-on:click.prevent="openNuevoRegistro()">Nuevo </button>
            </div>
        </div>
        <div class="clearfix"></div> 
        <div class="col-sm-10">
            <table-documentos-escaneados :registros="registros"  @confirmarDelete="confirmDeleteRegistro" @editRegistroEvent="editRegistro"></table-documentos-escaneados>
            <delete-registro :datoDelete="datoDelete" :fillRegistro="fillRegistro" @close-modal="getRegistros" :modelo="'documentos_escaneados'"></delete-registro>  
            <form-documentos-escaneados :ot_id="ot_id" :tipo_documento="tipo_documento" :id="id" :editmode="editmode" :registro="newRegistro" @store="getRegistros" ></form-documentos-escaneados>

        </div>         
        <div class="clearfix"></div>
    </div>    
</template>

<script>

import {mapState} from 'vuex'
import { eventDeleteFile , eventNewRegistro, eventEditRegistro } from '../../event-bus';

export default {
    name: 'abm-documentos-escaneados',
      props : {   

          ot_id : {
          type: Number,      
          required: true
          },
 
          tipo_documento : {
            type : String,
            required : true
          },

          id : {
            type: Number,      
            required: true  
          },
      },

      data() { return {      

        editmode: false,
        fillRegistro: {},
        datoDelete: '',
        registros: [],     
        newRegistro : {  

            descripcion  : '',
            path : '',                

         },
      }},

      created : function(){

          this.getRegistros();    
            
      },  
       
    computed :{    
         
         ...mapState(['url','AppUrl'])
     },
     
    methods :{        


        getRegistros : function(){

                this.isLoading = true;
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'documentos_escaneados/ot/' + this.ot_id + '/tipo_documento/'  + this.tipo_documento + '/' + this.id;    
            
                axios.get(urlRegistros).then(response =>{

                    this.registros = response.data;
                
                });
            },

     openNuevoRegistro : function(){      
            
           this.editmode = false;         
           eventDeleteFile.$emit('delete');
           eventNewRegistro.$emit('open');
           $('#nuevo').modal('show');  

           }, 


        confirmDeleteRegistro: function(registro,dato){            
                this.fillRegistro.id = registro.id;
                this.datoDelete = dato;             
                $('#delete-registro').modal('show');
            },

        editRegistro : function(registro){

                    this.editmode = true;
                    this.newRegistro = registro;  
                    eventDeleteFile.$emit('delete');
                    eventNewRegistro.$emit('open');
                    $('#nuevo').modal('show');  
                        
                },
    }

}


</script>

<style scoped>

    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        background-color: #eee;
    }

</style>