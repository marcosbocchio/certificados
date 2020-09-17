<template>
    <form v-on:submit.prevent="storeRegistro" method="post">
        <div class="modal fade" id="editar">
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
import { eventEditRegistro } from '../../event-bus';
import { ModelObj } from 'vue-3d-model';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {

     components: {
        ModelObj,
        Loading
    },

    props : {

    selectRegistro : {
        type : Object,
        required : false,
        }

    },

    data() { return {

        Registro : {
            'codigo': '',
            'descripcion'  : '',
            'path' : '',
         },

        ruta: 'modelos_3d',
        max_size :30000, //KB
        tipos_archivo_soportados:['obj'],
        errors: {},

        }
    },

   created: function () {
    eventEditRegistro.$on('editar',function() {

                console.log('entro en el editar del modelo');

                this.openModal();

    }.bind(this));

    },
    computed :{

         ...mapState(['url'])
    },

    methods: {

           openModal : function(){

            this.$nextTick(function () {
                this.Registro.codigo = this.selectRegistro.codigo;
                this.Registro.descripcion = this.selectRegistro.descripcion;
                this.Registro.path = this.selectRegistro.path;
                $('#editar').modal('show');
                this.$forceUpdate();            })
            },

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'modelos_3d/' + this.selectRegistro.id;
                axios.put(urlRegistros, {

                ...this.Registro,

                }).then(response => {
                  this.$emit('update');
                  this.errors=[];
                  $('#editar').modal('hide');
                  this.modalAbierta = false;
                  this.Registro={}

                }).catch(error => {
                    console.log(error);
                    this.errors = error.response.data.errors;
                    $.each( this.errors, function( key, value ) {
                        toastr.error(value);
                        console.log( key + ": " + value );
                    });

                     if((typeof(this.errors)=='undefined') && (error)){

                     toastr.error("Ocurrió un error al procesar la solicitud");

                }
                });
              }
        }
}
</script>
