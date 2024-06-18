<template>
  <form v-on:submit.prevent="guardar" method="post">
    <div class="modal fade" id="nuevo-frente">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nuevo Frente de Asignación</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="codigo">Código *</label>
                  <input autocomplete="off" id="codigo" v-model="codigo" type="text" name="codigo" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="horas">Horas Laborales *</label>
                  <input autocomplete="off" id="horas" type="number" name="horas" class="form-control" v-model.number="horas_diarias_laborables" min="0" step="0.1">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="descripcion">Descripción</label>
                  <input autocomplete="off" id="descripcion" type="text" name="descripcion" class="form-control" v-model="descripcion">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="checkbox" id="centro-distribucion" v-model="centro_distribucion_sn">
                  <label for="centro-distribucion">Centro de Distribución</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="checkbox" id="control-horas-extras" v-model="controla_hs_extras_sn">
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
import { eventNewRegistro } from '../../event-bus';
import { toastrInfo, toastrDefault } from '../../toastrConfig';
import { EventBus } from '../../event-bus';

export default {
  data() {
    return {
      codigo: '',
      descripcion: '',
      horas_diarias_laborables: '',
      centro_distribucion_sn: false,
      controla_hs_extras_sn: false
    };
  },
  created() {
    eventNewRegistro.$on('open', this.openModal);
  },
  methods: {
    guardar() {
      if (this.codigo === '' || this.horas_diarias_laborables === '') {
        toastr.error('Los campos Código y Horas Laborales son obligatorios.');
        return;
      }
      axios.post('frentesAsignacion/store', {
        codigo: this.codigo,
        descripcion: this.descripcion,
        horas_diarias_laborables: this.horas_diarias_laborables,
        centro_distribucion_sn: this.centro_distribucion_sn ? 1 : 0,
        controla_hs_extras_sn: this.controla_hs_extras_sn ? 1 : 0
      })
      .then(response => {
        EventBus.$emit('registro-guardado');
        $('#nuevo-frente').modal('hide');
        toastr.success('Frente Guardado');
        this.limpiarFormulario();
      })
      .catch(error => {
        console.error(error);
      });
    },
    openModal() {
      $('#nuevo-frente').modal('show');
    },
    limpiarFormulario() {
      this.codigo = '';
      this.descripcion = '';
      this.horas_diarias_laborables = '';
      this.centro_distribucion_sn = false;
      this.controla_hs_extras_sn = false;
    }
  }
};
</script>

<style scoped>
/* Tu CSS aquí */
</style>