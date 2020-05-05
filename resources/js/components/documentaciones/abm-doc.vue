<template>
    <div>
        <!-- small box -->
        <div class="col-lg-12">
            <div class="small-box bg-custom-3">
                <div class="inner">
                    <h3  v-if="modelo == 'ot_procedimientos_propios'">{{ CantProcedimientos }}</h3>
                    <h3  v-if="modelo == 'documentaciones'">{{ CantDocumentacionesTotal }}</h3>
                    <div v-if="modelo == 'ot_procedimientos_propios'">
                        <p>Procedimientos </p>
                    </div>
                    <div v-else>
                        <p>Documentaciones </p>
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-radiation-alt"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>          
       
        <div class="form-group">

            <div v-show="$can('M_documentaciones_edita')">
                <div class="col-md-1 col-xs-12">
                    <button class="btn btn-primary pull-left" v-on:click.prevent="openNuevoRegistro()"><span class="fa fa-plus-circle"></span> Nuevo</button>      
                </div>
                
            </div>  
            <div v-show="modelo=='documentaciones'">

                <div class="form-group">           
                    <div class="col-md-3 col-md-offset-4 col-sm-12 col-xs-12">
                        <v-select class="style-chooser" v-model="tipo" :options="['INSTITUCIONAL','OT','PROCEDIMIENTO GENERAL','USUARIO']" id="tipo" placeholder="TODOS" @input="getResults()"></v-select>   
                    </div>
                </div>                       
               
                <div class="col-md-4 col-xs-12 pull-right"> 
                    <div class="input-group">
                        <input type="text" v-model="search" class="form-control" placeholder="Buscar...">
                        <span class="input-group-addon btn" @click="aplicarFiltro()" style="background-color: #F9CA33;"><i class="fa fa-search"></i></span>
                    </div>  
                </div>  

            </div>         
        </div>
       <div class="clearfix"></div>    

        <div class="col-md-12">

            <component :is= setTablaComponente :registros="registros.data"  @confirmarDelete="confirmDeleteRegistro" @editRegistroEvent="editRegistro" :loading="isLoading"/>    
            <delete-registro :datoDelete="datoDelete" :fillRegistro="fillRegistro" @close-modal="getResults" :modelo="modelo"></delete-registro>  

             <pagination 
                  :data="registros" @pagination-change-page="getResults" :limit="3" >
                  <span slot="prev-nav">&lt; Previous</span>
                  <span slot="next-nav">Next &gt;</span> 
             </pagination>   
       </div>
       

        <div class="clearfix"></div>    

        <!--  Modal -->
        <form v-on:submit.prevent="editmode ? updateRegistro() : storeRegistro()">
            <div class="modal fade" id="nuevo" data-backdrop="true">
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
                                    <label  for="tipo">Tipo Documento *</label>
                                    <input type="text" id="tipo" class="form-control" v-model="newRegistro.tipo" disabled>    
                                </div>                             
                            </div>
                            <div v-else>
                                 <div class="form-group">
                                   <label  for="tipo">Tipo Documento *</label>
                                   <v-select v-model="newRegistro.tipo" label="tipo" :options="tipo_documentos"></v-select>
                                </div>                             
                            </div>      
                            <div class="form-group">
                                <label for="titulo">Título *</label>
                                <input type="text" name="titulo" class="form-control" v-model="newRegistro.titulo" value="" @change="VerificarDuplicado()">               
                            </div>  
                            <div class="form-group">
                                <label for="name">Descripción </label>
                                <input type="text" name="descripcion" class="form-control" v-model="newRegistro.descripcion" value="">  
                            </div>
                            <div v-if="newRegistro.tipo == 'USUARIO'">
                                <div class="form-group">
                                    <label for="name">Usuario *</label>
                                    <v-select v-model="usuario" label="name" :options="usuarios" @input="VerificarDuplicado()"></v-select>
                                </div>
                            </div>
                            <div v-if="newRegistro.tipo == 'USUARIO' |newRegistro.tipo == 'PROCEDIMIENTO' |newRegistro.tipo == 'PROCEDIMIENTO GENERAL' ">
                                <div class="form-group">
                                    <label for="name">Método de Ensayo</label>
                                    <v-select v-model="metodo_ensayo" label="metodo" :options="metodo_ensayos">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.metodo }}</span> <br> 
                                            <span class="downSelect"> {{ option.descripcion }} </span>
                                        </template>  
                                    </v-select>
                                </div>  
                            </div>    
                            
                            <div v-if="newRegistro.tipo == 'USUARIO'">
                              
                                <div class="form-group">
                                    <label for="fecha">Fecha caducidad *</label>
                                    <div>                                                                      
                                        <date-picker v-model="newRegistro.fecha_caducidad" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="DD-MM-YYYY" ></date-picker>
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

        <div class="modal fade " tabindex="-1" role="dialog" id="modal-cancelar-continuar" data-keyboard="false" data-backdrop="static" >
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4><span class="fa fa-warning" style="color:#FBCA19;">&nbsp;&nbsp;</span>Alerta</h4>
                    </div>
                <div class="modal-body">
                    <p style="text-align: center;">El registro ingresado ya existe.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cancelarModal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Ignorar</button>
                </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
    </div>    
