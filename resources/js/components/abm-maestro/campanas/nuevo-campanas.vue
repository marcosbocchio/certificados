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

                    <label for="designacion">Designación *</label>
                    <input v-model="registro.designacion" type="text" name="designacion" class="form-control" value="">

                    <label for="presion_max_manometro">Presión máxima manómetro *</label>
                    <input type="number" step="0.01" name="presion_max_manometro" class="form-control" v-model="registro.presion_max_manometro" value="0">

                    <label for="presion_trabajo_min">Presión de trabajo mínima *</label>
                    <input type="number" step="0.01" name="presion_trabajo_min" class="form-control" v-model="registro.presion_trabajo_min" value="0">

                    <label for="presion_trabajo_max">Presión de trabajo máxima *</label>
                    <input type="number" step="0.01" name="presion_trabajo_max" class="form-control" v-model="registro.presion_trabajo_max" value="0">

                    <label for="tipo_angular_sn">Campana tipo angular</label>
                    <input type="checkbox" id="tipo_angular_sn" name="tipo_angular_sn" v-model="registro.tipo_angular_sn" @change="resetDimensiones()">

                    <div v-if="registro.tipo_angular_sn" class="col-xs-12 col-md-12">
                        <div class="form-group">
                            <label>Dimensiones (mm)</label>
                            <div class="row">
                                <div class="col-md-4 col-xs-3">
                            <input type="number" step="0.01" name="ancho" class="form-control" v-model="registro.ancho" value="0">
                                </div>
                                <div class="col-md-4 col-xs-3">
                            <input type="number" step="0.01" name="alto" class="form-control" v-model="registro.alto" value="0">
                                </div>
                                <div class="col-md-4 col-xs-3">
                            <input type="number" step="0.01" name="profundidad" class="form-control" v-model="registro.profundidad" value="0">
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

        registro : {
            'designacion'  : '',
            'presion_max_manometro'  : '',
            'presion_trabajo_min':'',
            'presion_trabajo_max':'',
            'tipo_angular_sn':0,
            'ancho':'',
            'alto':'',
            'profundidad':'',
         },


        errors:{},
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

                this.registro = {
                    'designacion'  : '',
                    'presion_max_manometro'  : '',
                    'presion_trabajo_min':'',
                    'presion_trabajo_max':'',
                    'tipo_angular_sn':false,
                    'ancho':'',
                    'alto':'',
                    'profundidad':'',
                };


                $('#nuevo').modal('show');

            },
            resetDimensiones: function(){
                    this.registro.ancho = 0,
                    this.registro.profundidad = 0,
                    this.registro.alto = 0
            },

            storeRegistro: function(){
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'campanas';
                axios.post(urlRegistros, {

                ...this.registro,


                }).then(response => {
                  this.$emit('store');
                  this.errors=[];
                  $('#nuevo').modal('hide');
                  toastr.success('Campana creada con éxito');
                  this.registro={}

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
