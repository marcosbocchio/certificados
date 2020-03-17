<template>
    <form v-on:submit.prevent="storeRegistro" method="post">
    <div class="modal fade" id="editar"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" >Editar</h4>
                </div>
                <div class="modal-body">              
                    <div class="col-md-12">
                        <div class="box box-custom-enod">
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

                            <div class="col-md-6">   
                                <div class="form-group">    
                                    <label>Logo</label>        
                                    <input type="file" class="form-control" id="inputFile" ref="inputFile1" name="file" @change="onFileSelected($event)">
                                    <button class="hide" @click.prevent="onUpload()" >upload</button> 
                               </div>                              
                            </div>   
                            <div class="clearfix"></div>
                            <div class="col-md-6">   
                                <div class="form-group">       
                                    <p>Formatos soportados : png, bmp, jpg</p>                          
                                    <div v-if="newRegistro.path ">                            
                                        <img :src="'/' + newRegistro.path" class="margin zoom-in"  @click="openGallery()" alt="..." width="120" >
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
                        </div>
                   </div>
                   <!-- contacto -->  
                    <div class="col-md-12">
                        <div class="box box-custom-enod ">
                            <div class="box-header with-border">
                                <h3 class="box-title">Contacto</h3>                            
                            </div>
                        <div class="box-body">
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="name">Nombre</label>                   
                                    <input autocomplete="off" v-model="contacto.nombre" type="text" name="nombre" class="form-control" value=""> 
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">Cargo</label>
                                    <input autocomplete="off" type="text" name="cargo" class="form-control" v-model="contacto.cargo" value="">
                                </div>      
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">Teléfono</label>
                                    <input autocomplete="off" type="text" name="telefono" class="form-control" v-model="contacto.tel" value="">
                                </div>      
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">email</label>
                                    <input autocomplete="off" type="text" name="email" class="form-control" v-model="contacto.email" value="">
                                </div>      
                            </div>
                            <div class="col-md-1"> 

                                <p>&nbsp;</p>
                                <span>                             
                                    <a title="Agregar Contacto" @click="AddContacto()"> <app-icon img="plus-circle" color="black"></app-icon> </a>
                                </span>
                        
                            </div>

                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>                                  
                                                <th style="width:90px;">NOMBRE</th>                                  
                                                <th style="width:120px;">CARGO</th>
                                                <th style="width:120px;">TELÉFONO</th>
                                                <th style="width:120px;">EMAIL</th>                                                             
                                                <th colspan="1" style="width:30px;">&nbsp;</th>
                                            </tr>
                                        </thead>                         
                                        <tbody>
                                             <tr v-for="(FilaTabla,k) in (TablaContactos)"  @click="selectPosContacto(k)" :key="k" >                                        
                                                <td>
                                                    <div v-if="indexDetalle == k ">       
                                                          <input type="text" v-model="TablaContactos[k].nombre" maxlength="20" size="25">        
                                                    </div>   
                                                    <div v-else>
                                                           {{ TablaContactos[k].nombre }}
                                                    </div>      

                                                  
                                                </td>                                            
                                                <td>
                                                    <div v-if="indexDetalle == k ">       
                                                          <input type="text" v-model="TablaContactos[k].cargo" maxlength="20" size="15">        
                                                    </div>   
                                                    <div v-else>
                                                           {{ TablaContactos[k].cargo }}
                                                    </div>   
                                                 </td>
                                                <td>
                                                    <div v-if="indexDetalle == k ">       
                                                          <input type="text" v-model="TablaContactos[k].tel" maxlength="20" size="20">        
                                                    </div>   
                                                    <div v-else>
                                                           {{ TablaContactos[k].tel }}
                                                    </div>   
                                                 </td>
                                                <td>
                                                    <div v-if="indexDetalle == k ">       
                                                          <input type="text" v-model="TablaContactos[k].email" maxlength="60" size="25">        
                                                    </div>   
                                                    <div v-else>
                                                           {{ TablaContactos[k].email }}
                                                    </div>   
                                                 </td>                                          
                                                <td> 
                                                    <a  @click="RemoveContacto(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a>
                                                </td>          

                                            </tr>
                                        </tbody>
                                    </table>
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
    
        newRegistro : {   
            'codigo' :'',        
            'nombre'  : '',
            'razon_social' : '',
            'tel' : '',
            'email' :'',
            'direccion':'',
            'cp':'',
            'path':''              
         },     

        errors:{},               
        provincia:{},
        localidad:{},
        
         contacto : {
           'nombre'  : '',
           'cargo' : '',
           'tel' : '',
           'email' :'',
        },
        TablaContactos:[],
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
         indexDetalle:0,

        options: {

           layout: {
                height: 20,
                width: 150,    
                verticalTextAlign: 74,    
                progressPadding: 0,               
                },         
            }         
         }
    
    },
 created: function () {
     
    eventEditRegistro.$on('editar', this.openModal)
    this.getProvincias();  
   
  
    },
    computed :
    
         mapState(['url','provincias','localidades'])
       
    ,  

  watch : {
          
          newRegistro : function(val) {

                this.images[0].src ='/' + val.path;
                this.images[0].thumb  ='/' + val.path;

          },      
        
    },

 
    methods: {

        openGallery(index) {
                 this.$refs.lightbox.showImage(0)
            }   ,  
           openModal : function(){

           $('#box-widget').boxWidget('collapse')

            this.$nextTick(function () { 

                this.newRegistro.codigo = this.selectRegistro.codigo;
                this.newRegistro.nombre = this.selectRegistro.nombre_fantasia;
                this.newRegistro.razon_social = this.selectRegistro.razon_social;
                this.newRegistro.tel = this.selectRegistro.tel;
                this.newRegistro.email = this.selectRegistro.email;
                this.newRegistro.direccion = this.selectRegistro.direccion;
                this.newRegistro.cp = this.selectRegistro.cp;
                this.newRegistro.path = this.selectRegistro.path;
                this.provincia=this.selectRegistro.localidad.provincia;
                this.localidad=this.selectRegistro.localidad;
                this.contacto = {
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
                    },
                this.images[0].src ='/' + this.selectRegistro.path;
                this.images[0].thumb  ='/' + this.selectRegistro.path;  
                this.TablaContactos = this.selectRegistro.contactos;
                this.selectedFile =  null,      
                $('#editar').modal('show');    
                this.$forceUpdate();    
            })
            },

            getProvincias : function(){
                
                this.$store.dispatch('loadProvincias');

            },

            getLocalidades : function(){

                this.localidad ='';
                this.$store.dispatch('loadLocalidades',this.provincia.id);
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

                if(FileSize > (0.15) ){
                    event.preventDefault();
                    toastr.error('Archivo demasiado grande. (Max 150 KB)');
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
               
               fd.append('logo-cliente',this.selectedFile);
              
               axios.defaults.baseURL = this.url;     
               var url = 'storage/logo-cliente';
               console.log(fd);

               axios.post(url,fd,settings)
               .then (response => {                                
                  this.newRegistro.path = response.data;      
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

            AddContacto : function(){

                 if(this.contacto.nombre == ''){
                     toastr.error('El campo Nombre es obligatorio');
                     return;
                }else if(this.contacto.cargo == ''){
                     toastr.error('El campo Cargo es obligatorio');
                     return;
                }else if(this.contacto.tel == ''){
                     toastr.error('El campo Teléfono es obligatorio');
                     return;
                }

                this.TablaContactos.push({
                    ...this.contacto
                });

                this.contacto.nombre = '';
                this.contacto.cargo = '';
                this.contacto.tel = '';
                this.contacto.email = '';
            },

            RemoveContacto : function(index){
                 this.TablaContactos.splice(index, 1);         
            },

            selectPosContacto :function(index){

            this.indexDetalle = index ;
          
           
           },


            storeRegistro: function(){           

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'clientes/' + this.selectRegistro.id;                      
                axios.put(urlRegistros, {   
                
                'codigo'        :this.newRegistro.codigo, 
                'nombre'        : this.newRegistro.nombre, 
                'razon_social'  : this.newRegistro.razon_social, 
                'tel'           : this.newRegistro.tel, 
                'email'         :this.newRegistro.email, 
                'direccion'     :this.newRegistro.direccion, 
                'cp'            : this.newRegistro.cp,   
                'path'          : this.newRegistro.path,   
                'provincia'     : this.provincia,          
                'localidad'     : this.localidad,  
                'contactos'     :this.TablaContactos,
                  
                  
                }).then(response => {
                  console.log(response.data);   
                  this.$emit('update');
                  this.errors=[];
                  $('#editar').modal('hide');
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