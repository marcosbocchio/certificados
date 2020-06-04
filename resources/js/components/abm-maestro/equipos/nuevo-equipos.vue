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

                   <div class="col-md-12">
                     <div class="form-group">                   
                        <label for="codigo">Código *</label>                   
                        <input autocomplete="off" v-model="Registro.codigo" type="text" name="codigo" class="form-control" value="">
                     </div>
                   </div>
                    
                   <div class="col-md-12">
                     <div class="form-group">
                        <label for="name">Descripción</label>                   
                        <input autocomplete="off" type="text" name="descripcion" class="form-control" v-model="Registro.descripcion" value="">  
                     </div>
                   </div>
            

                    <div class="col-md-12">
                       <div class="form-group">   
                            <label for="metodo_ensayo">Método de Ensayo *</label>                               
                                <input v-if="metodo_ensayos.metodo == 'US'" type="checkbox" id="checkbox" v-model="Registro.palpador_sn" style="float:right"> 
                                <label v-if="metodo_ensayos.metodo == 'US'" for="tipo" style="float:right;margin-right: 5px;">PALPADOR</label>     
                           <v-select v-model="metodo_ensayos" label="metodo" :options="metodos_ensayos" @input="resetInstrumentoMedicion" ></v-select> 
                      </div>
                    </div>

                    <div class="col-md-12">
                       <div class="form-group">          
                          <label for="instrumento_medicion">Instrumento Medición </label>
                          <v-select v-model="Registro.instrumento_medicion" :options="instrumentos_mediciones" :disabled="((metodo_ensayos.metodo != 'LP') && (metodo_ensayos.metodo != 'PM'))"></v-select>
                       </div>
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
 import { eventNewRegistro } from '../../event-bus';
export default {
    data() { return {
    
        Registro : {           
            'codigo'  : '',
            'descripcion'  : '',
            'instrumento_medicion' : '',     
            'palpador_sn':false,        
         },   

         instrumentos_mediciones :  ['Luxómetro luz blanca','Lampara luz UV'] ,
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

                this.Registro = {           
                    'codigo'  : '',
                    'descripcion'  : '',
                    'instrumento_medicion' : '',    
                    'palpador_sn':false,        
                };


                this.metodo_ensayos = '';  
              

                $('#nuevo').modal('show');    
                      
            },   

            resetInstrumentoMedicion : function () {               
             
                this.Registro.instrumento_medicion = '';
               
            },    

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'equipos';                         
                axios.post(urlRegistros, {   
                    
                ...this.Registro,              
                'metodo_ensayos' : this.metodo_ensayos,                   
                  
                }).then(response => {
                  this.$emit('store');
                  this.errors=[];
                  $('#nuevo').modal('hide');
                  toastr.success('Nuevo Interno Equipo creado con éxito');               
                  this.Registro={}
                  
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