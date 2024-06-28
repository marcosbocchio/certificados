<template>
  <div class="modal fade" id="modal-usuarios" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" @click="cerrarModal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Usuarios del Frente: {{ frenteSeleccionado?.codigo }}</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="usuario">Agregar Usuario</label>
            <v-select
              v-model="usuarioSeleccionado"
              :options="usuarios"
              label="name"
            ></v-select>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div style="display: flex; justify-content: flex-start; align-items: center;">
                <button type="button">
                  <span @click="agregarUsuario" class="fa fa-plus-circle"></span>
                </button>
              </div>
            </div>
          </div>
          <table class="table table-hover table-striped table-condensed mt-3">
            <thead>
              <tr>
                <th>Usuario</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="usuario in usuariosAsociados" :key="usuario.id">
                <td>{{ usuario.name }}</td>
                <td>
                  <span class="fa fa-minus-circle" @click="eliminarUsuario(usuario)"></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" @click="guardarUsuariosAsociados" :disabled="loading">
            <span v-if="loading" class="fa fa-spinner fa-spin"></span>
            Guardar
          </button>
        </div>
        <div v-if="loading" class="overlay">
          <loading-spin></loading-spin>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import { eventModal } from '../../event-bus';
import { toastrInfo, toastrDefault } from '../../toastrConfig';

export default {
  components: {
    'v-select': vSelect,
  },
  data() {
    return {
      frenteSeleccionado: null,
      usuarios: [],
      usuarioSeleccionado: null,
      usuariosAsociados: [],
      loading: false,
    };
  },
  created() {
    eventModal.$on('open', this.openModal);
    this.fetchUsuarios();
  },
  methods: {
    fetchUsuarios() {
      axios.get('frente-usuarios')
        .then(response => {
          this.usuarios = response.data;
        })
        .catch(error => {
          console.error('Error fetching usuarios:', error);
        });
    },
    fetchUsuariosAsociados(frenteId) {
      axios.get(`frente-usuario/${frenteId}`)
        .then(response => {
          this.usuariosAsociados = response.data.usuarios;
        })
        .catch(error => {
          console.error('Error fetching usuarios asociados:', error);
        });
    },
    agregarUsuario() {
      if (this.usuarioSeleccionado && !this.usuariosAsociados.find(usuario => usuario.id === this.usuarioSeleccionado.id)) {
        this.usuariosAsociados.push(this.usuarioSeleccionado);
        this.usuarioSeleccionado = null;
      } else {
        toastr.error('El usuario ya fue asignado al frente.', toastrInfo);
      }
    },
    eliminarUsuario(usuario) {
      const index = this.usuariosAsociados.indexOf(usuario);
      if (index !== -1) {
        this.usuariosAsociados.splice(index, 1);
      }
    },
    openModal(frente) {
      this.frenteSeleccionado = frente;
      this.fetchUsuariosAsociados(frente.id);
      $('#modal-usuarios').modal('show');
    },
    cerrarModal() {
      this.usuariosAsociados = [];
      this.frenteSeleccionado = null;
      $('#modal-usuarios').modal('hide');
    },
    guardarUsuariosAsociados() {
      if (this.usuariosAsociados.length > 0) {
        this.loading = true;
        const usuarioIds = this.usuariosAsociados.map(usuario => usuario.id);

        axios.post('/frente-usuarios/update', {
          frente_id: this.frenteSeleccionado.id,
          usuarios_asociados: usuarioIds,
        })
        .then(response => {
          this.loading = false;
          toastr.success('Usuarios asociados correctamente.', toastrDefault);
          this.cerrarModal();
        })
        .catch(error => {
          this.loading = false;
          toastr.error('Error al asociar usuarios.', toastrInfo);
          console.error('Error al asociar usuarios:', error);
        });
      } else {
        toastr.error('No se han seleccionado usuarios.', toastrInfo);
      }
    },
  },
};
</script>

<style scoped>
.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>