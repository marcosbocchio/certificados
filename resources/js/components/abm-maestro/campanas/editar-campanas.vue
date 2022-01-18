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

                    <label for="designacion">Designación *</label>
                    <input v-model="registro.designacion" type="text" name="designacion" class="form-control" value="">

                    <label for="presion_max_manometro">Presión máxima manómetro *</label>
                    <input type="number" step="0.01" name="presion_max_manometro" class="form-control" v-model="registro.presion_max_manometro" value="0">

                    <label for="presion_trabajo_min">Presión de trabajo mínima *</label>
                    <input type="number" step="0.01" name="presion_trabajo_min" class="form-control" v-model="registro.presion_trabajo_min" value="0">

                    <label for="presion_trabajo_max">Presión de trabajo máxima *</label>
                    <input type="number" step="0.01" name="presion_trabajo_max" class="form-control" v-model="registro.presion_trabajo_max" value="0">

                    <label for="tipo_angular_sn">Campana tipo angular</label>
                    <input type="checkbox" :key="keycheckbox" id="tipo_angular_sn" name="tipo_angular_sn" v-model="registro.tipo_angular_sn" @change="resetDimensiones()">

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
 import { eventEditRegistro } from '../../event-bus';
export default {

    props : {

        selectRegistro : {
            type : Object,
            required : false,
          }

    },
    data() { return {

        registro : {
                'designacion'  : '',
                'presion_max_manometro'  : '',
                'presion_trabajo_min':'',
                'presion_trabajo_max':'',
                'tipo_angular_sn':false,
                'ancho':'',
                'alto':'',
                'profundidad':'',
         },
         keycheckbox: 1,

        errors:{},
         }

    },

 created: function () {

    eventEditRegistro.$on('editar',function() {

                 this.openModal();

    }.bind(this));


    },

    computed :{

         ...mapState(['url'])
    },

    methods: {
           openModal : function(){
           console.log('entro en open modal');
            this.$nextTick(function () {

                this.registro.designacion = this.selectRegistro.designacion;
                this.registro.tipo_angular_sn = this.selectRegistro.tipo_angular_sn;
                this.registro.presion_max_manometro=this.selectRegistro.presion_max_manometro;
                this.registro.presion_trabajo_max=this.selectRegistro.presion_trabajo_max;
                this.registro.presion_trabajo_min=this.selectRegistro.presion_trabajo_min;
                this.registro.alto = this.selectRegistro.alto ? this.selectRegistro.alto : 0;
                this.registro.ancho = this.selectRegistro.ancho ? this.selectRegistro.ancho : 0;
                this.registro.profundidad = this.selectRegistro.profundidad ? this.selectRegistro.profundidad : 0;
                $('#editar').modal('show');

                this.$forceUpdate();
            })
            },
            resetDimensiones: function(){
                    this.changekey()
                    this.registro.ancho = 0
                    this.registro.profundidad = 0
                    this.registro.alto = 0
            },
            changekey: function(){
                this.keycheckbox++
            },
            storeRegistro: function(){
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'campanas/' + this.selectRegistro.id;
                axios.put(urlRegistros, {

                ...this.registro,


                }).then(response => {
                  this.$emit('update');
                  this.errors=[];
                  $('#editar').modal('hide');
                  toastr.success('Campana editada con éxito');
                  this.registro={}

                }).catch(error => {
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
