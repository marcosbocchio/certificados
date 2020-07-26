<template>
    <div>       
        <form> 
            <div class="form-group">                           
                <input type="file" class="form-control" id="inputFile" ref="inputFile1" name="file" @change="onFileSelected($event)">
                <button class="hide" @click.prevent="onUpload()" >upload</button>                            
            </div>   
            <div  v-if="mostrar_formatos_soportados">
             
                 <p style="display:inline">Formatos: </p> 
                 <div style="display:inline" v-for="(formato,k) in tipos_archivo_soportados" :key="k">

                      {{formato}}
                      
                     <div style="display:inline" v-if="k < tipos_archivo_soportados.length-1">
                         ,
                     </div>
                  </div>  
             
            </div>
            <div v-if="!isPdf && path">
                
                 <a class="btn btn-default btn-xs" @click="DeleteArchivo">x</a> 

            </div>
            <div class="form-group">  
                <div v-if="isPdf && path">

                    <a v-if="!path_requerido_sn"  class="btn btn-default btn-xs" @click="DeleteArchivo"><span>x</span ></a><br>
                    <a style="margin-top: 5px;" :href="'/' + path" target="_blank" class="btn btn-default btn-sm" title="pdf"><span class="fa fa-file-pdf-o"></span></a>
                </div> 
                <div v-else-if="!esImagen() && path">
                      <a  style="margin-top: 5px;" :href="'/' + path" target="_blank" class="btn btn-default btn-xs" title="descargar"><span class="fa fa-download"></span></a>
                </div>
                <div v-else-if="path">                            
                    <img :src="'/' + path" class="margin zoom-in"  @click="openGallery()" alt="..." width="140" >
                    <LightBox :images="images"  ref="lightbox"  :show-light-box="false" ></LightBox>    
                </div>                                                     
            
            <progress-bar
            :options="options"
            :value="uploadPercentage"
            style="margin-top:5px;"
            /> <br/>
            </div>
        </form>        
    </div>    
</template>

<script>
require('vue-image-lightbox/dist/vue-image-lightbox.min.css')
import {mapState} from 'vuex';
import LightBox from 'vue-image-lightbox';
import {eventNewRegistro, eventDeleteFile } from '../components/event-bus';

export default {

    name: 'subir-imagen',

     props : {   

          ruta : {
            type : String,
            required : true,          
          },

          tipos_archivo_soportados : {
            type : Array,
            required : false,   
            default:[],       
          },

          max_size :{

              type: Number,
              required:true,

          },

          path_inicial: {
            type : String,
            required : false,   
            default :'',       
          },
          
          mostrar_formatos_soportados :{

             type: Boolean,
             required : false,
             default : true,   
          },

          path_requerido_sn : {

            type:Boolean,
            require:true,
            default:false,

          }
       
      },
   
    components: {       
        
        LightBox
    },

      data() { return {

      path : this.path_inicial,

       images:[
                {
                
                    src: '',
                    thumb: '',
                    caption: 'caption to display. receive <html> <b>tag</b>', // Optional
                
                }
            ]   ,
            
            
        fullPage: false,     
        uploadPercentage: 0,
        isPdf: false,    
        extension : '',        
        errors:[],   
        selectedFile : null,        

         options: {
            
            layout: {
                height: 20,
                width: 150,    
                verticalTextAlign: 74,    
                progressPadding: 0,               
                },            
            },
        }
    },   

   created :function(){

       eventDeleteFile.$on('delete', this.DeleteArchivo);     
       this.images[0].src ='/' + this.path_inicial;
       this.images[0].thumb  ='/' + this.path_inicial;
       this.getExtension(this.path_inicial);
   },
     

      
    watch : {

        path_inicial : function(val){
            
            this.getExtension(val);
        },
        
        path : function(val) {

            this.images[0].src ='/' + val;
            this.images[0].thumb  ='/' + val;
        },      
        
    },
       
    computed :{    
         
         ...mapState(['url'])
     },
     
    methods :{ 

    openGallery(index) {
      this.$refs.lightbox.showImage(0)
    } , 

    esImagen(){

        if(this.extension == 'jpg' || this.extension == 'bmp' || this.extension == 'png' || this.extension == 'jpeg'){
            return true;
        }else{
            return false;
        }
    },

    getExtension(val){

        this.path = val;

            if(val){

                let extension = (val.substring(val.lastIndexOf(".") + 1)).toLowerCase();
                if(extension == 'pdf'){
                    
                    this.isPdf = true;
                    
                }

                this.extension = extension;
            }

    }, 
  

    onFileSelected(event) {          

           this.selectedFile = event.target.files[0];
            let fileName = this.selectedFile.name;
            let FileSize = this.selectedFile.size / 1024  // in KB           
            let FileType=this.selectedFile.type;      
            let extension = (fileName.substring(fileName.lastIndexOf(".") + 1)).toLowerCase();
            this.extension = extension;
            let aceptado = false;
            console.log(extension);
            this.tipos_archivo_soportados.forEach(function(item) {
                if (item == extension){
                    aceptado = true;                  
                }
            });
          
          if(aceptado){

               if (FileType == 'application/pdf') {
                   this.isPdf = true;
                }else {
                  this.isPdf = false;
                }
          }else{

            toastr.error('El tipo de archivo no es aceptado');
            this.$refs.inputFile1.type = 'text';
            this.$refs.inputFile1.type = 'file';  
            this.selectedFile = null;
            return;
            
            } 
            if(FileSize > this.max_size ){
                 event.preventDefault();
                 toastr.error('Archivo demasiado grande. (Max ' + this.max_size + ' KB)');
                 this.$refs.inputFile1.type = 'text';
                 this.$refs.inputFile1.type = 'file';  
                 this.selectedFile = null;
                 this.uploadPercentage = 0;
            }else{

                this.onUpload();   

            } 
         
        },
        onUpload() {

              
              let settings = { headers: { 'content-type': 'multipart/form-data' }, onUploadProgress: function( progressEvent ) {
                                                                                    this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
                                                                                    }.bind(this) }
               const fd = new FormData();               
               fd.append('archivo',this.selectedFile);              
              // fd.append('path',this.path_storage);

               axios.defaults.baseURL = this.url;     
               var url = 'storage/' + this.ruta;
               console.log(fd);

               axios.post(url,fd,settings)
               .then (response => {                                
                  this.path = response.data;           
                  this.images[0].src ='/' + response.data;
                  this.images[0].thumb  ='/' + response.data;     
                  this.$emit('path',response.data);
               }).catch(response => {
                   this.errors = error.response.data.errors;                   
                })

            }, 

    DeleteArchivo(){

        this.$refs.inputFile1.type = 'text';
        this.$refs.inputFile1.type = 'file';  
        this.path = '';
        this.selectedFile = null;
        this.uploadPercentage = 0;
        this.$emit('path',this.path);

    }
}

}


</script>

<style scoped>

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}


</style>
