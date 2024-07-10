<template>
  <div>
    <div class="row">
      <div class="col-md-12" style="margin-bottom: 10px;">
        <button type="button" class="pull-left btn-enod btn-circle" @click="goBack">
          <span class="fa fa-arrow-left"></span>
        </button>
      </div>
    </div>
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
            <v-select v-model="producto_selected" :options="productos_opciones" label="descripcion" id="producto" @input="setMaxCantidad"></v-select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="cantidad">Cantidad *</label>
            <input id="cantidad" type="number" v-model="cantidad_selected" class="form-control" :max="maxCantidad">
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
              <td>{{ detalle.producto.descripcion }}</td>
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

    <div class="row">
      <div class="form-actions">
        <div class="col-md-12">
          <button @click="guardarAsignacion" class="btn btn-enod" :disabled="isEditDisabled">Guardar</button>
        </div>
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
    },
    edit_data: {
      type: Boolean,
      required: true
    }
  },
  created() {
    this.obtenerAsignacionPorFecha(this.fecha_data);
  },
  data() {
    return {
      operador_selected: this.operador_seleccionado,
      producto_selected: null,
      cantidad_selected: 0,
      maxCantidad: 0, // Inicializado como 0
      detalles: [],
      observaciones: '',
      isLoading: false,
      operadores_opciones: [],
      fechaActual: new Date().toISOString().slice(0, 19).replace('T', ' '),
    };
  },
  computed: {
    isEditDisabled() {
      return this.edit_data;
    }
  },
  methods: {
    setMaxCantidad() {
      if (this.producto_selected) {
        this.cantidad_selected = 0;
        this.maxCantidad = this.producto_selected.stock;
      }
    },
    agregarDetalle() {
      if (!this.producto_selected) {
        toastr.error('Producto requerido');
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
      this.maxCantidad = 0;
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
        fecha: this.fechaActual,
      };

      console.log(data); // Añade esto para verificar los datos

      axios.post('/api/asignacion-epp', data)
        .then(response => {
          toastr.success('Asignación guardada correctamente');
          // Reiniciar campos después de guardar
          this.detalles = [];
          this.observaciones = '';
          
          this.isLoading = false;

          // Llamar a actualizarStock después de guardar asignación
          this.actualizarStock(data.detalles, data.observaciones);
          window.location.href = `/area/enod/asignacion-operador/${this.operador_selected.id}`;
        })
        .catch(error => {
          console.error('Error al guardar asignación:', error);
          toastr.error('Error al guardar la asignación');
          this.isLoading = false;
        });
    },
    actualizarStock(detalles, observaciones) {
      axios.post('/api/actualizar-epp-stock', { detalles, observaciones })
        .then(response => {
          toastr.success('Stock actualizado correctamente');
        })
        .catch(error => {
          console.error('Error al actualizar stock:', error);
          toastr.error('Error al actualizar el stock');
        });
    },
    goBack() {
      window.history.back();
    },
    obtenerAsignacionPorFecha(fecha) {
      this.isLoading = true;
      axios.get(`/api/asignacion-epp-details-by-fecha/${fecha}`)
        .then(response => {
          const asignacion = response.data.asignacion;
          this.detalles = asignacion.detalles;
          this.observaciones = response.data.observaciones; // Obtener observaciones
          this.isLoading = false;
        })
        .catch(error => {
          console.error('Error al obtener detalles de asignación:', error);
          toastr.error('Error al obtener los detalles de la asignación');
          this.isLoading = false;
        });
    }
  }
};
</script>

<style scoped>
</style>