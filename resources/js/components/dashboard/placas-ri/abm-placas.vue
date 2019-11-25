<template>
    <div>
        <div class="col-sm-10">
            <a href="#" class="btn btn-primary pull-right" v-on:click.prevent="openNuevoRegistro()" >Nuevo</a>
        </div>
        
        <div class="col-sm-10">
            <component :is= setTablaComponente :registros="registros"  @confirmarDelete="confirmDeleteRegistro" @editRegistroEvent="editRegistro"/>    
            <delete-registro :datoDelete="datoDelete" :fillRegistro="fillRegistro" @close-modal="getRegistros" :modelo="modelo"></delete-registro>  

        </div>         
 
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
                            
                            <div class="form-group">
                                <label  for="tipo">Descripción (*)</label>
                                <input type="text" id="descripcion" class="form-control" v-model="newRegistro.descripcion">    
                            </div>                             
                           
                           
                            <div class="form-group">                           
                               <input type="file" class="form-control" id="inputFile" ref="inputFile1" name="file" @change="onFileSelected($event)">
                               <button class="hide" @click.prevent="onUpload()" >upload</button>                            
                            </div>   

                            <p>Formatos soportados : dcm.</p>
                             <div class="form-group">  
                              <div v-if="newRegistro.path">  
                                   <a :href="AppUrl + '/' + newRegistro.path" target="_blank" class="btn btn-default btn-sm" title="descargar"><span class="fa fa-download"></span></a>
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
                    <!-- End Modal     
                    <loading :active.sync="isLoading_file"           
                             :is-full-page="fullPage">
                     </loading> -->   
                </div>
            </div>

        </form>

        <loading :active.sync="isLoading"           
                :is-full-page="fullPage">
        </loading>
    </div>    
</template>

<script>
require('vue-image-lightbox/dist/vue-image-lightbox.min.css')
import {mapState} from 'vuex'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    name: 'abm-doc',
      props : {         
          modelo : {
            type : String,
            required : true,
            default : ''
          },
          informe_id_data : {
          type: Number,      
          required: false
          },
      },

      components: {
            Loading,
        },

      data() { return {

        editmode: false,
        fillRegistro: {},
        datoDelete: '',
        registros: [],     
        newRegistro : {  
            descripcion  : '',
            path : '',            
               
         },   

         isLoading: false,
         fullPage: false,
         isLoading_file: false,     
         uploadPercentage: 0,   
      
         errors:[],
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

      created : function(){

            this.getRegistros();
      },  
       
    computed :{

         setTablaComponente : function(){

             return 'table-' + this.modelo ;
         },       
         
         ...mapState(['url','AppUrl'])
     },
     
    methods :{
        
    openNuevoRegistro : function(){      
            
           this.editmode = false; 
           this.uploadPercentage = 0;   

           this.newRegistro = {  
                descripcion  : '',
                path : '',            
             };
         
           this.$refs.inputFile1.type = 'text';
           this.$refs.inputFile1.type = 'file';  
           this.selectedFile =  null    
           $('#nuevo').modal('show');    
           }, 

    getRegistros : function(){

            this.isLoading = true;
            axios.defaults.baseURL = this.url ;
            var urlRegistros = this.modelo + '/informe/' + this.informe_id_data;      
          
            axios.get(urlRegistros).then(response =>{
                this.registros = response.data;
                this.isLoading = false;
            });
        },

    onFileSelected(event) {         
          
            this.isLoading_file = true;  
            this.HabilitarGuardar = false;          

            this.selectedFile = event.target.files[0];
         
            let FileSize = this.selectedFile.size / 1024 / 1024; // in MB           
            let FileType=this.selectedFile.type;         
            console.log(FileType);

          
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
               
               fd.append('placas',this.selectedFile);
              
               axios.defaults.baseURL = this.url;     
               var url = 'storage/placas';
               console.log(fd);

               axios.post(url,fd,settings)
               .then (response => { 
                  console.log(response.data);                              
                  this.newRegistro.path = response.data;      
                  this.isLoading_file = false   
                  this.HabilitarGuardar = true;   
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
            var urlRegistros = 'placas_ri';  
                        
            axios.post(urlRegistros, {   
     
            'descripcion'        : this.newRegistro.descripcion,
            'path'               : this.newRegistro.path,
            'informe_id'         : this.informe_id_data,   
                

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
            var urlRegistros = 'placas_ri/' + this.newRegistro.id;                  
            axios.put(urlRegistros, {   
                
            'descripcion'        : this.newRegistro.descripcion,
            'path'               : this.newRegistro.path,
            'informe_id'          : this.informe_id_data,         
                

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
                this.selectedFile =  null,      
                $('#nuevo').modal('show');  
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