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
                        <div class="col-md-6">    
                            <div class="form-group">                          
                                <label for="abreviatura">Código *</label>   
                                <input autocomplete="off" v-model="newRegistro.abreviatura" type="text" name="abreviatura" class="form-control" maxlength="4">
                            </div>      
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                    <label for="name">Descripción</label>                   
                                <input autocomplete="off" type="text" name="descripcion" class="form-control" v-model="newRegistro.descripcion" value="">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Unidad Medida *</label>      
                                <v-select v-model="unidad_medida" label="codigo" :options="unidades_medidas"></v-select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Método Ensayo *</label>      
                                <v-select v-model="metodo_ensayo" label="metodo" :options="metodos_ensayos">
                                    <template slot="option" slot-scope="option">
                                        <span class="upSelect">{{ option.metodo }}</span> <br> 
                                        <span class="downSelect"> {{ option.descripcion }} </span>
                                    </template>  
                                </v-select>
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
    
        newRegistro : {           
            'descripcion' : '',      
            'abreviatura' : '',                     
         },

        unidad_medida :{}, 
        metodo_ensayo:[],     
        errors:{},        
         }
    
    },
 created: function () {
     
    eventNewRegistro.$on('open', this.openModal);
    this.$store.dispatch('loadUnidadesMedidas');
    this.$store.dispatch('loadMetodosEnsayos');
  
    },
    computed :{
    
          ...mapState(['url','unidades_medidas','metodos_ensayos'])
    },   


    methods: {
           openModal : function(){
                this.newRegistro = {                      
                        'descripcion' : '',     
                        'abreviatura' : '',                           
                     },    
                    this.unidad_medida ={};       
                    this.metodo_ensayo ={};         
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
                var urlRegistros = 'servicios' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.unidades_medidas = response.data
                });
              },
            
            

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'servicios';                         
                axios.post(urlRegistros, {   
                    
                ...this.newRegistro,
                'unidad_medida' : this.unidad_medida,   
                'metodo_ensayo'  :this.metodo_ensayo,        
          
                  
                }).then(response => {
                  this.$emit('store');
                  this.errors=[];
                  console.log(response);
                  $('#nuevo').modal('hide');
                  toastr.success('Nuevo servicio creado con éxito');               
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
