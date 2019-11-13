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

                    <label for="codigo">Nombre (*)</label>                   
                    <input autocomplete="off" v-model="newRegistro.name" type="text" name="codigo" class="form-control" value="">
                    
                    <label for="name">Guard (*)</label>                   
                    <v-select v-model="newRegistro.guard_name" :options="guards"></v-select>

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
            'name': '',
            'guard_name'  : '',
         },

         guards:['web','api'],
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

            this.newRegistro=
            { 'name': '',
              'guard_name'  : ''}

            $('#nuevo').modal('show');    
                
        },

        storeRegistro: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'permissions';  
                        
            axios.post(urlRegistros, {   
                
            ...this.newRegistro,
         
                

            }).then(response => {
                this.$emit('store');
                this.errors=[];
                $('#nuevo').modal('hide');               
                toastr.success('Permiso creado con éxito');
                
                
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