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
                                    <label for="opciones">Opciones</label>
                                    <v-select
                                        id="opciones"
                                        v-model="opcionesSeleccionadas"
                                        :options="opcionesCheckbox"
                                        label="text"
                                        :reduce="option => option.value"
                                        multiple
                                        placeholder="Seleccionar"
                                        :disabled="altaRemito"
                                    ></v-select>
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
                                    <label for="name">Grupo</label>
                                    <v-select
                                        v-model="Registro.grupo_id"
                                        label="codigo"
                                        :options="producto_grupo"
                                        :reduce="grupo => grupo.id"
                                    ></v-select>
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
import { mapState } from 'vuex'
import { eventNewRegistro } from '../../event-bus';

export default {
    data() {
        return {
            Registro: {
                'codigo': '',
                'metros': '',
                'descripcion': '',
                'visible_ot': false,
                'stockeable_sn': false,
                'relacionado_a_placas_sn': false,
                'placa_sn': false,
                'grupo_id': null
            },
            // Datos para el nuevo v-select de opciones
            opcionesCheckbox: [
                { text: 'VISIBLE OT', value: 'visible_ot' },
                { text: 'STOCK', value: 'stockeable_sn' },
                { text: 'REL. PLACA', value: 'relacionado_a_placas_sn' },
                { text: 'ES PLACA', value: 'placa_sn' }
            ],
            opcionesSeleccionadas: [], // v-model para el v-select
            producto_grupo: [],
            altaRemito: false,
            unidad_medida: {},
            errors: {},
        }
    },
    created: function () {
        eventNewRegistro.$on('open', this.openModal);
        this.getProductosGrupos();
        this.$store.dispatch('loadUnidadesMedidas');
    },
    computed: {
        ...mapState(['url', 'unidades_medidas'])
    },
    methods: {
        openModal: function (origen) {
            this.Registro = {
                'codigo': '',
                'metros': '',
                'descripcion': '',
                'visible_ot': false,
                'stockeable_sn': false,
                'relacionado_a_placas_sn': false,
                'placa_sn': false,
            };

            // Limpiamos el v-select al abrir el modal
            this.opcionesSeleccionadas = [];

            this.altaRemito = (origen == 'remito');

            // Si es altaRemito, pre-seleccionamos 'STOCKEABLE'
            if (this.altaRemito) {
                this.opcionesSeleccionadas.push('stockeable_sn');
            }

            this.unidad_medida = {};
            $('#nuevo').modal('show');
            $(document).ready(function () {
                setTimeout(function () {
                    $("#pass").attr('readonly', false);
                    $("#pass").focus();
                }, 500);
            });
        },

        getUnidadesMedidas: function () {
            axios.defaults.baseURL = this.url;
            var urlRegistros = 'productos' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response => {
                this.unidades_medidas = response.data
            });
        },
        getProductosGrupos: function () {
            axios.defaults.baseURL = this.url;
            var urlRegistros = 'productos/grupos' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response => {
                this.producto_grupo = response.data
            });
        },

        storeRegistro: function () {
            // -- Lógica para convertir el array del v-select a las flags booleanas --
            // 1. Reseteamos todos a false
            this.Registro.visible_ot = false;
            this.Registro.stockeable_sn = false;
            this.Registro.relacionado_a_placas_sn = false;
            this.Registro.placa_sn = false;

            // 2. Recorremos el array y ponemos en true los que correspondan
            this.opcionesSeleccionadas.forEach(opcionValue => {
                if (this.Registro.hasOwnProperty(opcionValue)) {
                    this.Registro[opcionValue] = true;
                }
            });
            // -- Fin de la lógica de conversión --

            axios.defaults.baseURL = this.url;
            var urlRegistros = 'productos';
            axios.post(urlRegistros, {
                ...this.Registro,
                'unidad_medida': this.unidad_medida,
            }).then(response => {
                this.$emit('store');
                this.errors = [];
                $('#nuevo').modal('hide');
                toastr.success('Registro creado con éxito');
                this.grupo_id = null;
                this.Registro = {}
            }).catch(error => {
                console.log(error);
                this.errors = error.response.data.errors;
                $.each(this.errors, function (key, value) {
                    toastr.error(value);
                    console.log(key + ": " + value);
                });

                if ((typeof (this.errors) == 'undefined') && (error)) {
                    toastr.error("Ocurrió un error al procesar la solicitud");
                }
            });
        }
    }
}
</script>
