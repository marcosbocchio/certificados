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
                    
                    <label for="name">Descripción</label>                   
                    <input autocomplete="off" type="text" name="descripcion" class="form-control" v-model="newRegistro.descripcion" value="">

                     <label for="name">Unidad Medida (*)</label>      
                    <v-select v-model="unidad_medida" label="codigo" :options="unidades_medidas"></v-select>

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
            'descripcion' : '',           
         },

        unidad_medida :{},      
        errors:{},        
         }
    
    },
 created: function () {
     
    eventNewRegistro.$on('open', this.openModal);
    this.$store.dispatch('loadUnidadesMedidas');
  
    },
    computed :{
    
          ...mapState(['url','unidades_medidas'])
    },
 
   
    methods: {
           openModal : function(){
                this.newRegistro = {           
                        'codigo'  : '',
                        'descripcion' : '',                       
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

             getUnidadesMedidas: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'unidades_medidas' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.unidades_medidas = response.data
                });
              },
            
            

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'medidas';                         
                axios.post(urlRegistros, {   
                    
                ...this.newRegistro,
                'unidad_medida' : this.unidad_medida,           
          
                  
                }).then(response => {
                  this.$emit('store');
                  this.errors=[];
                  $('#nuevo').modal('hide');
                  toastr.success('Nueva Unidad de medidas creada con éxito');               
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