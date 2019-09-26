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
            
                 <div class="form-group">
                   <div class="radio">
                       <label>    
                           <input type="radio"  name="enod" :value="true"  v-model="isEnod">
                            Enod
                        </label>                   
                   </div>
                    <div class="radio">
                         <label> 
                             <input type="radio" name="cliente" :value="false" v-model="isEnod">
                             Cliente
                         </label>      
                    </div>
                  </div>   
                   
                    <label for="name">Nombre</label>
                   
                    <input autocomplete="off" v-model="newRegistro.name" type="text" name="nombre" class="form-control" value="">
                    <label for="name">Cliente</label>
                    <div v-if="!isEnod"> 
                         <v-select v-model="cliente" label="razon_social" :options="clientes"></v-select>                         
                    </div>
                    <label for="usuario">email</label>
                    <input autocomplete="off" type="text" name="email" class="form-control" v-model="newRegistro.email" value="">
                    <label for="password">Contraseña</label>
                          <input autocomplete="off" type="password" name="password" class="form-control" v-model="newRegistro.password" readonly>
                    <label for="password2">Repetir Contraseña</label>
                          <input autocomplete="off" type="password" name="password2" class="form-control" v-model="password2" readonly>
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
            'name'  : '',
            'email' : '',
            'password' : ''
         },
        errors:{},
        isEnod:true,
        cliente:{},
        clientes:[],
        password2:'',
        request : []
         }
    
    },
 created: function () {
     
    eventNewRegistro.$on('open', this.openModal)
    this.getClientes();
  
    },
    computed :{
    
         ...mapState(['url'])
    },
 
   
    methods: {
           openModal : function(){
                this.newRegistro = {           
                        'name'  : '',
                        'email' : '',
                        'password' : ''
                     },
                this.password2='',
                this.isEnod=true,
                $('#nuevo').modal('show');    
                $( document ).ready(function() {
                    setTimeout(function(){
                        $("#pass").attr('readonly', false);
                        $("#pass").focus();
                    },500);
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

                if(this.newRegistro.password != this.password2){
                      toastr.error("Las contreseñas ingresadas no coinciden");
                      return;
                }    

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'users';                         
                axios.post(urlRegistros, {   
                    
                'name'      : this.newRegistro.name,                
                'email'     : this.newRegistro.email,
                'password'  : this.newRegistro.password,
                'cliente'   : this.cliente,
                'isEnod'    : this.isEnod,
                  
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

