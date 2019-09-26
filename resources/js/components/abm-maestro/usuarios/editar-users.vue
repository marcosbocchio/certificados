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
            
                 <div class="form-group">
                   <div class="radio">
                       <label>    
                           <input type="radio" id="enod" name="enod" :value="true"  v-model="isEnod">
                            Enod
                        </label>                   
                   </div>
                    <div class="radio">
                         <label> 
                             <input type="radio" id="cliente" name="cliente" :value="false" v-model="isEnod">
                             Cliente
                         </label>      
                    </div>
                  </div>   
                   
                    <label for="name">Nombre</label>
                   
                    <input autocomplete="off" v-model="editRegistro.name" type="text" name="nombre" class="form-control" value="">
                    <label for="name">Cliente</label>
                    <div v-if="!isEnod"> 
                         <v-select v-model="cliente" label="razon_social" :options="clientes"></v-select>                         
                    </div>
                    <label for="usuario">email</label>
                    <input autocomplete="off" type="text" name="email" class="form-control" v-model="editRegistro.email" value="">
                    <label for="password">Contraseña</label>
                          <input autocomplete="off" type="password" name="password" class="form-control" v-model="editRegistro.password" value="">
                    <label for="password2">Repetir Contraseña</label>
                          <input autocomplete="off" type="password" name="password2" class="form-control" v-model="password2" value="">
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
            'name'  : '',
            'email' : '',
            'password' : ''
         },
        errors:{},
        isEnod:'true',
        cliente:{},
        clientes:[],
        password2:'',
        request : []
         }
    
    },
 created: function () {    
     
    eventEditRegistro.$on('editar',function() {
         
                 this.openModal();
             
    }.bind(this));    
    this.getClientes();
  
    },
  
    computed :{
    
         ...mapState(['url'])
    }, 
   
    methods: {
           openModal : function(){
               console.log('entro en open modal');            
            this.$nextTick(function () { 
                this.editRegistro.name = this.selectRegistro.name;
                this.editRegistro.email = this.selectRegistro.email;                
                this.editRegistro.password = '********';
                this.password2 = '********';
                console.log(this.selectRegistro.cliente_id);
                if(this.selectRegistro.cliente_id != null){                 
                    this.isEnod = false;
                    this.cliente = this.selectRegistro['cliente'];
                }else{
                    this.isEnod = true;
                    this.cliente = {};                      
                }
                   $('#editar').modal('show');               

                this.$forceUpdate();
            })
            },

            getClientes: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'clientes' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.clientes = response.data
                });
              },
            storeRegistro: function(){

                if(this.editRegistro.password != this.password2){
                      toastr.error("Las contreseñas ingresadas no coinciden");
                      return;
                }    

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'users/' + this.selectRegistro.id;                         
                axios.put(urlRegistros, {   
                    
                'name'      : this.editRegistro.name,                
                'email'     : this.editRegistro.email,
                'password'  : this.editRegistro.password,
                'cliente'   : this.cliente,
                'isEnod'    : this.isEnod,
                  
                }).then(response => {
                  this.$emit('update');
                  this.errors=[];
                  $('#editar').modal('hide');
                  toastr.success('Nuevo usuario creado con éxito');               
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

