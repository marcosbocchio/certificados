<template>
  <div v-if="registros.length || loading">
    <div class="box box-custom-enod top-buffer">
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-hover table-striped table-condensed">
            <thead>
              <tr>
                <th>Frente</th>
                <th style="text-align: center;">Descripción</th>
                <th style="text-align: center;">Horas Laborables</th>
                <th colspan="2">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="registro in registros" :key="registro.id">
                <td>{{ registro.codigo }}</td>
                <td style="text-align: center;">{{ registro.descripcion || '-' }}</td>
                <td style="text-align: center;">{{ formatHoras(registro.horas_diarias_laborables) || '-' }}</td>
                <td width="10px">
                  <button class="btn btn-warning btn-sm" title="Editar" @click.prevent="updateValue(registro)">
                    <span class="fa fa-edit"></span>
                  </button>
                </td>
                <td width="10px">
                  <button class="btn btn-info btn-sm" title="Usuarios" @click.prevent="goToUsuarios(registro)">
                    <span class="fa fa-user"></span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div v-if="loading" class="overlay">
        <loading-spin></loading-spin>
      </div>
      <usuariosF> </usuariosF>
    </div>
  </div>
</template>

<script>
import { eventEditRegistro, eventModal } from '../../event-bus';

export default {
  props: {
    registros: {
      type: Array,
      required: true,
      default: function() {
        return [];
      }
    },
    loading: {
      type: Boolean,
      required: true
    }
  },
  methods: {
    updateValue(registro) {
      eventEditRegistro.$emit('editar', registro);
    },
    goToUsuarios(registro) {
      eventModal.$emit('open', registro);
    },
    formatHoras(value) {
      if (value === null || value === undefined) return '-';
      return Number.isInteger(value) ? value : parseFloat(value).toFixed(1).replace(/\.0$/, '');
    }
  }
}
</script>

<style scoped>
/* Tu CSS aquí */
</style>