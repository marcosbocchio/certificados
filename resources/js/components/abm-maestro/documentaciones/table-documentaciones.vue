<template>
  <div class="box box-custom-enod top-buffer">
    <div class="box-body">
      <loading :active.sync="isLoading" :loader="'bars'" :color="'red'"></loading>
      <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
          <thead>
            <tr>
              <th><input type="checkbox" @change="toggleAll($event)" /></th>
              <th class="col-md-1">Tipo</th>
              <th class="col-md-4">Descripción</th>
              <th class="col-md-1">Método</th>
              <th class="col-md-2">Usuario</th>
              <th class="col-md-1">INT. Nº</th>
              <th class="col-md-2">Fecha De Caducidad</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="registro in registros" :key="registro.id">
              <td><input type="checkbox" :value="registro" v-model="selectedRegistros" /></td>
              <td>{{ registro.tipo }}</td>
              <td>{{ registro.descripcion }}</td>
              <td v-if="registro.metodo_ensayo.id">{{ registro.metodo_ensayo['metodo'] }}</td>
              <td v-else-if="registro.interno_equipo.length > 0">{{ registro.interno_equipo[0].equipo.metodo_ensayos['metodo'] }}</td>
              <td v-else>&nbsp;</td>
              <td v-if="registro.usuario[0]">{{ registro.usuario[0]['name'] }}</td>
              <td v-else-if="registro.tipo == 'EQUIPO' && registro.user_interno_equipo[0]">{{ registro.user_interno_equipo[0]['name'] }}</td>
              <td v-else>&nbsp;</td>
              <td v-if="registro.tipo == 'EQUIPO' && registro.interno_equipo[0]">{{ registro.interno_equipo[0]['nro_interno'] }}</td>
              <td v-else-if="registro.tipo == 'FUENTE' && registro.interno_fuente[0]">{{ registro.interno_fuente[0]['nro_serie'] }}</td>
              <td v-else-if="registro.tipo == 'VEHICULO' && registro.vehiculo[0]">{{ registro.vehiculo[0]['nro_interno'] }}</td>
              <td v-else>&nbsp;</td>
              <td>{{ formatFecha(registro.fecha_caducidad) }}</td>
              <td width="10px">
                <button class="btn btn-warning btn-sm" title="Editar" @click.prevent="$emit('editRegistroEvent', registro)" :disabled="!$can('M_documentaciones_edita')">
                  <span class="fa fa-edit"></span>
                </button>
              </td>
              <td width="10px">
                <button class="btn btn-danger btn-sm" title="Eliminar" @click.prevent="$emit('confirmarDelete', registro, registro.titulo)" :disabled="!$can('M_documentaciones_edita')">
                  <span class="fa fa-trash"></span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <button @click="generateZip" :disabled="!selectedRegistros.length" class="btn btn-primary">Descargar ZIP</button>
  </div>
</template>

<script>
import axios from 'axios';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
  components: {
    Loading
  },
  props: {
    registros: {
      type: Array,
      required: true,
      default: () => [],
    },
    loading: Boolean,
  },
  data() {
    return {
      selectedRegistros: [],
      isLoading: false,
    };
  },
  methods: {
    formatFecha(fecha) {
      if (!fecha) return '';
      const date = new Date(fecha);
      return date.toLocaleDateString("es-ES");
    },
    toggleAll(event) {
      this.selectedRegistros = event.target.checked ? this.registros : [];
    },
    async generateZip() {
    if (!this.selectedRegistros.length) return;

    this.isLoading = true;
    try {
        // Mapear los registros seleccionados para obtener solo tipo y path
        const registros = this.selectedRegistros.map(registro => ({
            tipo: registro.tipo,
            path: registro.path
        }));

        // Enviar los datos al backend para generar el ZIP
        const response = await axios.post("/documentaciones/generar-zip-doc", { registros }, { responseType: 'blob' });
        
        // Crear el archivo ZIP y descargarlo
        const blob = new Blob([response.data], { type: 'application/zip' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'archivos_seleccionados.zip');
        document.body.appendChild(link);
        link.click();
        URL.revokeObjectURL(url);
    } catch (error) {
        console.error("Error generando el ZIP:", error);
    } finally {
        this.isLoading = false;
    }
}
  }
};
</script>

<style>
.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>