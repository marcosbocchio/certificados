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
                            <label>Tipo Documentos</label>
                            <v-select v-model="tipo_documento" label="descripcion" :options="tipo_documentos"></v-select>   
                         </div>      
                         <div class="form-group">
                            <label for="name">Título</label>
                            <input type="text" name="titulo" class="form-control" v-model="newRegistro.titulo" value="">               
                        </div>  
                         <div class="form-group">
                            <label for="name">Descripción</label>
                            <input type="text" name="descripcion" class="form-control" v-model="newRegistro.descripcion" value="">  
                         </div>
                         <div v-if="tipo_documento.tipo == 'U'">
                             <div class="form-group">
                               <label for="name">Usuario</label>
                               <v-select v-model="usuario" label="name" :options="usuarios"></v-select>
                            </div>
                            <div class="form-group">
                               <label for="name">Método de Ensayo</label>
                               <v-select v-model="newRegistro.metodo_ensayo" label="metodo" :options="metodo_ensayos"></v-select>
                            </div>
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
                            <button class="hide" @click.prevent="onUpload($event)" >upload</button>
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

import {mapState} from 'vuex'
import Datepicker from 'vuejs-datepicker';
import {en, es} from 'vuejs-datepicker/dist/locale'
import { eventNewRegistro } from '../../event-bus';
export default {

    components: {
      Datepicker
  },

    data() { return {
            
        newRegistro : {            
            titulo: '',
            descripcion  : '',
            path : '',            
            fecha_caducidad:'',            
            
         },
         en: en,
         es: es, 
         tipo_documento : {
                tipo:'',
                descripcion : '',
            },        
         tipo_documentos :[
            { 
                tipo : 'I' ,
                descripcion : 'Institucionales',
            },
            {
                tipo : 'P',
                descripcion: 'Procedimientos'
            },
            {
                tipo :'U',
                descripcion:  'Usuarios'
            }
         ]
         ,      
         errors: {},
         metodo_ensayos:[],
         metodo_ensayo :{},
         usuario :{},
         usuarios:[],
         selectedFile : null,
      

      
        }
    },

   created: function () {
    eventNewRegistro.$on('open', this.openModal),
    this.getMetodosEnsayos();
    this.getUsuarios();
  
    },
    computed :{
    
         ...mapState(['url'])
    },
 
    methods: {

        openModal : function(){
            this.newRegistro={};
            $('#nuevo').modal('show');    
                
        },

        getMetodosEnsayos: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'metodo_ensayos' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.metodo_ensayos = response.data
                });
              },

        getUsuarios: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'users' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.usuarios = response.data
                });
              },

        onFileSelected(event) {

            this.selectedFile = event.target.files[0];
            this.onUpload();      

               
        },
        onUpload() {
              let settings = { headers: { 'content-type': 'multipart/form-data' } }
               const fd = new FormData();
               
               fd.append('documento',this.selectedFile);
              
               axios.defaults.baseURL = this.url;     
               var url = 'storage/documento';
               console.log(fd);
               axios.post(url,fd,settings)
               .then (response => {
                                
                  this.newRegistro.path = response.data;          
               }).catch(response => {
                    console.log(response)
                })

            },

        storeRegistro: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'documentaciones';  
                        
            axios.post(urlRegistros, {   
                
            'tipo'    : this.tipo_documento.tipo,
            'titulo'  : this.newRegistro.titulo,
            'descripcion'  : this.newRegistro.descripcion,
            'usuario_id'   : this.usuario.id, 
            'metodo_ensayo_id' : this.metodo_ensayo.id,
            'fecha_caducidad' : this.newRegistro.fecha_caducidad,
            'path'            : this.newRegistro.path      
                

            }).then(response => {
                this.$emit('store');
                this.errors=[];
                $('#nuevo').modal('hide');               
                toastr.success('Nuevo registro creado con éxito');
                
                
            }).catch(error => {
               
                this.errors = error.response.data.errors;

                $.each( this.errors, function( key, value ) {
                    toastr.error(value,key);
                    console.log( key + ": " + value );
                });

            });

        }
    }
}
</script>


