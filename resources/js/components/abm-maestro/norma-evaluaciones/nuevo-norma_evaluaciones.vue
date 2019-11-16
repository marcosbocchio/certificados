<template>
    <form v-on:submit.prevent="storeRegistro" method="post">
    <div class="modal fade" id="nuevo">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Crear</h4>
                </div>
                 <div class="modal-body">    
                
                    <label for="codigo">Código (*)</label>                   
                    <input autocomplete="off" v-model="newRegistro.codigo" type="text" name="codigo" class="form-control" value="">
                    
                    <label for="descripcion">Descripción</label>                   
                    <input autocomplete="off" type="text" name="descripcion" class="form-control" v-model="newRegistro.descripcion" value="">       
              
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
 import { eventNewRegistro } from '../../event-bus';
export default {
    data() { return {
    
        newRegistro : {           
            'codigo'  : '',
            'descripcion'  : '',                    
         },
         
        
        errors:{},        
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

                this.newRegistro = {           
                    'codigo'  : '',
                    'descripcion'  : '',               
                };           
              

                $('#nuevo').modal('show');    
                      
            },       

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'norma_evaluaciones';                         
                axios.post(urlRegistros, {   
                    
                ...this.newRegistro,              
                             
                  
                }).then(response => {
                  this.$emit('store');
                  this.errors=[];
                  $('#nuevo').modal('hide');
                  toastr.success('Norma de evaluación creada con éxito');               
                  this.newRegistro={}
                  
                }).catch(error => {                   
                    console.log(error);    
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