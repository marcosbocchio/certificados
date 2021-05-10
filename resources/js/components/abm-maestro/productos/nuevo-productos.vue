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
                                    <input type="checkbox" id="checkbox1" v-model="Registro.visible_ot" style="margin-top: 15px;">
                                    <label for="checkbox1" style="margin-left:5px;">VISIBLE OT</label>
                                    <input style="margin-left:20px;" type="checkbox" id="checkbox2" v-model="Registro.stockeable_sn" :disabled="altaRemito">
                                    <label style="margin-left:5px;" for="checkbox2" >STOKEABLE</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="codigo">Código *</label>
                                    <input autocomplete="off" v-model="Registro.codigo" type="text" name="codigo" class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Descripción</label>
                                    <input autocomplete="off" type="text" name="descripcion" class="form-control" v-model="Registro.descripcion" value="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Unidad Medida *</label>
                                    <v-select v-model="unidad_medida" label="codigo" :options="unidades_medidas"></v-select>
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
            'codigo'  : '',
            'descripcion' : '',
            'visible_ot'  : false,
            'stokeable_sn':false,
         },
        altaRemito: false,
        unidad_medida :{},
        errors:{},
         }

    },
 created: function () {

    eventNewRegistro.$on('open',this.openModal);
    this.$store.dispatch('loadUnidadesMedidas');

    },
    computed :{
        ...mapState(['url','unidades_medidas'])
    },

    methods: {
        openModal : function(origen){
            this.Registro = {
                    'codigo'  : '',
                    'descripcion' : '',
                    'visible_ot'  : false,
                    'stockeable_sn':false,
                    },
            this.altaRemito = (origen == 'remito') ? true : false
            this.Registro.stockeable_sn = this.altaRemito
            this.unidad_medida ={};
            $('#nuevo').modal('show');
            $( document ).ready(function() {
                setTimeout(function(){
                    $("#pass").attr('readonly', false);
                    $("#pass").focus();
                },500);
            });
        },

        getUnidadesMedidas: function(){
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'productos' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
            this.unidades_medidas = response.data
            });
        },

        storeRegistro: function() {

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'productos';
            axios.post(urlRegistros, {

            ...this.Registro,
            'unidad_medida' : this.unidad_medida,

            }).then(response => {
                this.$emit('store');
                this.errors=[];
                $('#nuevo').modal('hide');
                toastr.success('Registro creado con éxito');
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
