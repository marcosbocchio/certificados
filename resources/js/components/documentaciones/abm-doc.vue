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
                            <h4 class="modal-title">Crear</h4>
                        </div>
                        <div class="modal-body">
                           <div class="form-group">
                                <label>Tipo Documento</label>
                                <v-select v-model="newRegistro.tipo" label="tipo" :options="tipo_documentos"></v-select>   
                            </div>      
                            <div class="form-group">
                                <label for="name">Título</label>
                                <input type="text" name="titulo" class="form-control" v-model="newRegistro.titulo" value="">               
                            </div>  
                            <div class="form-group">
                                <label for="name">Descripción</label>
                                <input type="text" name="descripcion" class="form-control" v-model="newRegistro.descripcion" value="">  
                            </div>
                            <div v-if="newRegistro.tipo == 'USUARIO'">
                                <div class="form-group">
                                    <label for="name">Usuario</label>
                                    <v-select v-model="usuario" label="name" :options="usuarios"></v-select>
                                </div>
                            </div>
                            <div v-if="newRegistro.tipo == 'USUARIO' || newRegistro.tipo == 'PROCEDIMIENTO'">
                                <div class="form-group">
                                    <label for="name">Método de Ensayo</label>
                                    <v-select v-model="metodo_ensayo" label="metodo" :options="metodo_ensayos"></v-select>
                                </div>
                            </div>    
                            <div v-if="newRegistro.tipo == 'USUARIO'">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                        </div>
                                            <Datepicker v-model="newRegistro.fecha_caducidad" :input-class="'form-control pull-right'" :language="es"></Datepicker>   
                                    </div>
                                </div>                               
                            </div>
                            <div class="form-group">                           
                               <input type="file" class="form-control" id="inputFile" name="file" @change="onFileSelected($event)">
                         -     <button class="hide" @click.prevent="onUpload()" >upload</button>  
                            </div>                 
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Guardar">
                            <button type="button" class="btn btn-default" name="button" data-dismiss="modal" >Cancelar</button>
                        </div>
                    </div>
                    <!-- End Modal-->        
                    <loading :active.sync="isLoading_file"           
                             :is-full-page="fullPage">
                     </loading>
                </div>
            </div>

        </form>

        <loading :active.sync="isLoading"           
                :is-full-page="fullPage">
        </loading>
    </div>    
</template>

<script>


import {mapState} from 'vuex'
import Datepicker from 'vuejs-datepicker';
import {en, es} from 'vuejs-datepicker/dist/locale'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    name: 'abm-doc',
      props : {         
          modelo : {
            type : String,
            required : true,
            default : ''
          }
      },

      components: {
            Datepicker,
            Loading
        },

      data() { return {

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

         tipo_documentos :[
                          
            'INSTITUCIONAL',
            'OT',              
            'PROCEDIMIENTO',
            'USUARIO'           
         ], 
         en: en,
         es: es,    
      
         errors:[],
         metodo_ensayos:[],
         metodo_ensayo :{},
         usuario :{},
         usuarios:[],
         selectedFile : null,      
        }
    },

      created : function(){

            this.getRegistros();
            this.getUsuarios();
            this.getMetodosEnsayos();
        
      },
       
    computed :{

         setTablaComponente : function(){

             return 'table-' + this.modelo ;
         },       
         
         ...mapState(['url'])
     },

    methods :{
        
    openNuevoRegistro : function(){

            this.editmode = false;
            this.newRegistro = {};    
            this.metodo_ensayo={};   
            this.usuario ={};
            this.selectedFile =  null,   
             $('#nuevo').modal('show');    
           }, 

    getRegistros : function(){

        this.isLoading = true;
        axios.defaults.baseURL = this.url ;
        var urlRegistros = this.modelo;   
      //  console.log(urlRegistros);
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
            this.$nextTick(function () {
                this.selectedFile = event.target.files[0];
                this.onUpload();   
             });  
          
         
        },
        onUpload() {
              console.log('entro en onupload')   ;
              let settings = { headers: { 'content-type': 'multipart/form-data' } }
               const fd = new FormData();
               
               fd.append('documento',this.selectedFile);
              
               axios.defaults.baseURL = this.url;     
               var url = 'storage/documento';
               console.log(fd);
               axios.post(url,fd,settings)
               .then (response => {                                
                  this.newRegistro.path = response.data;      
                    this.isLoading_file = false          
               }).catch(response => {
                   this.errors = error.response.data.errors;
                    this.isLoading_file = false      
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
            'usuario_id'         : this.usuario.id, 
            'metodo_ensayo_id'   : this.metodo_ensayo.id,
            'fecha_caducidad'    : this.newRegistro.fecha_caducidad,
            'path'               : this.newRegistro.path      
                

            }).then(response => {              
                this.errors=[];
                $('#nuevo').modal('hide');
                this.newRegistro = {},               
                toastr.success('Nuevo registro creado con éxito');  
                this.getRegistros();              
                
            }).catch(error => {
               
                this.errors = error.response.data.errors;
               
                $.each( this.errors, function( key, value ) {
                    toastr.error(value,key);
                    console.log( key + ": " + value );
                });

            });

        },    

    confirmDeleteRegistro: function(registro,dato){            
              this.fillRegistro.id = registro.id;
              this.datoDelete = dato;             
             $('#delete-registro').modal('show');
          },

    editRegistro : function(registro){

                this.editmode = true;
                this.newRegistro = {};    
                this.metodo_ensayo={};   
                this.usuario ={};
                this.selectedFile =  null,      
                $('#nuevo').modal('show');  
                this.newRegistro = registro;                   
                    
            },
}
}
</script>

