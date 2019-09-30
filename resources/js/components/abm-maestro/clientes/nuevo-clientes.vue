<template>
    <form v-on:submit.prevent="storeRegistro" method="post">
    <div class="modal fade" id="nuevo"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" >Crear</h4>
                    
                </div>
                <div class="modal-body">   
                    <div class="col-md-12">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos Cliente</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>                       
                                </div>
                            </div>
                        <div class="box-body">  
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="name">Código (*)</label>                   
                                    <input autocomplete="off" v-model="newRegistro.codigo" type="text" name="codigo" class="form-control" value=""> 
                                </div>  
                            </div>            
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="name">Nombre (*)</label>                   
                                    <input autocomplete="off" v-model="newRegistro.nombre" type="text" name="nombre" class="form-control" value=""> 
                                </div>  
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Razon Social(*)</label>                   
                                    <input autocomplete="off" v-model="newRegistro.razon_social" type="text" name="razon_social" class="form-control" value=""> 
                                </div> 
                            </div> 
                        <div class="col-md-6">                 
                                <div class="form-group">
                                    <label>Provincia (*)</label>
                                    <v-select v-model="provincia" label="provincia" :options="provincias" @input="getLocalidades()"></v-select>   
                                </div>
                        </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label>Localidad (*)</label>
                                <v-select v-model="localidad" label="localidad" :options="localidades"></v-select>   
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Código Postal (*)</label>                   
                                    <input autocomplete="off" v-model="newRegistro.cp" type="text" name="cp" class="form-control" value=""> 
                                </div> 
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Dirección (*)</label>                   
                                    <input autocomplete="off" v-model="newRegistro.direccion" type="text" name="direccion" class="form-control" value=""> 
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Teléfono (*)</label>                   
                                    <input autocomplete="off" v-model="newRegistro.tel" type="text" name="telefono" class="form-control" value=""> 
                                </div> 
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">email (*)</label>
                                    <input autocomplete="off" type="text" name="email" class="form-control" v-model="newRegistro.email" value="">
                                </div>      
                            </div>
                      </div>
                        </div>
                   </div>
                   <!-- contacto 1 -->  
                    <div class="col-md-12">
                        <div class="box box-danger collapsed-box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Contacto 1</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                    </button>                       
                                </div>
                            </div>
                        <div class="box-body">
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="name">Nombre</label>                   
                                    <input autocomplete="off" v-model="contacto1.nombre" type="text" name="nombre" class="form-control" value=""> 
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">Cargo</label>
                                    <input autocomplete="off" type="text" name="cargo" class="form-control" v-model="contacto1.cargo" value="">
                                </div>      
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">Teléfono</label>
                                    <input autocomplete="off" type="text" name="telefono" class="form-control" v-model="contacto1.tel" value="">
                                </div>      
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">email</label>
                                    <input autocomplete="off" type="text" name="email" class="form-control" v-model="contacto1.email" value="">
                                </div>      
                            </div>
                        </div>
                        </div>
                    </div>

                    <!-- contacto 2 -->  
                    <div class="col-md-12">
                        <div class="box box-danger collapsed-box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Contacto 2</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                    </button>                       
                                </div>
                            </div>
                        <div class="box-body">
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="name">Nombre</label>                   
                                    <input autocomplete="off" v-model="contacto2.nombre" type="text" name="nombre" class="form-control" value=""> 
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">Cargo</label>
                                    <input autocomplete="off" type="text" name="cargo" class="form-control" v-model="contacto2.cargo" value="">
                                </div>      
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">Teléfono</label>
                                    <input autocomplete="off" type="text" name="telefono" class="form-control" v-model="contacto2.tel" value="">
                                </div>      
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">email</label>
                                    <input autocomplete="off" type="text" name="email" class="form-control" v-model="contacto2.email" value="">
                                </div>      
                            </div>
                        </div>
                        </div>
                    </div>

                    <!-- contacto 3 -->
                    <div class="col-md-12">
                        <div class="box box-danger collapsed-box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Contacto 3</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                    </button>                       
                                </div>
                            </div>
                        <div class="box-body">
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="name">Nombre</label>                   
                                    <input autocomplete="off" v-model="contacto3.nombre" type="text" name="nombre" class="form-control" value=""> 
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">Cargo</label>
                                    <input autocomplete="off" type="text" name="cargo" class="form-control" v-model="contacto3.cargo" value="">
                                </div>      
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">Teléfono</label>
                                    <input autocomplete="off" type="text" name="telefono" class="form-control" v-model="contacto3.tel" value="">
                                </div>      
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">email</label>
                                    <input autocomplete="off" type="text" name="email" class="form-control" v-model="contacto3.email" value="">
                                </div>      
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
    
        newRegistro : {   
            'codigo' :'',        
            'nombre'  : '',
            'razon_social' : '',
            'tel' : '',
            'email' :'',
            'direccion':'',
            'cp':''            
         },
        errors:{},               
        provincia:{},
      //  provincias:{},
        localidad:{},
        localidades:[],
        contacto1 : {
           'nombre'  : '',
           'cargo' : '',
           'tel' : '',
           'email' :'',
        },
        contacto2 : {
           'nombre'  : '',
           'cargo' : '',
           'tel' : '',
           'email' :'',
        },
        contacto3 : {
           'nombre'  : '',
           'cargo' : '',
           'tel' : '',
           'email' :'',
        }  

       
         }
    
    },
 created: function () {
     
    eventNewRegistro.$on('open', this.openModal)
    this.getProvincias();  
   
  
    },
    computed :
    
         mapState(['url','provincias'])
       
    ,   
    methods: {
           openModal : function(){
                this.newRegistro = {   
                        'codigo' :'',               
                        'nombre'  : '',
                        'razon_social' : '',
                        'tel' : '',
                        'email' :'',
                        'direccion':'',
                        'cp':''            
                    },
                    this.contacto1 = {
                        'nombre'  : '',
                        'cargo' : '',
                        'tel' : '',
                        'email' :'',
                        },
                    this.contacto2 = {
                        'nombre'  : '',
                        'cargo' : '',
                        'tel' : '',
                        'email' :'',
                        },
                     this.contacto3 = {
                        'nombre'  : '',
                        'cargo' : '',
                        'tel' : '',
                        'email' :'',
                        }  
                this.provincia={},
                this.localidad={},
             
                $('#nuevo').modal('show');    
                $( document ).ready(function() {
                    setTimeout(function(){
                        $("#pass").attr('readonly', false);
                        $("#pass").focus();
                    },500);
                });           
            },

            getProvincias : function(){
                
                this.$store.dispatch('loadProvincias');

            },

            getLocalidades : function(){
                this.localidades=[];
                this.localidad ='';
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'localidades/' + this.provincia.id + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.localidades = response.data
                });
              },

            getClientes: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'clientes' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.clientes = response.data
                });
              },

            storeRegistro: function(){              

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'clientes';                         
                axios.post(urlRegistros, {   
                    
                ...this.newRegistro,
                'provincia' : this.provincia,
                'localidad' : this.localidad,
                'contacto1' : this.contacto1,
                'contacto2' : this.contacto2,
                'contacto3' : this.contacto3,
                  
                }).then(response => {
                  this.$emit('store');
                  this.errors=[];
                  $('#nuevo').modal('hide');
                  toastr.success('Nuevo usuario creado con éxito');               
                  this.newRegistro={}
                  
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