<template>
    <form v-on:submit.prevent="storeRegistro" method="post">
        <div class="modal fade" id="nuevo">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Crear</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-6">    
                            <div class="form-group">
                                <label for="codigo">Nombre (*)</label>                   
                                <input autocomplete="off" v-model="newRegistro.name" type="text" name="codigo" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-6">    
                            <div class="form-group">
                                <label for="name">Guard (*)</label>                   
                                <v-select v-model="newRegistro.guard_name" :options="guards"></v-select>
                            </div>
                        </div>
                    
                        <div class="col-md-12">    
                            <div class="form-group">
                                <div v-for="(permiso,k) in permisos" :key="k" >

                                <div class="col-md-4">
                                    <input type="checkbox" :id=" permiso.name " :value="permiso.name" v-model="rol_permisos" style="float:left"> 
                                    <label for="tipo" style="float:left;margin-left: 5px;">{{ permiso.name }}</label>         
                                </div>     
                                </div>
                             </div>
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
import { eventNewRegistro } from '../../event-bus';
export default {

    data() { return {
    
        newRegistro : {
            'name': '',
            'guard_name'  : '',
         },

         rol_permisos:[],

         guards:['web','api'],
         errors: {}
      
        }
    },

   created: function () {

    eventNewRegistro.$on('open', this.openModal)
    this.$store.dispatch('loadPermisos');
    

    },
    computed :{
    
         ...mapState(['url','permisos'])
    },
 
    methods: {

        openModal : function(){

            this.newRegistro=
            { 'name': '',
              'guard_name'  : ''};       
            this.rol_permisos=[],

            $('#nuevo').modal('show');    
                
        },
     

        storeRegistro: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'roles';  
                        
            axios.post(urlRegistros, {   
                
            ...this.newRegistro,
            permisos : this.rol_permisos,
         
                

            }).then(response => {
                this.$emit('store');
                this.errors=[];
                $('#nuevo').modal('hide');               
                toastr.success('Nuevo Rol creado con éxito');
                
                
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