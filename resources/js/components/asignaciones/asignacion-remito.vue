<template>
  <div>
    <loading :active.sync="isLoading" :is-full-page="true" :loader="'bars'" :color="'red'"></loading>
    
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
        <div class="col-md-4">
          <!-- Espacio en blanco -->
        </div>
      </div>
    </div>

    <!-- Tabla de Operadores -->
    <div class="box box-custom-enod top-buffer">
      <div class="row">
        <div class="col-md-12">
          <button @click="mostrarPopup = true"><span class="fa fa-plus-circle"></span></button>
        </div>
      </div>
      <div class="box-body table-responsive">
        <table class="table table-hover table-striped table-condensed">
          <thead>
            <tr>
              <th>Operador</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(operador, index) in operadores" :key="index">
              <td>{{ operador }}</td>
              <td>
                <button @click="editarOperador(index)" class="btn btn-warning btn-sm">Edit</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    
    <!-- Popup -->
    <div v-if="mostrarPopup" class="popup">
      <div class="popup-inner">
        <h2>Seleccionar Operador</h2>
        <v-select v-model="operador_selected" :options="operadores_opciones" label="name"></v-select>
        <button @click="confirmarOperador">Seleccionar</button>
        <button @click="mostrarPopup = false">Cancelar</button>
      </div>
    </div>
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
  methods: {
    otraFuncion() {
      console.log('Botón "+" presionado');
      this.$router.push('/otra-ruta');
    },
    editarOperador(index) {
      const nuevoOperador = prompt('Edita el operador:', this.operadores[index]);
      if (nuevoOperador !== null) {
        this.operadores.splice(index, 1, nuevoOperador);
      }
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
.popup {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}
.popup-inner {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
}
</style>