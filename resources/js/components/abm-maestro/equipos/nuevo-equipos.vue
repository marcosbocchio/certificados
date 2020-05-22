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
                
                   
                    <label for="codigo">Código *</label>                   
                    <input autocomplete="off" v-model="newRegistro.codigo" type="text" name="codigo" class="form-control" value="">
                    
                    <label for="name">Descripción</label>                   
                    <input autocomplete="off" type="text" name="descripcion" class="form-control" v-model="newRegistro.descripcion" value="">              

                    <label for="metodo_ensayo">Método de Ensayo *</label>      
                    <v-select v-model="metodo_ensayos" label="metodo" :options="metodos_ensayos" @input="resetInstrumentoMedicion" ></v-select> 
                    
                    <label for="instrumento_medicion">Instrumento Medición </label>
                    <v-select v-model="newRegistro.instrumento_medicion" :options="['Luxómetro luz blanca','Lampara luz UV']" :disabled="((metodo_ensayos.metodo != 'LP') && (metodo_ensayos.metodo != 'PM'))"></v-select>
              
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
            'instrumento_medicion' : '',             
         },
         metodo_ensayos :'',          
        
        errors:{},        
         }
    
    },
 created: function () {
     
    eventNewRegistro.$on('open', this.openModal)   
  
    },
    computed :{
    
         ...mapState(['url','metodos_ensayos'])
    },
 
   
    methods: {
           openModal : function(){

                this.newRegistro = {           
                    'codigo'  : '',
                    'descripcion'  : '',
                    'instrumento_medicion' : '',    
                };

                this.metodo_ensayos = '';  
              

                $('#nuevo').modal('show');    
                      
            },   

            resetInstrumentoMedicion : function () {               
             
                this.newRegistro.instrumento_medicion = '';
               
            },    

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'equipos';                         
                axios.post(urlRegistros, {   
                    
                ...this.newRegistro,              
                'metodo_ensayos' : this.metodo_ensayos,                   
                  
                }).then(response => {
                  this.$emit('store');
                  this.errors=[];
                  $('#nuevo').modal('hide');
                  toastr.success('Nuevo Interno Equipo creado con éxito');               
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

<style scoped>

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}

</style>