</template>

<script>
import { toastrWarning,toastrDefault } from '../toastrConfig';
require('vue-image-lightbox/dist/vue-image-lightbox.min.css')
import {mapState} from 'vuex'
import LightBox from 'vue-image-lightbox'
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';

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
        registros: {},     
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
         tipo:'',
         search:'',
         tipo_documentos :[
                          
            'INSTITUCIONAL',
            'OT',    
            'PROCEDIMIENTO GENERAL',          
            'USUARIO'           
         ],       
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

        this.getResults();
        this.getUsuarios();
        this.getMetodosEnsayos();  

      },  

     mounted :function(){

         if(this.modelo == 'documentaciones') {

            this.$store.dispatch('loadContarDocumentacionesTotal');

         }else {

            this.$store.dispatch('loadContarProcedimientos',this.ot_id_data);

         }
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
         
         ...mapState(['url','AppUrl','CantProcedimientos','CantDocumentacionesTotal'])
     },
     
    methods :{

    openGallery(index) {
      this.$refs.lightbox.showImage(0)
    }, 

    aplicarFiltro : function(){

        this.getResults(1);

    },

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

    getResults : function(page = 1){

        this.isLoading = true;
        axios.defaults.baseURL = this.url ;
        if(this.modelo == 'ot_procedimientos_propios'){

            this.newRegistro.tipo='PROCEDIMIENTO';
        }
        if(this.newRegistro.tipo == 'PROCEDIMIENTO'){

            var urlRegistros = this.modelo + '/ot/' + this.ot_id_data + '?page='+ page + '&search=' + this.search;  
           
            this.$store.dispatch('loadContarProcedimientos',this.ot_id_data);

        }else{

           var urlRegistros = this.modelo +'?page='+ page + '&search=' + this.search  + '&tipo=' + this.tipo; 
           console.log(urlRegistros);
            this.$store.dispatch('loadContarDocumentacionesTotal');

        }
        axios.get(urlRegistros).then(response =>{
            console.log(response.data);
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

    VerificarDuplicado:  function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'documentaciones/verificar_duplicados/tipo/'+ this.newRegistro.tipo + '/titulo/'+ this.newRegistro.titulo + '/usuario/' + this.usuario.id + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            
                let res =  response.data;
                if(res.length){                    

                    $('#modal-cancelar-continuar').modal('show');

                }

            });

    },

    cancelarModal : function(){

        this.newRegistro.titulo = '';
        this.newRegistro.descripcion = '';
        this.usuario.descripcion = '';
        this.usuario = {
              id:'',
         },
         $('#modal-cancelar-continuar').modal('hide');
    },

    onFileSelected(event) {         
          
            this.isLoading_file = true;  
            this.HabilitarGuardar = false;          

            this.selectedFile = event.target.files[0];
         
            let FileSize = this.selectedFile.size / 1024 / 1024; // in MB           
            let FileType=this.selectedFile.type;              

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
                this.getResults();              
                
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
                this.getResults();              
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
                this.metodo_ensayo =  registro.metodo_ensayo ? registro.metodo_ensayo : {id :''};
                this.usuario = registro.usuario[0];                
                this.newRegistro = registro;  
                let fileName = this.newRegistro.path ; 
                let FileExt = fileName.substring(fileName.length-3,fileName.length);
                this.isPdf = (FileExt == 'pdf') ? true : false ;  
                this.$refs.inputFile1.type = 'text';
                this.$refs.inputFile1.type = 'file';  
                this.selectedFile =  null        
                $('#nuevo').modal('show');  
            },
}
}


</script>

<style scoped>


.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}


  .style-chooser .vs__search::placeholder,
  .style-chooser .vs__dropdown-toggle,
  .style-chooser .vs__dropdown-menu {
    background: #dfe5fb;
    border: none;
    color: #394066;
    text-transform: lowercase;
    font-variant: small-caps;
  }

  .style-chooser .vs__clear,
  .style-chooser .vs__open-indicator {
    fill: #394066;
  }

  @media (max-width: 970px) {
    .col-xs-12, .col-sm-12 {
        margin-top:10px;
    }
}



</style>
