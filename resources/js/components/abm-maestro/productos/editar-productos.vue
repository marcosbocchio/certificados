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
                                    <label for="opcionesEdit">Opciones</label>
                                    <v-select
                                        id="opcionesEdit"
                                        v-model="opcionesSeleccionadas"
                                        :options="opcionesCheckbox"
                                        label="text"
                                        :reduce="option => option.value"
                                        multiple
                                        placeholder="Seleccionar..."
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
import { eventEditRegistro } from '../../event-bus';

export default {
    props: {
        selectRegistro: {
            type: Object,
            required: false,
        }
    },
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
            },

            // --- NUEVOS DATOS PARA EL V-SELECT ---
            opcionesCheckbox: [
                { text: 'VISIBLE OT', value: 'visible_ot' },
                { text: 'STOCK', value: 'stockeable_sn' },
                { text: 'REL. PLACA', value: 'relacionado_a_placas_sn' },
                { text: 'ES PLACA', value: 'placa_sn' }
            ],
            opcionesSeleccionadas: [], // v-model para el v-select
            // --- FIN DE NUEVOS DATOS ---

            unidad_medida: {},
            errors: {},
        }
    },
    created: function () {
        eventEditRegistro.$on('editar', function () {
            this.openModal();
        }.bind(this));
        this.$store.dispatch('loadUnidadesMedidas');
    },
    computed: {
        ...mapState(['url', 'unidades_medidas'])
    },
    methods: {
        openModal: function () {
            this.$nextTick(function () {
                // 1. Cargamos los datos del registro a editar
                this.Registro.codigo = this.selectRegistro.codigo;
                this.Registro.metros = this.selectRegistro.metros;
                this.Registro.descripcion = this.selectRegistro.descripcion;
                this.Registro.visible_ot = this.selectRegistro.visible_ot;
                this.Registro.stockeable_sn = this.selectRegistro.stockeable_sn;
                this.Registro.relacionado_a_placas_sn = this.selectRegistro.relacionado_a_placas_sn;
                this.Registro.placa_sn = this.selectRegistro.placa_sn;
                this.unidad_medida = this.selectRegistro.unidad_medidas;

                // --- LÓGICA PARA PRE-CARGAR EL V-SELECT ---
                // 2. Creamos un array temporal para las opciones pre-seleccionadas
                let preseleccionadas = [];
                if (this.Registro.visible_ot) preseleccionadas.push('visible_ot');
                if (this.Registro.stockeable_sn) preseleccionadas.push('stockeable_sn');
                if (this.Registro.relacionado_a_placas_sn) preseleccionadas.push('relacionado_a_placas_sn');
                if (this.Registro.placa_sn) preseleccionadas.push('placa_sn');

                // 3. Asignamos el array al v-model del v-select
                this.opcionesSeleccionadas = preseleccionadas;
                // --- FIN DE LA LÓGICA DE PRE-CARGA ---

                $('#editar').modal('show');
                this.$forceUpdate();
            })
        },

        storeRegistro: function () {
            // --- LÓGICA DE CONVERSIÓN (igual que en el modal de crear) ---
            this.Registro.visible_ot = false;
            this.Registro.stockeable_sn = false;
            this.Registro.relacionado_a_placas_sn = false;
            this.Registro.placa_sn = false;

            this.opcionesSeleccionadas.forEach(opcionValue => {
                if (this.Registro.hasOwnProperty(opcionValue)) {
                    this.Registro[opcionValue] = true;
                }
            });
            // --- FIN DE LA LÓGICA DE CONVERSIÓN ---

            axios.defaults.baseURL = this.url;
            var urlRegistros = 'productos/' + this.selectRegistro.id;
            axios.put(urlRegistros, {
                ...this.Registro,
                'unidad_medida': this.unidad_medida,
            }).then(response => {
                this.$emit('update');
                this.errors = [];
                $('#editar').modal('hide');
                toastr.success('Registro editado con éxito');
                this.Registro = {}
            }).catch(error => {
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
