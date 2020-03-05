<template>
    <div>
        <!-- small box -->
        <div class="small-box bg-custom-3">
            <div class="inner">
                <h3>{{ registros.length }}</h3>
                <p>Procedimientos </p>
            </div>
            <div class="icon">
                <i class="fas fa-radiation-alt"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>

         <div v-show="$can('M_documentaciones_edita')">
              <button class="btn btn-primary pull-left" v-on:click.prevent="openNuevoRegistro()">Nuevo</button>      
         </div>

        <div class="clearfix"></div>    
       
            <component :is= setTablaComponente :registros="registros"  @confirmarDelete="confirmDeleteRegistro" @editRegistroEvent="editRegistro" :loading="isLoading"/>    
            <delete-registro :datoDelete="datoDelete" :fillRegistro="fillRegistro" @close-modal="getRegistros" :modelo="modelo"></delete-registro>  
     
        <div class="clearfix"></div>    

        <!--  Modal -->
        <form v-on:submit.prevent="editmode ? updateRegistro() : storeRegistro()">
            <div class="modal fade" id="nuevo">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                           <div v-if="editmode">
                                <h4 class="modal-title">Editar</h4>
                            </div>
                            <div v-else>
                                 <h4 class="modal-title">Crear</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div v-if="modelo == 'ot_procedimientos_propios'"> 
                                <div class="form-group">
                                    <label  for="tipo">Tipo Documento (*)</label>
                                    <input type="text" id="tipo" class="form-control" v-model="newRegistro.tipo" disabled>    
                                </div>                             
                            </div>
                            <div v-else>
                                 <div class="form-group">
                                   <label  for="tipo">Tipo Documento (*)</label>
                                   <v-select v-model="newRegistro.tipo" label="tipo" :options="tipo_documentos"></v-select>
                                </div>                             
                            </div>      
                            <div class="form-group">
                                <label for="name">Título (*)</label>
                                <input type="text" name="titulo" class="form-control" v-model="newRegistro.titulo" value="">               
                            </div>  
                            <div class="form-group">
                                <label for="name">Descripción </label>
                                <input type="text" name="descripcion" class="form-control" v-model="newRegistro.descripcion" value="">  
                            </div>
                            <div v-if="newRegistro.tipo == 'USUARIO'">
                                <div class="form-group">
                                    <label for="name">Usuario (*)</label>
                                    <v-select v-model="usuario" label="name" :options="usuarios"></v-select>
                                </div>
                            </div>
                            <div v-if="newRegistro.tipo == 'USUARIO' |newRegistro.tipo == 'PROCEDIMIENTO' |newRegistro.tipo == 'PROCEDIMIENTO GENERAL' ">
                                <div class="form-group">
                                    <label for="name">Método de Ensayo</label>
                                    <v-select v-model="metodo_ensayo" label="metodo" :options="metodo_ensayos"></v-select>
                                </div>
                            </div>    
                            <div v-if="newRegistro.tipo == 'USUARIO'">
                                <div class="form-group">
                                    <label for="fecha">Fecha (*)</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                        </div>
                                            <Datepicker v-model="newRegistro.fecha_caducidad" :input-class="'form-control pull-right'" :language="es"></Datepicker>   
                                    </div>
                                </div>                               
                            </div>
                            <div class="form-group">                           
                               <input type="file" class="form-control" id="inputFile" ref="inputFile1" name="file" @change="onFileSelected($event)">
                               <button class="hide" @click.prevent="onUpload()" >upload</button>                            
                            </div>  
                            <div v-if="newRegistro.tipo =='PROCEDIMIENTO'">
                                <p>Formatos soportados : pdf.</p>
                            </div> 
                            <div v-else>
                                <p>Formatos soportados : jpg, bmp, pdf.</p>
                            </div>
                             <div class="form-group">  
                                 <div v-if="isPdf">
                                    <a :href="AppUrl + '/' + newRegistro.path" target="_blank" class="btn btn-default btn-sm" title="pdf"><span class="fa fa-file-pdf-o"></span></a>
                                 </div> 
                                 <div v-else-if="newRegistro.path != ''">                            
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
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Guardar" :disabled="!HabilitarGuardar">
                            <button type="button" class="btn btn-default" name="button" data-dismiss="modal" >Cancelar</button>                      
                       
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>    
</template>

