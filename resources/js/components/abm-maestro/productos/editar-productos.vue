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
                                    <input type="checkbox" id="checkbox1" v-model="Registro.visible_ot" style="margin-top: 15px;">
                                    <label for="checkbox1" style="margin-left:5px;">VISIBLE OT</label>
                                    <input style="margin-left:20px;" type="checkbox" id="checkbox2" v-model="Registro.stockeable_sn">
                                    <label style="margin-left:5px;" for="checkbox2">STOKEABLE</label>

                                    <!-- Nuevo checkbox agregado -->
                                    <input style="margin-left: 20px;" type="checkbox" id="checkbox3" v-model="Registro.relacionado_a_placas_sn">
                                    <label style="margin-left: 5px;" for="checkbox3">RELACIONADO A PLACAS</label>
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
                                    <label for="codigo">Metros Totales</label>
                                    <input autocomplete="off" v-model="Registro.metros" type="number" name="metros" class="form-control" min="0" step="0.01">
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
            'codigo'  : '',
            'metros'  : '',
            'descripcion' : '',
            'visible_ot'  : false,
            'stockeable_sn':false,
            'relacionado_a_placas_sn':false,
         },

         unidad_medida :{},
         errors:{},
         }

    },
 created: function () {

    eventEditRegistro.$on('editar',function() {

                 this.openModal();

    }.bind(this));
   this.$store.dispatch('loadUnidadesMedidas');
    },

    computed :{

         ...mapState(['url','unidades_medidas'])
    },

    methods: {

        openModal : function(){

        this.$nextTick(function () {
            this.Registro.codigo = this.selectRegistro.codigo;
            this.Registro.metros = this.selectRegistro.metros;
            this.Registro.descripcion = this.selectRegistro.descripcion;
            this.Registro.visible_ot  = this.selectRegistro.visible_ot;
            this.Registro.stockeable_sn = this.selectRegistro.stockeable_sn;
            this.Registro.relacionado_a_placas_sn = this.selectRegistro.relacionado_a_placas_sn;
            this.unidad_medida = this.selectRegistro.unidad_medidas;

            console.log(this.selectRegistro.cliente_id);

            $('#editar').modal('show');

            this.$forceUpdate();
        })
        },

        storeRegistro: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'productos/' + this.selectRegistro.id;
            axios.put(urlRegistros, {

            ...this.Registro,
            'unidad_medida' : this.unidad_medida,

            }).then(response => {
                this.$emit('update');
                this.errors=[];
                $('#editar').modal('hide');
                toastr.success('Registro editado con éxito');
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

