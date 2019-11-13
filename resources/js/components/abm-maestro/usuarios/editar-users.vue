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
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nombre</label>                    
                                <input autocomplete="off" v-model="editRegistro.name" type="text" name="nombre" class="form-control" value="">
                            </div>
                        </div>
                        <div v-if="!isEnod"> 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Cliente</label>
                                    <v-select v-model="cliente" label="razon_social" :options="clientes"></v-select>           
                                </div>
                            </div>              
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="usuario">email</label>
                                <input autocomplete="nope" type="text" name="email" class="form-control" v-model="editRegistro.email" value="">
                            </div>
                        </div> 

                        <input style="display:none" type="text" name="none-email" class="form-control" v-model="editRegistro.email" value="">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input autocomplete="new-password" type="password" name="password" class="form-control" v-model="editRegistro.password">
                            </div>
                        </div> 

                        <input style="display:none" type="password" name="password" class="form-control" v-model="editRegistro.password">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password2">Repetir Contraseña</label>
                                <input type="password" name="password2" class="form-control" v-model="password2">
                            </div>
                        </div> 

                       
                        <div v-if="isEnod"> 
                            <div class="col-md-12">   
                                <div class="form-group">    
                                    <label>Firma Digital</label>        
                                    <input type="file" class="form-control" id="inputFile" ref="inputFile1" name="file" @change="onFileSelected($event)">
                                    <button class="hide" @click.prevent="onUpload()" >upload</button> 
                                </div>                              
                            </div>    
                                 
                            <div class="clearfix"></div>
                            
                            <div class="col-md-12">   
                                <div class="form-group">       
                                    <p>Formatos soportados : png, bmp, jpg</p>                          
                                    <div v-if="editRegistro.path">                            
                                        <img :src="'/' + editRegistro.path" class="margin zoom-in"  @click="openGallery()" alt="..." width="120" >
                                        <LightBox :images="images"  ref="lightbox"  :show-light-box="false" ></LightBox>
                                    </div>                              
                                    <progress-bar
                                        :options="options"
                                        :value="uploadPercentage"
                                        style="margin-top:5px;"
                                    /> 
                                 </div>    
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">    
                            <div class="form-group">
                                <strong>Roles</strong>    
                                <div v-for="(rol,k) in roles" :key="k" >

                                    <div class="col-sm-4 col-xs-12">
                                        <input type="checkbox" :id=" rol.name " :value="rol.name" v-model="user_rol" style="float:left" :disabled="(rol.name=='Usuario Cliente') || (rol.name == 'Usuario Enod')" > 
                                        <label for="tipo" style="float:left;margin-left: 5px;">{{ rol.name }}</label>         
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
require('vue-image-lightbox/dist/vue-image-lightbox.min.css')
import LightBox from 'vue-image-lightbox'
import {mapState} from 'vuex'
import { eventEditRegistro } from '../../event-bus';
export default {

    components: {        
          
             LightBox,
         },
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
            'password' : '',
            'path':''
         },
        errors:{},
        isEnod:true,
        cliente:{},
        clientes:[],
        user_rol:[],
        password2:'',
        request : [],

        images:[
            {
              
            src: '',
            thumb: '',
            caption: 'caption to display. receive <html> <b>tag</b>', // Optional
              
          }
            ]   ,
       
        fullPage: false,
        isLoading_file: false,     
        uploadPercentage: 0,
        selectedFile : null,     
        HabilitarGuardar : true, 

        options: {
            
            layout: {
                height: 20,
                width: 150,    
                verticalTextAlign: 74,        
                }
            }  
         }
    
    },

    created: function () {    
     
    eventEditRegistro.$on('editar',function() {
         
        this.openModal();
             
    }.bind(this));    
    this.$store.dispatch('loadRoles');
    this.getClientes();

  
    },  
    
    computed :
    
         mapState(['url','roles'])
       
    ,  

    watch : {
          
          editRegistro : function(val) {

                this.images[0].src ='/' + val.path;
                this.images[0].thumb  ='/' + val.path;

          },   

          isEnod : function(val){

              if(val){
                  this.user_rol.splice('Usuario Cliente'); 
                  this.user_rol.push('Usuario Enod');
              }else {
                  this.user_rol.splice('Usuario Enod');    
                  this.user_rol.push('Usuario Cliente')
              }


          },
     }, 
    methods: {

            openGallery(index) {
                    this.$refs.lightbox.showImage(0)
                },  

           openModal : function(){
               console.log('entro en open modal');            
            this.$nextTick(function () { 
                this.editRegistro.name = this.selectRegistro.name;
                this.editRegistro.email = this.selectRegistro.email;                
                this.editRegistro.password = '********';
                this.password2 = '********';
                this.editRegistro.path = this.selectRegistro.path;
                console.log(this.selectRegistro.cliente_id);
                if(this.selectRegistro.cliente_id != null){                 
                    this.isEnod = false;
                    this.cliente = this.selectRegistro['cliente'];
                }else{
                    this.isEnod = true;
                    this.cliente = {};                      
                }

                this.images[0].src ='/' + this.selectRegistro.path;
                this.images[0].thumb  ='/' + this.selectRegistro.path;  
                this.TablaContactos = this.selectRegistro.contactos;
                this.selectedFile =  null;
                this.setRoles(); 
                $('#editar').modal('show');    
                this.$forceUpdate();    
            
            })
            },

            setRoles: function(){
               this.user_rol=[];
               this.selectRegistro.roles.forEach(function(item) {
                    this.user_rol.push(item.name);
               }.bind(this));
               
            },

            getClientes: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'clientes' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.clientes = response.data
                });
              },

             onFileSelected(event) {         
          
            this.isLoading_file = true;  
            this.HabilitarGuardar = false;          

            this.selectedFile = event.target.files[0];
        
            let FileSize = this.selectedFile.size / 1024 / 1024; // in MB           
            let FileType=this.selectedFile.type;         
            console.log(FileType);

            if (!((FileType == 'image/jpeg') || (FileType == 'image/bmp') || (FileType == 'image/png'))) {                   
        
                    toastr.error('El tipo de archivo no es aceptado ');
                    this.$refs.inputFile1.type = 'text';
                    this.$refs.inputFile1.type = 'file';  
                    this.selectedFile = null;
                    return; 
             }
            
                console.log(this.selectedFile);

                if(FileSize > 20 ){
                    event.preventDefault();
                    toastr.error('Archivo demasiado grande. (Max 500 KB)');
                    this.$refs.inputFile1.type = 'text';
                    this.$refs.inputFile1.type = 'file';  
                    this.selectedFile = null;
                    this.uploadPercentage = 0;
                    this.isLoading_file = false;  
                }else{

                    this.onUpload();   

                } 
         
           },
              onUpload() {

              this.HabilitarGuardar = false          
              let settings = { headers: { 'content-type': 'multipart/form-data' }, onUploadProgress: function( progressEvent ) {
                                                                                    this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
                                                                                    }.bind(this) }
               const fd = new FormData();
               
               fd.append('firma-digital',this.selectedFile);
              
               axios.defaults.baseURL = this.url;     
               var url = 'storage/firma-digital';
               console.log(fd);

               axios.post(url,fd,settings)
               .then (response => {                                
                  this.editRegistro.path = response.data;      
                  this.isLoading_file = false   
                  this.HabilitarGuardar = true;   
                  this.images[0].src ='/' + response.data;
                  this.images[0].thumb  ='/' + response.data;     
                  this.$forceUpdate();      
               }).catch(response => {
                   this.errors = error.response.data.errors;
                   this.isLoading_file = false   
                   this.HabilitarGuardar = true;            
                })

            },  

            storeRegistro: function(){

                if(this.editRegistro.password != this.password2){
                      toastr.error("Las contreseñas ingresadas no coinciden");
                      return;
                }    

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'users';                         
                axios.post(urlRegistros, {   
                    
                'name'      : this.editRegistro.name,                
                'email'     : this.editRegistro.email,
                'password'  : this.editRegistro.password,
                'cliente'   : this.cliente,
                'isEnod'    : this.isEnod,
                'path'      : this.editRegistro.path,
                'roles'     :this.user_rol,
                  
                }).then(response => {
                  this.$emit('store');
                  this.errors=[];
                  $('#nuevo').modal('hide');
                  toastr.success('Nuevo usuario creado con éxito');               
                  this.editRegistro={}
                  
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
                    'path'      : this.editRegistro.path,
                    'roles'     :this.user_rol,
                  
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

