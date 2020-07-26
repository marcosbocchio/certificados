<template>
    <div>
        <div class="col-sm-10">
            <div v-show="$can('T_informes_edita')">
                 <button class="btn btn-enod pull-right" v-on:click.prevent="openNuevoRegistro()">Nuevo </button>
            </div>
        </div>
        <div class="clearfix"></div> 
        <div class="col-sm-10">
            <table-placas :registros="registros"  @confirmarDelete="confirmDeleteRegistro" @editRegistroEvent="editRegistro"></table-placas>
            <delete-registro :datoDelete="datoDelete" :fillRegistro="fillRegistro" @close-modal="getRegistros" :modelo="modelo"></delete-registro>  

        </div>         
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
                            
                            <div class="form-group">
                                <label  for="tipo">Descripción *</label>
                                <input type="text" id="descripcion" class="form-control" v-model="newRegistro.descripcion">    
                            </div>   

                            <div class="form-group" >
                                <subir-imagen                                
                                    :ruta="ruta"                               
                                    :max_size="max_size"
                                    :path_inicial="newRegistro.path"
                                    :tipos_archivo_soportados ="tipos_archivo_soportados"    
                                    :mostrar_formatos_soportados="true"                          
                                    @path="newRegistro.path = $event"
                                ></subir-imagen> 
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
import { eventDeleteFile } from '../../event-bus';
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
      
        ruta: '',    
        max_size :'', //KB
        tipos_archivo_soportados:[],

         isLoading: false,
         fullPage: false,
         isLoading_file: false,         
      
         errors:[],      
         HabilitarGuardar : true,  
        }
    },

      created : function(){

            this.getRegistros();
            this.inicializarParametrosArchivos();
            
      },  
       
    computed :{

         setTablaComponente : function(){

             return 'table-' + this.modelo ;
         },       
         
         ...mapState(['url'])
     },
     
    methods :{

    inicializarParametrosArchivos :  function(){

        if (this.modelo == 'placas_ri'){
            
            this.ruta ='placas_ri';   
            this.max_size =  20000; //KB
            this.tipos_archivo_soportados= ['dcm'];

        }else if(this.modelo == 'placas_us'){

            this.ruta ='placas_us';  
            this.max_size = 50000; //KB
            this.tipos_archivo_soportados = ['rdt','scn','ebwk'];                 

        }
    },    
        
    openNuevoRegistro : function(){      
            
           this.editmode = false;         

           this.newRegistro = {  
                descripcion  : '',
                path : '',            
             };
          eventDeleteFile.$emit('delete');
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

    getUsuarios: function(){
            
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'users' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.usuarios = response.data
            });
            },

    storeRegistro: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = this.modelo;  
                        
            axios.post(urlRegistros, {   
     
                'descripcion'        : this.newRegistro.descripcion,
                'path'               : this.newRegistro.path,
                'informe_id'         : this.informe_id_data,   
                

            }).then(response => {              
                this.errors=[];
                $('#nuevo').modal('hide');

                this.newRegistro ={  
                    descripcion  : '',
                    path : '',                                          
                };          

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
            var urlRegistros = this.modelo + '/' + this.newRegistro.id;                  
            axios.put(urlRegistros, {   
                
            'descripcion'        : this.newRegistro.descripcion,
            'path'               : this.newRegistro.path,
            'informe_id'          : this.informe_id_data,         
                

            }).then(response => {              
                this.errors=[];
                $('#nuevo').modal('hide');
                this.newRegistro ={  
                    descripcion  : '',
                    path : '',                                          
                };            
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
                    
            },
}
}


</script>

<style scoped>

    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        background-color: #eee;
    }

</style>