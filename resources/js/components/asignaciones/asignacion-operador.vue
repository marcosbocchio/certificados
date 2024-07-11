<template>
  <div>
    <loading :active.sync="isLoading" :is-full-page="true" :loader="'bars'" :color="'red'"></loading>
    <div class="row">
      <div class="col-md-12">
        <button type="button" class="pull-left btn-enod btn-circle"  @click="goBack">
          <span class="fa fa-arrow-left"></span>
        </button>
      </div>
    </div>
    <!-- Input Operador y Botón de Agregar -->
    <div class="box box-custom-enod top-buffer">
      <div class="box-body row">
        <div class="col-md-4">
          <!-- Espacio en blanco -->
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="operador">Operador:</label>
            <input type="text" v-model="operador" class="form-control" id="operador" />
          </div>
        </div>
        <div class="col-md-4" style="margin-top: 29px;">
          <button @click="redireccionAsignacion()"><span class="fa fa-plus-circle"></span></button>
        </div>
      </div>
    </div>
  
    <!-- Tabla de Operadores -->
    <div class="box box-custom-enod top-buffer">
      <div class="box-body table-responsive">
        <table class="table table-hover table-striped table-condensed">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Remito</th>
              <th>Asigno</th>
              <th style="text-align:right">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in items" :key="index">
              <td>{{ formatDate(item.fecha) }}</td>
              <td>{{ item.remito && item.remito.prefijo && item.remito.numero ? formatRemito(item.remito.prefijo, item.remito.numero) : 'no asignado' }}</td>
              <td>{{ item.user.name }}</td>
              <td style="text-align:right">
                <button 
                  @click="editarItem(index)" 
                  :class="{'btn btn-warning btn-sm': isRemitoValido(index), 'btn btn-sm': !isRemitoValido(index)}"
                >
                  <span 
                    :class="isRemitoValido(index) ? 'fa fa-edit' : 'fa fa-eye'" 
                    :style="!isRemitoValido(index) ? 'color: black;' : ''"
                  ></span>
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
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

export default {
  components: {
    Loading
  },
  props: {
    operador_data: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      operador: this.operador_data.name,
      items: [],
      isLoading: false,
      remito_selected: ''
    };
  },
  methods: {
    async fetchAsignaciones() {
      this.isLoading = true;
      try {
        const response = await axios.get(`/api/asignaciones-ropa/${this.operador_data.id}`);
        this.items = response.data;
        this.isLoading = false;
      } catch (error) {
        console.error(error);
        toastr.error('Error fetching data');
        this.isLoading = false;
      }
    },
    redireccionAsignacion() {
     const edit_data = false;
      window.location.href = `/area/enod/asignacion-operador-manual/${this.operador_data.id}/2100-01-01/${edit_data}`;
    },
    isRemitoValido(index) {
      return this.items[index].remito; // Ajusta esta lógica según lo que consideres un remito válido
    },
    editarItem(index) {
      const userId = this.operador_data.id;

      if (this.items[index].remito && this.items[index].remito.id) {
        const remitoId = this.items[index].remito.id;
        window.location.href = `/area/enod/asignacion-nuevo/${userId}/remito/${remitoId}`;
      } else {
        const formattedDate = this.formatDate(this.items[index].fecha);
        const edit = true;
        window.location.href = `/area/enod/asignacion-operador-manual/${userId}/${formattedDate}/${edit}`;
      }
    },
    goBack() {
      window.history.back();
    },
    formatDate(date) {
      // Formatea la fecha a 'YYYY-MM-DD'
      const formattedDate = new Date(date);
      return formattedDate.toISOString().split('T')[0];
    },
    formatRemito(prefijo, numero) {
      // Convierte prefijo y numero a cadenas y luego los formatea como '0001-00000009'
      return `${String(prefijo).padStart(4, '0')}-${String(numero).padStart(8, '0')}`;
    }
  },
  mounted() {
    this.fetchAsignaciones();
  }
};
</script>

<style scoped>
.box.box-custom-enod {
  padding: 20px;
}
</style>