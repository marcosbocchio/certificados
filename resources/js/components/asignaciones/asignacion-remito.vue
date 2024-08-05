<template>
  <div>
    <loading :active.sync="isLoading" :is-full-page="true" :loader="'bars'" :color="'red'"></loading>
    <div class="row">
      <div class="col-md-12">
        <button type="button" class="pull-left btn-enod btn-circle" @click="goBack">
          <span class="fa fa-arrow-left"></span>
        </button>
      </div>
    </div>
    
    <!-- Botón para volver a la página anterior -->
    <!-- Input Remito y Botón de Agregar -->
    <div class="box box-custom-enod top-buffer">
      <div class="box-body row">
        <div class="col-md-4">
          <!-- Espacio en blanco -->
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="remito">Remito:</label>
            <input type="text" v-model="remito" class="form-control" id="remito" disabled/>
          </div>
        </div>
        <div class="col-md-4" style="margin-top: 29px;">
          <button @click="mostrarPopup = true">
            <span class="fa fa-plus-circle"></span>
          </button>
        </div>
      </div>
    </div>

    <!-- Tabla de Operadores -->
    <div class="box box-custom-enod top-buffer">
      <div class="box-body table-responsive">
        <table class="table table-hover table-striped table-condensed">
          <thead>
            <tr>
              <th>Operador</th>
              <th style="text-align:right">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(operador, index) in operadores" :key="index">
              <td>{{ operador.name }}</td>
              <td style="text-align:right">
                <button @click="editarOperador(index)" class="btn btn-warning btn-sm">
                  <span class="fa fa-edit"></span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    
    <!-- Popup -->
    <div v-if="mostrarPopup" class="modal show" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Seleccionar Operador</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="operador-select">Operador</label>
              <v-select v-model="operador_selected" :options="operadores_opciones" label="name"></v-select>
            </div>
          </div>
          <div class="modal-footer row">
            <div class="col-md-4" style="text-align: left;">
              <button type="button" class="btn btn-enod" @click="confirmarOperador">Seleccionar</button>
            </div>
            <div class="col-md-4">
              <!-- Espacio vacío entre los botones -->
            </div>
            <div class="col-md-4">
              <button type="button" class="btn btn-secondary" @click="mostrarPopup = false">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Popup -->
  </div>
</template>

<script>
import axios from 'axios';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

export default {
  components: {
    Loading
  },
  props: {
    operadores_opciones: {
      type: Array,
      required: true
    },
    remito_data: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      remito: this.remito_data[0].formateado,
      operadores: [],
      operador_selected: null,
      mostrarPopup: false,
      isLoading: false
    };
  },
  mounted() {
    this.fetchOperadores();
  },
  methods: {
    fetchOperadores() {
      this.isLoading = true;
      axios.get(`/api/asignacion-epp-operadores/${this.remito_data[0].id}`)
        .then(response => {
          this.operadores = response.data.operadores;
          this.isLoading = false;
        })
        .catch(error => {
          console.error("Error al obtener los operadores de asignación EPP:", error);
          toastr.error('Error al cargar los operadores');
          this.isLoading = false;
        });
    },
    goBack() {
      window.history.back();
    },
    otraFuncion() {
      console.log('Botón "+" presionado');
      this.$router.push('/otra-ruta');
    },
    editarOperador(index) {
      const userId = this.operadores[index].id;
      const remitoId = this.remito_data[0].id;
      console.log(userId, remitoId);
      // Redirige a la ruta para editar el remito específico
      window.location.href = `/area/enod/asignacion-nuevo/${userId}/remito/${remitoId}`;
    },
    confirmarOperador() {
      if (!this.operador_selected) {
        toastr.error('Debes seleccionar un operador');
        return;
      }
      // Redirigir a la nueva ruta con el operador seleccionado en la URL
      window.location.href = `/area/enod/asignacion-nuevo/${this.operador_selected.id}/remito/${this.remito_data[0].id}`;
    }
  }
};
</script>

<style scoped>
.box.box-custom-enod {
  padding: 20px;
}

.modal.show {
  display: block;
  z-index: 1050;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
}
</style>