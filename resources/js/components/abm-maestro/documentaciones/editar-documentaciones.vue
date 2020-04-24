<template>
    <form v-on:submit.prevent="updateRegistro(registro_id)" method="post">
        <div class="modal fade" id="edit">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar</h4>
                    </div>
                    <div class="modal-body">
                         <div class="form-group">
                            <label>Tipo Documentos</label>
                            <v-select v-model="tipo_documento" label="descripcion" :options="tipo_documentos"></v-select>   
                         </div>      
                         <div class="form-group">
                            <label for="name">Título</label>
                            <input type="text" name="titulo" class="form-control" v-model="documentacion.titulo" value="">               
                        </div>  
                         <div class="form-group">
                            <label for="name">Descripción</label>
                            <input type="text" name="descripcion" class="form-control" v-model="documentacion.descripcion" value="">  
                         </div>
                         <div v-if="tipo_documento.tipo == 'U'">
                             <div class="form-group">
                               <label for="name">Usuario</label>
                               <v-select v-model="documentacion.usuario" label="name" :options="usuarios"></v-select>
                            </div>
                            <div class="form-group">
                               <label for="name">Método de Ensayo</label>
                               <v-select v-model="documentacion.metodo_ensayo" label="metodo" :options="metodo_ensayos"></v-select>
                            </div>
                            <div class="form-group">
                            <label for="fecha">Fecha</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                        <Datepicker v-model="documentacion.fecha_caducidad" :input-class="'form-control pull-right'" :language="es"></Datepicker>   
                                </div>
                            </div>                               
                         </div>
                         <div class="form-group">                           
                            <input type="file" class="form-control" id="inputFile" name="file" @change="onFileSelected($event)">
                            <button class="hide" @click.prevent="onUpload()" >upload</button>
                        </div>                
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Actualizar">
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
import { eventEditRegistro } from '../../event-bus';
  export default {
   
    props : {
      registro_id : null
    },      
  
    data (){ return{

         tipo_documento : {
                tipo:'',
                descripcion : '',
            },   

        tipo_documentos :[
            { 
                tipo : 'I' ,
                descripcion : 'Institucional',
            },
            {
                tipo : 'P',
                descripcion: 'Procedimiento'
            },
            {
                tipo :'U',
                descripcion:  'Usuario'
            }
         ],
         en: en,
         es: es, 
         errors: {},
         metodo_ensayos:[],
         metodo_ensayo :{},
         usuario :{},
         usuarios:[],
         selectedFile : null,  

        documentacion :{
            tipo:'',
            titulo: '',
            descripcion  : '',
            path : '',            
            fecha_caducidad:'',
            id:'',
            user_id:'',
            fecha_caducidad:'',
            metodo_ensayo_id:'',

        },
     
    } 
            
    },

    created : function(){

        eventEditRegistro.$on('edit', this.openModal),
        this.getMetodosEnsayos();
        this.getUsuarios();      

      },

    watch :{

        registro_id :{
            handler : function(){               
                
                 this.getDocumentacion();   
                    
                 this.$nextTick(function () {
                   
                    this.tipo_documentos.forEach(function(tipo_doc) {        
                    
                            if (tipo_doc.tipo == this.documentacion.tipo){
                                this.tipo_documento.tipo = tipo_doc.tipo;
                                this.tipo_documento.descripcion = tipo_doc.descripcion;
                            }
                          }
                        )  

                })                    
               
            },
        }
    },

    computed :{
    
         ...mapState(['url'])
    },

    methods: { 
        
        openModal : function(){
          
            $('#edit').modal('show');      
                
        },

        getDocumentacion : function(){
            
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'documentaciones/' + this.registro_id + '?api_token=' + Laravel.user.api_token;    
           
            axios.get(urlRegistros).then(response =>{
                
            this.documentacion = response.data[0];
               
            });   
            
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
    }
}


</script>