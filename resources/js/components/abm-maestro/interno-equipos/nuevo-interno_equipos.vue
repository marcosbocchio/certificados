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

                            <div class="col-md-12">    
                                <div class="form-group">
                                    <label for="numero_serie">N° Serie *</label>  
                                    <input type="checkbox" id="checkbox" v-model="Registro.activo_sn" style="float:right"> 
                                    <label for="tipo" style="float:right;margin-right: 5px;">ACTIVO</label>     
                                    <input autocomplete="off" v-model="Registro.nro_serie" type="text" name="numero_serie" class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-md-12">    
                                <div class="form-group">
                                    <label for="numero_interno">N° Interno *</label> 
                                    <input autocomplete="off" v-model="Registro.nro_interno" type="text" name="numero_interno" class="form-control" value="">                  
                                </div>
                            </div>

                             <div class="col-md-12">    
                                <div class="form-group">
                                    <label for="equipos">Equipo *</label>      
                                    <v-select v-model="equipo" label="codigo" :options="equipos">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.codigo }}</span> <br> 
                                            <span class="downSelect"> {{ option.descripcion }} </span> 
                                        </template>
                                    </v-select>              
                                </div>
                            </div>                           

                            <div class="col-md-12">    
                                <div class="form-group">
                                    <label>Fuente </label>
                                    <v-select  v-model="interno_fuente" :options="interno_fuentes" label="nro_serie">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.nro_serie }}</span> <br> 
                                            <span class="downSelect"> {{ option.fuente.codigo }} </span>
                                        </template>
                                    </v-select>                         
                                </div>
                            </div>                         

                            <div v-if="!(interno_fuente ||  !(equipo && equipo.metodo_ensayos.metodo == 'RI'))" class="col-md-12">    
                                <div class="form-group">
                                    <label for="foco">Foco </label>
                                    <input v-model="Registro.foco" type="number" name="foco" class="form-control" value="" step="0.1">   
                                </div>
                            </div>
                            <div v-else class="col-md-12">
                                <div class="form-group">
                                    <label for="foco">Foco vv </label>
                                    <input v-model="interno_fuente.foco" type="number" class="form-control" disabled name="foco">  
                                </div>
                            </div>

                            <div class="col-md-12">    
                                <div class="form-group">
                                    <label for="voltaje">Voltaje</label>
                                    <input v-model="Registro.voltaje" type="number" name="voltaje" class="form-control" max="9999" value="" step="0.1">   
                                </div>
                            </div>

                            <div class="col-md-12">    
                                <div class="form-group">
                                    <label for="amperaje">Amperaje</label>
                                    <input v-model="Registro.amperaje" type="number" name="amperaje" class="form-control" max="9999" value="" step="0.1">             
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
            'nro_serie'  : '',
            'nro_interno'  : '',
            'voltaje' : '', 
            'amperaje' : '', 
            'foco' :  '',
            'activo_sn' : true,      
         },
         equipo :'',          
         interno_fuente :'', 
        errors:{},        
         }
    
    },
 created: function () {
     
    eventNewRegistro.$on('open', this.openModal)   
  
    },
    computed :{
    
         ...mapState(['url','equipos','interno_fuentes']),

         interno_fuente : function(val){

             foco = (val) ? foco : '';
         }
    },
 
   
    methods: {
           openModal : function(){
                this.Registro = {           
                    'nro_serie'  : '',
                    'nro_interno'  : '',
                     'foco' :  '',
                    'voltaje' : '', 
                    'amperaje' : '', 
                    'activo_sn' : true,      
                };
                this.equipo = '';  
                this.interno_fuente ='';  

                $('#nuevo').modal('show');    
                      
            },       

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'interno_equipos';                         
                axios.post(urlRegistros, {   
                    
                ...this.Registro,     
                'equipo' : this.equipo,
                'interno_fuente' : this.interno_fuente,  
          
                  
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