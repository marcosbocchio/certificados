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
                            <label for="codigo">Nombre (*)</label>                   
                            <input autocomplete="off" v-model="newRegistro.nombre" type="text" name="codigo" class="form-control" value="">            
                        </div>
                    </div> 
                    <div class="col-md-12">   
                        <div class="form-group">    
                            <label>Logo</label>        
                            <input type="file" class="form-control" id="inputFile" ref="inputFile1" name="file" @change="onFileSelected($event)">
                            <button class="hide" @click.prevent="onUpload()" >upload</button> 
                        </div>                              
                    </div>   
                    <div class="clearfix"></div>
                    <div class="col-md-12">   
                        <div class="form-group">       
                            <p>Formatos soportados : png, bmp, jpg</p>                          
                            <div v-if="newRegistro.path_logo">                            
                                <img :src="'/' + newRegistro.path_logo" class="margin zoom-in"  @click="openGallery()" alt="..." width="120" >
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
import { eventNewRegistro } from '../../event-bus';
export default {

    components: {        
     
        LightBox,
    },

    data() { return {

        error:{},    
        newRegistro : {           
            'nombre'  : '',   
            'logo_path':''                 
         },

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
                progressPadding: 0,               
                },    
        }  
            
      }
    
    },

    watch : {
          
          newRegistro : function(val) {

                this.images[0].src ='/' + val.path_logo;
                this.images[0].thumb  ='/' + val.path_logo;

          },      
        
    },

 created: function () {
     
    eventNewRegistro.$on('open', this.openModal)   
  
    },
    computed :{
    
         ...mapState(['url'])
    },
 
   
    methods: {

           openGallery(index) {
                 this.$refs.lightbox.showImage(0)
            },   

           openModal : function(){

                this.newRegistro = {           
                    'nombre'  : '', 
                    'path_logo'  : '',             
                };           
            
                $('#nuevo').modal('show');    
                      
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
               
               fd.append('logo-contratista',this.selectedFile);
              
               axios.defaults.baseURL = this.url;     
               var url = 'storage/logo-contratista';
               console.log(fd);

               axios.post(url,fd,settings)
               .then (response => {                                
                  this.newRegistro.path_logo = response.data;      
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

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'contratistas';                         
                axios.post(urlRegistros, {   
                    
                ...this.newRegistro,              
                             
                  
                }).then(response => {
                  this.$emit('store');
                  this.errors=[];
                  $('#nuevo').modal('hide');
                  toastr.success('Contratista creado con éxito');               
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