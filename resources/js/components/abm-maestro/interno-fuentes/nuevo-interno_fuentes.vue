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
                            <div class="form-group">
                                <label for="numero_serie">N° Serie (*)</label>   
                                <input type="checkbox" id="checkbox" v-model="newRegistro.activo_sn" style="float:right"> 
                                <label for="tipo" style="float:right;margin-right: 5px;">ACTIVO</label>     
                                <input autocomplete="off" v-model="newRegistro.nro_serie" type="text" name="numero_serie" class="form-control" value="">         
                            </div>
                        </div>   

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha">Fecha Evaluación(*)</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                        <Datepicker v-model="newRegistro.fecha_evaluacion" :input-class="'form-control pull-right'" :language="es"></Datepicker>   
                                </div>
                            </div>
                        </div>       
                        
                    <div class="col-md-6">
                            <div class="form-group">
                                <label for="curie">Curie</label>
                                <input v-model="newRegistro.curie" type="number" name="curie" class="form-control" value="" step="0.01"> 
                            </div>
                    </div>

                    <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Fuente (*)</label>      
                                <v-select v-model="fuente" label="codigo" :options="fuentes" ></v-select>
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
 import Datepicker from 'vuejs-datepicker';
 import {en, es} from 'vuejs-datepicker/dist/locale'
 import { eventNewRegistro } from '../../event-bus';
export default {
    components: {
      Datepicker,
      
  },
    data() { return {

         en: en,
         es: es,
    
        newRegistro : {           
            'nro_serie'  : '',
            'fecha_evaluacion' :'',
            'curie' : '', 
            'activo_sn' : true,      
         },
        fuente :'',      
        errors:{},        
         }
    
    },
 created: function () {
     
    eventNewRegistro.$on('open', this.openModal)   
  
    },
    computed :{
    
         ...mapState(['url','fuentes'])
    },
 
   
    methods: {

           openModal : function(){
                this.newRegistro = {           
                    'nro_serie'  : '',
                    'fecha_evaluacion' :'',
                    'curie' : '100', 
                    'activo_sn' : true,      
                };
                this.fuente = '';    

                $('#nuevo').modal('show');    
                      
            },       

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'interno_fuentes';                         
                axios.post(urlRegistros, {   
                    
                ...this.newRegistro,     
                'fuente' : this.fuente,
          
                  
                }).then(response => {
                  this.$emit('store');
                  this.errors=[];
                  $('#nuevo').modal('hide');
                  toastr.success('Nuevo Interno Fuente creado con éxito');               
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