<script>
require('vue-image-lightbox/dist/vue-image-lightbox.min.css')
import {mapState} from 'vuex'
import Datepicker from 'vuejs-datepicker';
import {en, es} from 'vuejs-datepicker/dist/locale'
import LightBox from 'vue-image-lightbox'

export default {
    name: 'abm-doc',
      props : {         
          modelo : {
            type : String,
            required : true,
            default : ''
          },
          ot_id_data : {
          type: Number,      
           required: false
          },
      },

      components: {
            Datepicker,       
            LightBox,
        },

      data() { return {

       images:[
                {              
                    src: '',
                    thumb: '',
                    caption: 'caption to display. receive <html> <b>tag</b>', // Optional
                
                }
            ]   ,

        editmode: false,
        fillRegistro: {},
        datoDelete: '',
        registros: [],     
        newRegistro : {  
            tipo :'',          
            titulo: '',
            descripcion  : '',
            path : '',            
            fecha_caducidad:'',               
         },   

         isLoading: false,
         fullPage: false,
         isLoading_file: false,     
         uploadPercentage: 0,
         isPdf: false,

         tipo_documentos :[
                          
            'INSTITUCIONAL',
            'OT',    
            'PROCEDIMIENTO GENERAL',          
            'USUARIO'           
         ], 
         en: en,
         es: es,    
      
         errors:[],
         metodo_ensayos:[],
         metodo_ensayo :{
             id:'',
         },
         usuario :{
              id:'',
         },
         usuarios:[],
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

      created : function(){

            this.getRegistros();
            this.getUsuarios();
            this.getMetodosEnsayos();       
      },  
     

      watch : {
          
          newRegistro : function(val) {

                this.images[0].src ='/' + val.path;
                this.images[0].thumb  ='/' + val.path;

          },      
        
    },
       
    computed :{

         setTablaComponente : function(){

             return 'table-' + this.modelo ;
         },       
         
         ...mapState(['url','AppUrl'])
     },
     
    methods :{

    openGallery(index) {
      this.$refs.lightbox.showImage(0)
    }   , 
        
    openNuevoRegistro : function(){      
            
           this.editmode = false; 
           this.uploadPercentage = 0;   
           this.metodo_ensayo ={
                id:'',
            };
            
           if(this.newRegistro.tipo == 'PROCEDIMIENTO'){

               this.newRegistro = {  
                    tipo :'PROCEDIMIENTO',          
                    titulo: '',
                    descripcion  : '',
                    path : '',            
                    fecha_caducidad:'',               
                    };
           }else{
               this.newRegistro = {  
                    tipo :'',          
                    titulo: '',
                    descripcion  : '',
                    path : '',            
                    fecha_caducidad:'',               
                    };
           }      
           this.$refs.inputFile1.type = 'text';
           this.$refs.inputFile1.type = 'file';  
           this.selectedFile =  null    
           $('#nuevo').modal('show');    
           }, 

    getRegistros : function(){

        this.isLoading = true;
        axios.defaults.baseURL = this.url ;
        if(this.modelo == 'ot_procedimientos_propios'){

            this.newRegistro.tipo='PROCEDIMIENTO';
        }
        if(this.newRegistro.tipo == 'PROCEDIMIENTO'){
            var urlRegistros = this.modelo + '/ot/' + this.ot_id_data;      
        }else{
           var urlRegistros = this.modelo;      
        }
        axios.get(urlRegistros).then(response =>{
            this.registros = response.data;
            this.isLoading = false;
        });
        },

    getMetodosEnsayos: function(){
             
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'metodo_ensayos' + '?api_token=' + Laravel.user.api_token;        
        axios.get(urlRegistros).then(response =>{
        this.metodo_ensayos = response.data
        });
        },

    onFileSelected(event) {         
          
            this.isLoading_file = true;  
            this.HabilitarGuardar = false;          

            this.selectedFile = event.target.files[0];
         
            let FileSize = this.selectedFile.size / 1024 / 1024; // in MB           
            let FileType=this.selectedFile.type;         
            console.log(FileType);

            if(this.newRegistro.tipo == 'PROCEDIMIENTO') {

                if (FileType != 'application/pdf') {
               
                        toastr.error('El tipo de archivo no es aceptado ');
                        this.$refs.inputFile1.type = 'text';
                        this.$refs.inputFile1.type = 'file';  
                        this.selectedFile = null;
                        return;     
                }

            }

            if (FileType == 'application/pdf') {
                this.isPdf = true;
            }else if(FileType == 'image/jpeg' || FileType == 'image/bmp') {
                    this.isPdf = false;
            }else {
                    toastr.error('El tipo de archivo no es aceptado ');
                    this.$refs.inputFile1.type = 'text';
                    this.$refs.inputFile1.type = 'file';  
                    this.selectedFile = null;
                    return;     
             }
          
            console.log(this.selectedFile);

            if(FileSize > 20 ){
                 event.preventDefault();
                 toastr.error('Archivo demasiado grande. (Max 20 MB)');
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
               
               fd.append('documento',this.selectedFile);
              
               axios.defaults.baseURL = this.url;     
               var url = 'storage/documento';
               console.log(fd);

               axios.post(url,fd,settings)
               .then (response => {                                
                  this.newRegistro.path = response.data;      
                  this.isLoading_file = false   
                  this.HabilitarGuardar = true;   
                  this.images[0].src ='/' + response.data;
                  this.images[0].thumb  ='/' + response.data;     
               }).catch(response => {
                   this.errors = error.response.data.errors;
                   this.isLoading_file = false   
                   this.HabilitarGuardar = true;            
                })

            },

    getUsuarios: function(){
            
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'users' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.usuarios = response.data
            });
            },

    storeRegistro: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'documentaciones';  
                        
            axios.post(urlRegistros, {   
                
            'tipo'               : this.newRegistro.tipo,
            'titulo'             : this.newRegistro.titulo,
            'descripcion'        : this.newRegistro.descripcion,
            'usuario'            : this.usuario,         
            'metodo_ensayo'      : this.metodo_ensayo,   
            'fecha_caducidad'    : this.newRegistro.fecha_caducidad,
            'path'               : this.newRegistro.path,
            'ot_id'              : this.ot_id_data,   
                

            }).then(response => {              
                this.errors=[];
                $('#nuevo').modal('hide');
                this.newRegistro = {},               
                toastr.success('Nuevo registro creado con éxito');  
                this.getRegistros();              
                
             }).catch(error => {
               
               this.errors = error.response.data.errors;
                console.log(error.response);
               $.each( this.errors, function( key, value ) {
                   toastr.error(value);
                   console.log( key + ": " + value );
               });

               if((typeof(this.errors)=='undefined') && (error)){

                     toastr.error("Ocurrió un error al procesar la solicitud");                     
                  
                }

           });  
        },   
        
    updateRegistro: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'documentaciones/' + this.newRegistro.id;                  
            axios.put(urlRegistros, {   
                
            'tipo'               : this.newRegistro.tipo,
            'titulo'             : this.newRegistro.titulo,
            'descripcion'        : this.newRegistro.descripcion,
            'usuario'            : this.usuario,         
            'metodo_ensayo'      : this.metodo_ensayo,   
            'fecha_caducidad'    : this.newRegistro.fecha_caducidad,
            'path'               : this.newRegistro.path,
            'ot_id'              : this.ot_id_data,         
                

            }).then(response => {              
                this.errors=[];
                $('#nuevo').modal('hide');
                this.newRegistro = {},               
                toastr.success('Nuevo registro creado con éxito');  
                this.getRegistros();              
                 console.log(response);
                
             }).catch(error => {
               
               this.errors = error.response.data.errors;
                console.log(error.response);
               $.each( this.errors, function( key, value ) {
                   toastr.error(value);
                   console.log( key + ": " + value );
               });

               if((typeof(this.errors)=='undefined') && (error)){

                     toastr.error("Ocurrió un error al procesar la solicitud");                     
                  
                }

           });  



    },

    confirmDeleteRegistro: function(registro,dato){            
              this.fillRegistro.id = registro.id;
              this.datoDelete = dato;             
             $('#delete-registro').modal('show');
          },

    editRegistro : function(registro){

                this.editmode = true;
                this.HabilitarGuardar = true;
                this.newRegistro = {};    
                this.metodo_ensayo={};   
                this.usuario ={};
                this.selectedFile =  null,      
                $('#nuevo').modal('show');  
                this.metodo_ensayo = registro.metodo_ensayo;
                this.usuario = registro.usuario;                
                this.newRegistro = registro;  
                let fileName = this.newRegistro.path ; 
                let FileExt = fileName.substring(fileName.length-3,fileName.length);
                this.isPdf = (FileExt == 'pdf') ? true : false ;      
                    
            },
}
}


</script>

<style scoped>

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}


</style>
