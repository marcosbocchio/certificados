<template>
    <form v-on:submit.prevent="storeRegistro" method="post">
        <div class="modal fade" id="nuevo">
           <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Crear</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="codigo">Nombre *</label>
                                    <input autocomplete="off" v-model="Registro.codigo" type="text" name="codigo" class="form-control" value="" maxlength="20">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <textarea v-model="Registro.descripcion" class="form-control noresize" rows="4" placeholder="" maxlength="500" value=""></textarea>
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
                                <div class="col-sm-12 block-model">

                                        <div style="border:0px solid;height: 500px;text-align: center;margin: 0 15px 0 15px;">
                                            <model-obj :src="'/' + Registro.path" ref="model" :glOptions="{ preserveDrawingBuffer: true }"></model-obj>
                                        </div>

                                        <button type="button" class="model-botton" @click="snapshot">Captura </button>

                                        <div v-if="Registro.snapshot_base64">
                                            <div class="block-captura">
                                                <img :src="Registro.snapshot_base64" height="150" />
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
import { eventNewRegistro } from '../../event-bus';
import { ModelObj } from 'vue-3d-model';

export default {

    data() { return {

        Registro : {
            'codigo': '',
            'descripcion'  : '',
            'path' : '',
            'snapshot_base64': null,
         },

        ruta: 'modelos_3d',
        max_size :30000, //KB
        tipos_archivo_soportados:['obj','json','stl','dae','ply','ctm','fbx','gltf'],
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
    snapshot() {

        this.Registro.snapshot_base64 = this.$refs.model.renderer.domElement.toDataURL('image/png', 1);
    },

        openModal : function(){
            this.Registro = {
            'codigo': '',
            'descripcion'  : '',
            'path' : '',
            'snapshot_base64': null,
         },
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
