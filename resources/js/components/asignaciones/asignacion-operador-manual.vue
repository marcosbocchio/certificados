<template>
  <div>
    <!-- Box 1: Operador -->
    <div class="box box-custom-enod">
      <div class="box-body row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="operador">Operador *</label>
            <v-select v-model="operador_selected" :options="operadores_opciones" label="name" id="operador" disabled></v-select>
          </div>
        </div>
      </div>
    </div>

    <!-- Box 2: Producto y Detalles -->
    <div class="box box-custom-enod">
      <div class="box-body row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="producto">Producto *</label>
            <v-select v-model="producto_selected" :options="productos_opciones" label="codigo" id="producto"></v-select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="cantidad">Cantidad *</label>
            <input id="cantidad" type="number" v-model="cantidad_selected" class="form-control" min="0" :max="maxCantidad" placeholder="Cantidad">
          </div>
        </div>
        <div class="col-md-1">
          <div style="display:flex;justify-content: flex-start;align-items: center;">
            <button type="button" @click="agregarDetalle" style="margin-top:25px;"><span class="fa fa-plus-circle"></span></button>
          </div>
        </div>
      </div>

      <!-- Tabla de Detalles -->
      <div class="box-body">
        <table class="table table-hover table-striped table-condensed">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th style="text-align: center;">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(detalle, index) in detalles" :key="index">
              <td>{{ detalle.producto.codigo }}</td>
              <td>{{ detalle.cantidad }}</td>
              <td style="text-align:center">
                <i class="fa fa-minus-circle" @click="eliminarDetalle(index)"></i>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Box 3: Observaciones -->
    <div class="box box-custom-enod">
      <div class="box-body">
        <div class="form-group">
          <label for="observaciones">Observaciones</label>
          <textarea id="observaciones" v-model="observaciones" class="form-control" rows="5" placeholder="Observaciones" style="width: 100%;"></textarea>
        </div>
      </div>
    </div>

    <!-- Botón de Guardar -->
    <div class="form-actions">
      <div class="col-md-12">
        <button @click="guardarAsignacion" class="btn btn-enod">Guardar</button>
      </div>
    </div>

    <!-- Indicador de carga -->
    <loading :active.sync="isLoading" :loader="'bars'" :color="'red'"></loading>
  </div>
</template>

<script>
import axios from 'axios';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

export default {
  components: {
    vSelect,
    Loading
  },
  props: {
    productos_opciones: {
      type: Array,
      required: true
    },
    operador_seleccionado: {
      type: Object,
      required: true
    },
    fecha_data: {
      type: String,
      required: true
    }
  },
  created() {
    this.fetchAsignacionEppDetails(this.fecha_data);
  },
  data() {
    return {
      operador_selected: this.operador_seleccionado,
      producto_selected: null,
      cantidad_selected: 0,
      maxCantidad: 99,
      detalles: [],
      observaciones: '',
      isLoading: false,
      operadores_opciones: [], // Inicializado como array vacío
    };
  },
  methods: {
    agregarDetalle() {
      if (!this.producto_selected || this.cantidad_selected <= 0) {
        toastr.error('Producto o cantidad no válidos');
        return;
      }

      // Verificar si el producto ya está en detalles
      const encontrado = this.detalles.find(detalle => detalle.producto.id === this.producto_selected.id);
      if (encontrado) {
        toastr.error('El producto ya ha sido agregado');
        return;
      }

      const nuevoDetalle = {
        producto: this.producto_selected,
        cantidad: this.cantidad_selected,
      };

      this.detalles.push(nuevoDetalle);

      this.producto_selected = null;
      this.cantidad_selected = 0;
    },
    eliminarDetalle(index) {
      this.detalles.splice(index, 1);
    },
    guardarAsignacion() {
      if (this.detalles.length === 0) {
        toastr.error('Debe agregar al menos un detalle de asignación');
        return;
      }

      this.isLoading = true;

      const data = {
        operador_id: this.operador_selected.id,
        remito_id: null, // No hay remito asociado
        detalles: this.detalles,
        observaciones: this.observaciones,
      };

      axios.post('/api/asignacion-epp', data)
        .then(response => {
          toastr.success('Asignación guardada correctamente');
          // Reiniciar campos después de guardar
          this.detalles = [];
          this.observaciones = '';
          this.isLoading = false;
        })
        .catch(error => {
          console.error('Error al guardar asignación:', error);
          toastr.error('Error al guardar la asignación');
          this.isLoading = false;
        });
    },
    fetchAsignacionEppDetails(fecha) {
      this.isLoading = true;
      axios.get(`/api/asignacion-epp-details-by-fecha/${fecha}`)
        .then(response => {
          this.detalles = response.data.asignacion.detalles;
          this.observaciones = response.data.observaciones; // Asignar las observaciones recibidas
          this.isLoading = false; // Detener el indicador de carga
        })
        .catch(error => {
          console.error("Error al obtener los detalles de asignación EPP por fecha:", error);
          toastr.error('Error al cargar los detalles de asignación EPP');
          this.isLoading = false; // Asegurarse de detener el indicador de carga en caso de error
        });
    },
  }
};
</script>

<style scoped>
/* Aquí puedes agregar estilos específicos para este componente */
</style>