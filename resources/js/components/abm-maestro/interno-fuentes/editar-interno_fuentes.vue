<template>
    <form v-on:submit.prevent="storeRegistro" method="post">
    <div class="modal fade" id="editar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar</h4>
                </div>
                <div class="modal-body">    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="numero_serie">N° Serie *</label>   
                                <input type="checkbox" id="checkbox" v-model="editRegistro.activo_sn" style="float:right"> 
                                <label for="tipo" style="float:right;margin-right: 5px;">ACTIVO</label>     
                                <input autocomplete="off" v-model="editRegistro.nro_serie" type="text" name="numero_serie" class="form-control" value="">         
                            </div>
                        </div>   

                        <div class="col-md-6">   
                            <div class="form-group">
                                <label for="fecha">Fecha Evaluación *</label>
                                <div>                                                                      
                                    <date-picker v-model="editRegistro.fecha_evaluacion" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="DD-MM-YYYY" disabled ></date-picker>
                                </div> 
                            </div>
                        </div>     

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="curie">Act. inicial</label>
                                <input v-model="editRegistro.curie" type="number" name="curie" class="form-control" value="" step="0.01" disabled> 
                            </div>
                        </div>   
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="curie">Act. Actual</label>
                                <input v-model="editRegistro.curie_actual" type="number" name="curie" class="form-control" value="" step="0.01" disabled> 
                            </div>
                        </div>

                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="foco">Foco *</label>
                                    <input v-model="editRegistro.foco" type="number" name="foco" class="form-control" maxlength="10" step="0.01"> 
                                </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Fuente *</label>      
                                <v-select v-model="fuente" label="codigo" :options="fuentes" disabled></v-select>
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
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';
import { eventEditRegistro } from '../../event-bus';
export default {
    components: {
        DatePicker
      
  },

    props : {

        selectRegistro : {
            type : Object,
            required : false,           
          }

    },
    data() { return {        

        editRegistro : {           
            'nro_serie'  : '',
            'fecha_evaluacion':'',
            'curie' : '', 
            'foco'  :'',
            'curie_actual' :'',
            'activo_sn' : true,      
         },
         fuente :'',       
        errors:{},        
         }
    
    },
    
 created: function () {    
     
    eventEditRegistro.$on('editar',function() {
         
                 this.openModal();
             
    }.bind(this)); 

    this.$store.dispatch('loadFuentes');

    },  
  
    computed :{
    
         ...mapState(['url','fuentes'])
    }, 

    
   
    methods: {
           openModal : function(){
               console.log('entro en open modal');            
            this.$nextTick(function () { 

                this.editRegistro.nro_serie = this.selectRegistro.nro_serie;
                this.editRegistro.activo_sn = this.selectRegistro.activo_sn;  
                this.editRegistro.fecha_evaluacion = this.selectRegistro.fecha_evaluacion;
                this.editRegistro.curie = this.selectRegistro.curie; 
                this.editRegistro.curie_actual = this.selectRegistro.curie_actual; 
                this.fuente = this.selectRegistro.fuente;    
                this.editRegistro.foco = this.selectRegistro.foco;           
               // this.$store.dispatch('loadCurie',this.selectRegistro.id);

                this.$forceUpdate();
            })
                $('#editar').modal('show');               
            },

            storeRegistro: function(){           

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'interno_fuentes/' + this.selectRegistro.id;                         
                axios.put(urlRegistros, {   
                    
                ...this.editRegistro,     
                'fuente' : this.fuente,                       
              
                }).then(response => {
                  this.$emit('update');
                  this.errors=[];
                  $('#editar').modal('hide');
                  toastr.success('Interno Fuente editado con éxito');         
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

<style scoped>

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control  {
     background-color: #eee;
}

</style>