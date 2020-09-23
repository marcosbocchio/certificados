<template>
    <form v-on:submit.prevent="storeRegistro" method="post">
        <div class="modal fade" id="editar">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar</h4>
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

                            <div v-if="Registro.path">

                                <div class="form-group" >

                                    <div class="col-lg-4" style="border:2px solid;height: 200px;text-align: center;margin: 0 15px 0 15px;">
                                        <model-obj :src="'/' + Registro.path" ref="model" :glOptions="{ preserveDrawingBuffer: true }"></model-obj>
                                    </div>

                                    <div class="col-lg-2" style="text-align:center;margin: 50px 0 50px 0;">
                                        <button type="button" class="create" @click="snapshot">Captura </button>
                                    </div>
                                    <div v-if="Registro.snapshot_base64">
                                        <div class="col-lg-4" style="border:2px solid;height: 200px;text-align: center;margin: 0 15px 0 15px;">
                                             <img class="snapshot" v-if="Registro.snapshot_base64" :src="Registro.snapshot_base64" height="190px" style="padding: 5px;" />
                                        </div>
                                    </div>
                                    <div v-else-if="Registro.path_imagen">
                                        <div class="col-lg-4" style="border:2px solid;height: 200px;text-align: center;center;margin: 0 15px 0 15px;">
                                           <img class="snapshot" :src="'/' + Registro.path_imagen"  />
                                        </div>
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
import { eventEditRegistro } from '../../event-bus';
import { ModelObj } from 'vue-3d-model';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
 import {convertImgToBase64} from '../../../functions/convertImgToBase64.js';

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
            'snapshot_base64': null,
            'path_imagen' : '',
            'snapshot_base64': null,

         },

        snapshot_base64: null,
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

        snapshot() {
          this.Registro.snapshot_base64 = this.$refs.model.renderer.domElement.toDataURL('image/png', 1);
        },

           openModal : function(){

            this.$nextTick(function () {
                this.Registro.codigo = this.selectRegistro.codigo;
                this.Registro.descripcion = this.selectRegistro.descripcion;
                this.Registro.path = this.selectRegistro.path;
                this.Registro.path_imagen = this.selectRegistro.path_imagen;

                convertImgToBase64('/' + this.selectRegistro.path_imagen,function(base64Img){
                    this.Registro.snapshot_base64 = base64Img;
                }.bind(this),'image/png');

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
              },

        }
}
</script>
