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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="checkbox" id="checkboxUser" v-model="Registro.habilitado_sn">
                                    <label for="checkboxUser" class="pointer">HABILITADO</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numero_interno">N° Interno *</label>
                                    <input autocomplete="off" v-model="Registro.nro_interno" type="number" name="numero_interno" class="form-control" value="" max="99999">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="marca">Marca *</label>
                                    <input autocomplete="off" v-model="Registro.marca" type="text" name="marca" class="form-control" value="" maxlength="15" >
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="modelo">Modelo *</label>
                                    <input autocomplete="off" v-model="Registro.modelo" type="text" name="modelo" class="form-control" value="" maxlength="50">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="patente">Patente *</label>
                                    <input autocomplete="off" v-model="Registro.patente" type="text" name="patente" class="form-control" value="" maxlength="7">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo">Tipo *</label>
                                    <input autocomplete="off" v-model="Registro.tipo" type="text" name="tipo" class="form-control" value="" maxlength="15">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="chasis">Chasis *</label>
                                    <input autocomplete="off" v-model="Registro.chasis" type="text" name="chasis" class="form-control" value="" maxlength="20">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="motor">Motor *</label>
                                    <input autocomplete="off" v-model="Registro.motor" type="text" name="motor" class="form-control" value="" maxlength="20">
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

        Registro : {

            'nro_interno' :'',
            'marca'    : '',
            'modelo'   : '',
            'patente'  : '',
            'tipo'     :'',
            'chasis'   :'',
            'motor'    :'',
            'habilitado_sn':true,
         },
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

                this.Registro.nro_interno = this.selectRegistro.nro_interno;
                this.Registro.marca = this.selectRegistro.marca;
                this.Registro.modelo = this.selectRegistro.modelo;
                this.Registro.patente  =this.selectRegistro.patente;
                this.Registro.tipo = this.selectRegistro.tipo;
                this.Registro.chasis = this.selectRegistro.chasis;
                this.Registro.motor = this.selectRegistro.motor;
                this.Registro.habilitado_sn = this.selectRegistro.habilitado_sn;

                $('#editar').modal('show');

                this.$forceUpdate();
            })
            },

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'vehiculos/' + this.selectRegistro.id;
                axios.put(urlRegistros, {

                ...this.Registro,

                }).then(response => {
                  this.$emit('update');
                  this.errors=[];
                  $('#editar').modal('hide');
                  toastr.success('vehículo editado con éxito');
                  this.Registro={}

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
