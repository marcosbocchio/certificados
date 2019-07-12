<template>
    <form v-on:submit.prevent="storeRegistro" method="post">
        <div class="modal fade" id="nuevo">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Crear</h4>
                    </div>
                    <div class="form-group">
                        <label>Tipo Documentos</label>
                        <v-select :options="tipo_documentos"></v-select>   
                    </div>  
                    <div class="modal-body">
                        <label for="name">Título</label>
                        <input type="text" name="titulo" class="form-control" v-model="newRegistro.titulo" value="">               
                    </div>
                    <div class="modal-body">
                        <label for="name">Descripción</label>
                        <input type="text" name="descripcion" class="form-control" v-model="newRegistro.descripcion" value="">               
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
import { eventNewRegistro } from '../../event-bus';
export default {

    data() { return {
    
        newRegistro : {
            'tipo' :'',
            'titulo': '',
            'descripcion'  : '',
            'path' : '',
            
         },
         tipo_documento :[
            { 
                tipo : 'I' ,
                descripcion:'Documentos Institucionales Enod'
            },
            {
                tipo : 'P',
                descripcion:'Documentos Procedimientos Propios Enod'
            },
            {
                tipo:'U',
                descripcion:'Documentos Usuarios Enod'
            }
         ]
         ,
        errors: {}
      
        }
    },

   created: function () {
    eventNewRegistro.$on('open', this.openModal)
  
    },
    computed :{
    
         ...mapState(['url'])
    },
 
    methods: {

        openModal : function(){
            this.newRegistro={};
            $('#nuevo').modal('show');    
                
        },

        storeRegistro: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'materiales';  
                        
            axios.post(urlRegistros, {   
                
            'codigo'    : this.newRegistro.codigo,
            'descripcion'  : this.newRegistro.descripcion
                

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


