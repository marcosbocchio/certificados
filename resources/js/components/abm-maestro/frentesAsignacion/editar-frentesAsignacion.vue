<template>
    <form @submit.prevent="guardar" method="post">
        <div class="modal fade" id="editar-frente">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar Frente de Asignación</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="codigo">Código *</label>
                                    <input autocomplete="off" v-model="frente.codigo" type="text" name="codigo" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="horas">Horas Laborales *</label>
                                    <input autocomplete="off" id="horas" type="number" name="horas" class="form-control" v-model.number="frente.horas_diarias_laborables" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <input autocomplete="off" type="text" name="descripcion" class="form-control" v-model="frente.descripcion">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="checkbox" id="centro-distribucion" v-model="frente.centro_distribucion_sn">
                                    <label for="centro-distribucion">Centro de Distribución</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="checkbox" id="control-horas-extras" v-model="frente.controla_hs_extras_sn">
                                    <label for="control-horas-extras">Control de Horas Extras</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Guardar">
                        <button type="button" class="btn btn-default" name="button" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import axios from 'axios';
import { eventEditRegistro } from '../../event-bus';

export default {
    
    data() {
        return {
            frente: {}
        };
    },
    created() {
        eventEditRegistro.$on('editar', this.openModal);
    },
    methods: {
        guardar() {
            if (this.frente.codigo === '' || this.frente.horas_diarias_laborables === '') {
                alert('Los campos Código y Horas Laborales son obligatorios.');
                return;
            }

            axios.put(`frentes/${this.frente.id}`, {
                codigo: this.frente.codigo,
                descripcion: this.frente.descripcion,
                horas_diarias_laborables: this.frente.horas_diarias_laborables,
                centro_distribucion_sn: this.frente.centro_distribucion_sn,
                controla_hs_extras_sn: this.frente.controla_hs_extras_sn
            })
            .then(response => {
                // Cerrar el modal después de guardar
                $('#editar-frente').modal('hide');
                this.limpiarFormulario();
            })
            .catch(error => {
              
                console.error(error);
            });
        },
        openModal(registro) {
            this.frente = registro;
            $('#editar-frente').modal('show');
        },
        limpiarFormulario() {
            this.frente = {};
        }
    }
};
</script>

<style scoped>
/* Tu CSS aquí */
</style>