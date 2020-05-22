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
                
                   
                    <label for="codigo">Código *</label>                   
                    <input autocomplete="off" v-model="editRegistro.codigo" type="text" name="codigo" class="form-control" value="">
                    
                    <label for="name">Descripción</label>                   
                    <input autocomplete="off" type="text" name="descripcion" class="form-control" v-model="editRegistro.descripcion" value="">              

                    <label for="metodo_ensayo">Método de Ensayo *</label>      
                    <v-select v-model="metodo_ensayos" label="metodo" :options="metodos_ensayos" @input="resetInstrumentoMedicion" ></v-select> 
                    
                    <label for="instrumento_medicion">Instrumento Medición </label>
                    <v-select v-model="editRegistro.instrumento_medicion" :options="instrumentos_mediciones" :disabled="((metodo_ensayos.metodo != 'LP') && (metodo_ensayos.metodo != 'PM'))"></v-select>
              
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
 import { eventEditRegistro } from '../../event-bus';
export default {

    props : {

        selectRegistro : {
            type : Object,
            required : false,           
          }

    },
    data() { return {
    
        editRegistro : {           
            'codigo'  : '',
            'descripcion'  : '',
            'instrumento_medicion' : '',             
         },
         instrumentos_mediciones :  ['Luxómetro luz blanca','Lampara luz UV'] ,
         metodo_ensayos :'',    
        
        errors:{},        
         }
    
    },
    
 created: function () {    
     
    eventEditRegistro.$on('editar',function() {
         
                 this.openModal();
             
    }.bind(this)); 
   this.$store.dispatch('loadMetodosEnsayos');

    },
  
    computed :{
    
         ...mapState(['url','metodos_ensayos'])
    }, 
   
    methods: {
           openModal : function(){
               
                this.$nextTick(function () { 

                    this.editRegistro.codigo = this.selectRegistro.codigo;
                    this.editRegistro.descripcion = this.selectRegistro.descripcion;
                    this.editRegistro.instrumento_medicion = this.selectRegistro.instrumento_medicion;         
                    this.metodo_ensayos = this.selectRegistro.metodo_ensayos;   
                
                    $('#editar').modal('show');               

                    this.$forceUpdate();
                })
            },

            resetInstrumentoMedicion : function () {               
             
                this.newRegistro.instrumento_medicion = '';
               
            },   

            storeRegistro: function(){           

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'equipos/' + this.selectRegistro.id;                         
                axios.put(urlRegistros, {   
                    
                ...this.editRegistro,              
                'metodo_ensayos' : this.metodo_ensayos,                    
              
                }).then(response => {
                  this.$emit('update');
                  this.errors=[];
                  $('#editar').modal('hide');
                  toastr.success('Equipo editado con éxito');         
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

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}

</style>