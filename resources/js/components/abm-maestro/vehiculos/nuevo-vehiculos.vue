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
                   <div class="row"> 
                       <div class="col-md-12">

                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="numero_interno">N° Interno *</label> 
                                    <input autocomplete="off" v-model="Registro.nro_interno" type="text" name="numero_interno" class="form-control" value="" maxlength="5">                  
                                </div>
                            </div>
                           
                            <div class="col-md-6">    
                                <div class="form-group">                           
                                    <label for="marca">Marca *</label>                   
                                    <input autocomplete="off" v-model="Registro.marca" type="text" name="marca" class="form-control" value="" maxlength="15" > 
                                </div>
                            </div>

                            <div class="col-md-12">    
                                <div class="form-group">                                    
                                    <label for="modelo">Modelo</label>                   
                                    <input autocomplete="off" v-model="Registro.modelo" type="text" name="modelo" class="form-control" value="" maxlength="50">
                                </div>                            
                            </div>

                            <div class="col-md-6">    
                                <div class="form-group">    
                                    <label for="patente">Patente *</label>      
                                    <input autocomplete="off" v-model="Registro.patente" type="text" name="patente" class="form-control" value="" maxlength="7">         
                                </div>
                            </div>


                            <div class="col-md-6">    
                                <div class="form-group">    
                                    <label for="tipo">Tipo *</label>      
                                    <input autocomplete="off" v-model="Registro.tipo" type="text" name="tipo" class="form-control" value="" maxlength="15">         
                                </div>
                            </div>

                            <div class="col-md-6">    
                                <div class="form-group">    
                                    <label for="chasis">Chasis *</label>      
                                    <input autocomplete="off" v-model="Registro.chasis" type="text" name="chasis" class="form-control" value="" maxlength="20">      
                                </div>
                            </div>

                            <div class="col-md-6">    
                                <div class="form-group">    
                                    <label for="motor">Motor *</label>      
                                    <input autocomplete="off" v-model="Registro.motor" type="text" name="motor" class="form-control" value="" maxlength="20">    
                                </div>
                            </div>

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
            'nro_interno' :'',       
            'marca'    : '',
            'modelo'   : '',  
            'patente'  : '',
            'tipo'     :'',
            'chasis'   :'',
            'motor'    :'',                       
         },

        errors:{},        
         }
    
    },
 created: function () {
     
    eventNewRegistro.$on('open', this.openModal);
  
    },
    computed :{
    
          ...mapState(['url'])
    },   


    methods: {
           openModal : function(){
                    this.Registro = {  
                         'nro_interno' :'',                
                        'marca'    : '',
                        'modelo'   : '',  
                        'patente'  : '',
                        'tipo'     : '',
                        'chasis'   : '',
                        'motor'    : '',                       
                    },
                    this.unidad_medida ={};         
                $('#nuevo').modal('show');    
                $( document ).ready(function() {
                    setTimeout(function(){
                        $("#pass").attr('readonly', false);
                        $("#pass").focus();
                    },500);
                });           
            },            
            

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'vehiculos';                         
                axios.post(urlRegistros, {   
                    
                ...this.Registro,          
                  
                }).then(response => {
                  this.$emit('store');
                  this.errors=[];
                  $('#nuevo').modal('hide');
                  toastr.success('Nuevo vehículo creado con éxito');               
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