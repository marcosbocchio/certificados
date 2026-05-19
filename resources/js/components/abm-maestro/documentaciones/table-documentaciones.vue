<template>
  <div class="box box-custom-enod top-buffer">
    <div class="box-body">
      <div style="padding: 5px; display: flex; gap: 8px; align-items: center;">
          <button @click="generateZip" :disabled="!selectedRegistros.length" class="btn btn-enod">Descargar</button>
          <button @click="$refs.importInput.click()" class="btn btn-default" :disabled="!$can('M_documentaciones_edita')">Importar ZIP</button>
          <input ref="importInput" type="file" accept=".zip" style="display:none" @change="importarZip($event)" />
      </div>
      <loading :active.sync="isLoading" :loader="'bars'" :color="'red'"></loading>
      <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
          <thead>
            <tr>
              <th><input type="checkbox" @change="toggleAll($event)" /></th>
              <th class="col-md-1">Tipo</th>
              <th class="col-md-2">Título</th>
              <th class="col-md-3">Descripción</th>
              <th class="col-md-1">Método</th>
              <th class="col-md-2">Usuario</th>
              <th class="col-md-1">INT. Nº</th>
              <th class="col-md-1">Caducidad</th>
              <th class="col-md-2">Baja Equipo</th>
              <th >&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="registro in registros" :key="registro.id"
                :class="{
                    'table-danger': registro.interno_equipo && registro.interno_equipo[0] && registro.interno_equipo[0].activo_sn === 0
                }">
              <td><input type="checkbox" :value="registro" v-model="selectedRegistros" /></td>

              <!-- Tipo de documento -->
              <td v-if="registro.tipo == 'USUARIO'">USUARIOS</td>          
              <td v-if="registro.tipo == 'OT'">OT</td>          
              <td v-if="registro.tipo == 'INSTITUCIONAL'">INSTITUCIONAL</td>    
              <td v-if="registro.tipo == 'PROCEDIMIENTO GENERAL'">PROCEDIMIENTO GENERAL</td>    
              <td v-if="registro.tipo == 'EQUIPO'">EQUIPO</td>
              <td v-if="registro.tipo == 'FUENTE'">FUENTE</td>
              <td v-if="registro.tipo == 'VEHICULO'">VEHICULO</td>

              <!-- Título y Descripción -->
              <td>{{ registro.titulo }}</td>
              <td>{{ registro.descripcion }}</td>

              <!-- Método de Ensayo -->
              <td v-if="registro.metodo_ensayo && registro.metodo_ensayo.id">{{ registro.metodo_ensayo.metodo }}</td>
              <td v-else-if="registro.interno_equipo.length > 0">{{ registro.interno_equipo[0].equipo.metodo_ensayos.metodo }}</td>
              <td v-else>&nbsp;</td>

              <!-- Usuario -->
              <td v-if="registro.usuario && registro.usuario[0]">{{ registro.usuario[0].name }}</td>
              <td v-else-if="registro.tipo == 'EQUIPO' && registro.user_interno_equipo[0]">{{ registro.user_interno_equipo[0].name }}</td>
              <td v-else>&nbsp;</td>

              <!-- Número de Interno -->
              <td v-if="registro.tipo == 'EQUIPO' && registro.interno_equipo && registro.interno_equipo[0]">{{ registro.interno_equipo[0].nro_interno }}</td>
              <td v-else-if="registro.tipo == 'FUENTE' && registro.interno_fuente && registro.interno_fuente[0]">{{ registro.interno_fuente[0].nro_serie }}</td>
              <td v-else-if="registro.tipo == 'VEHICULO' && registro.vehiculo && registro.vehiculo[0]">{{ registro.vehiculo[0].nro_interno }}</td>
              <td v-else>&nbsp;</td>

              <!-- Fecha de Caducidad -->
              <td>{{ formatFecha(registro.fecha_caducidad) }}</td>
              <td>
                {{ registro.interno_equipo[0] ? formatFecha(registro.interno_equipo[0].fecha_anul) : '' }}
              </td>

              <!-- Botón de Editar -->
              <td width="10px">
                <button class="btn btn-enod btn-sm" title="Editar" v-on:click.prevent="$emit('editRegistroEvent',registro)" :disabled="!$can('M_documentaciones_edita')">
                  <span class="fas fa-edit"></span>
                </button>
              </td>

              <!-- Botón de Eliminar -->
              <td width="10px">
                <button class="btn btn-danger btn-sm" title="Eliminar" v-on:click.prevent="$emit('confirmarDelete',registro,registro.titulo)" :disabled="!$can('M_documentaciones_edita')">
                  <span class="fas fa-trash"></span>
                </button>
              </td>
            </tr>
          </tbody>

        </table>
      </div>
    </div>
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
      console.log(this.registros);
      this.selectedRegistros = event.target.checked ? this.registros : [];
    },
    async generateZip() {
      if (!this.selectedRegistros.length) return;
      this.isLoading = true;
      try {
        const registros = this.selectedRegistros;
        const response = await axios.post("/documentaciones/generar-zip-doc", { registros }, { responseType: 'blob' });
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
        toastr.error('Error al generar el ZIP');
      } finally {
        this.isLoading = false;
      }
    },
    async importarZip(event) {
      const file = event.target.files[0];
      if (!file) return;
      this.$refs.importInput.value = '';
      this.isLoading = true;
      try {
        const formData = new FormData();
        formData.append('zip', file);
        const response = await axios.post('/documentaciones/importar-zip-doc', formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        });
        const { created, updated, errors } = response.data;
        const msg = `Importados: ${created} creados, ${updated} actualizados${errors.length ? ', ' + errors.length + ' errores' : ''}`;
        errors.length ? toastr.warning(msg) : toastr.success(msg);
        this.$emit('refreshEvent');
      } catch (error) {
        console.error('Error importando ZIP:', error);
        toastr.error('Error al importar el ZIP');
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
.table-danger{
  background-color: #dc3545 !important; /* Rojo Bootstrap */
  color: white; /* Texto blanco para contraste */
}
</style>