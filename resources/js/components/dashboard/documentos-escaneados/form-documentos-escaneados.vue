<template>
    <form v-on:submit.prevent="(editmode == false) ? storeRegistro() :  updateRegistro()" method="post">
        <div class="modal fade" id="nuevo">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Crear</h4>
                    </div>
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label for="name">Descripción (*)</label>                   
                            <input autocomplete="off" type="text" name="descripcion" class="form-control" v-model="newRegistro.descripcion" value="">
                        </div>

                        <div class="form-group" >
                            <subir-imagen                                
                                :ruta="ruta"                               
                                :max_size="max_size"
                                :path_inicial="newRegistro.path"
                                :tipos_archivo_soportados ="tipos_archivo_soportados"    
                                :mostrar_formatos_soportados="true"                          
                                @path="newRegistro.path = $event"
                            ></subir-imagen> 
                        </div>  

                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Guardar">
                        <button type="button" class="btn btn-default" name="button" data-dismiss="modal" >Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>

import {mapState} from 'vuex'
import { eventNewRegistro, eventEditRegistro } from '../../event-bus';

export default {    

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

          editmode  : {
              type : Boolean,
              required : true
          },
        
          registro : {
             type : Object,
             required : false
        }

      },

    data() { return {
    
        ruta: 'documentos_escaneados',    
        max_size : 20000, //KB
        tipos_archivo_soportados:['jpg','jpeg','pdf'],
        temp_registro : {},
        newRegistro : {
            'path': '',
            'descripcion'  : '',
         },
        errors: {}
      
        }
    },

   created: function () {

    eventNewRegistro.$on('open', this.openModal)

    },
    computed :{
    
         ...mapState(['url'])
    },
 
    methods: {

        openModal : function(){   

           this.$nextTick(function () { 

            if(this.editmode){

             this.newRegistro = {  
                descripcion  : this.registro.descripcion,
                path : this.registro.path,      
                id : this.registro.id,     
             }; 

            }else{

                this.newRegistro = {  
                   descripcion  : '',
                   path : '',            
                };       

            }
           });   
        },

       editModal : function(){

            console.log('entro en editModal');
             this.newRegistro = {  
                descripcion  : registro.descripcion,
                path : registro.path,           
             };       
                
        },

        storeRegistro: function(){

            axios.defaults.baseURL = this.url ;

            var urlRegistros = 'documentos_escaneados';  
             console.log(urlRegistros);
            axios.post(urlRegistros, {                   
          
                    'descripcion'    : this.newRegistro.descripcion,
                    'path'           :this.newRegistro.path,
                    'ot_id'          :this.ot_id,
                    'tipo_documento' :this.tipo_documento,  
                    'id'             :this.id,   
                    

            }).then(response => {
                this.$emit('store');
                this.errors=[];               
                $('#nuevo').modal('hide');               
                toastr.success('Nuevo registro creado con éxito');
                
                
            }).catch(error => {
               
                this.errors = error.response.data.errors;

                $.each( this.errors, function( key, value ) {
                    toastr.error(value);
                    console.log( key + ": " + value );
                });

            });

        },

        updateRegistro: function(){


            axios.defaults.baseURL = this.url ;
            console.log(this.newRegistro);
            var urlRegistros = 'documentos_escaneados/' + this.newRegistro.id;                 
            axios.put(urlRegistros, {   
                
                    'descripcion'    : this.newRegistro.descripcion,
                    'path'           :this.newRegistro.path,
                    'ot_id'          :this.ot_id,
                    'tipo_documento' :this.tipo_documento,  
                    
            }).then(response => {
                this.$emit('store');
                this.errors=[];
                $('#nuevo').modal('hide');
                toastr.success('Nuevo usuario creado con éxito');               
                this.editRegistro={}
                
            }).catch(error => {                   
                this.errors = error.response.data.errors;
                $.each( this.errors, function( key, value ) {
                    toastr.error(value);
                    console.log( key + ": " + value );
                });

                    if((typeof(this.errors)=='undefined') && (error)){

                    toastr.error("Ocurrió un error al procesar la solicitud");                     
                
            }
            });
            }
    }
}
</script>