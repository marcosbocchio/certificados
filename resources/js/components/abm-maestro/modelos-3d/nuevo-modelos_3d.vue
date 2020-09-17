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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="codigo">Código *</label>
                                    <input autocomplete="off" v-model="Registro.codigo" type="text" name="codigo" class="form-control" value="" maxlength="20">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Descripción </label>
                                    <input autocomplete="off" type="text" name="descripcion" class="form-control" v-model="Registro.descripcion" value="" maxlength="100">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group" >
                                    <subir-imagen
                                        :ruta="ruta"
                                        :max_size="max_size"
                                        :path_inicial="Registro.path"
                                        :tipos_archivo_soportados ="tipos_archivo_soportados"
                                        :mostrar_formatos_soportados="true"
                                        @path="Registro.path = $event"
                                    ></subir-imagen>
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

        Registro : {
            'codigo': '',
            'descripcion'  : '',
            'path' : '',
         },

        ruta: 'modelos_3d',
        max_size :30000, //KB
        tipos_archivo_soportados:['obj'],
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
            this.Registro={};
            $('#nuevo').modal('show');

        },

        storeRegistro: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'modelos_3d';

            axios.post(urlRegistros, {

            ...this.Registro


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
