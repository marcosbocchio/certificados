<template>
  <div>
    <!-- Box 1: Operador y Remito -->
    <div class="box box-custom-enod">
      <div class="box-body row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="operador">Operador *</label>
            <v-select v-model="operador_selected" :options="operadores_opciones" label="name" id="operador" disabled></v-select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="remito">Remito *</label>
            <v-select v-model="remito_selected" :options="remitos_opciones" label="formateado" id="remito" @input="fetchRemitoDetails" disabled></v-select>
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
            <v-select v-model="producto_selected" :options="productos_filtrados" label="codigo" id="producto"></v-select>
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
          <textarea id="observaciones" v-model="observaciones" class="form-control" rows="5" placeholder="Observaciones" maxlength="200" style="width: 100%;"></textarea>
        </div>
      </div>
    </div>

    <!-- Botón de Guardar -->
    <div class="form-actions">
      <div class="col-md-12">
        <button @click="confirmar" class="btn btn-enod">Guardar</button>
      </div>
    </div>

    <!-- Loading -->
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
    remitos_opciones: {
      type: Array,
      required: true
    },
    operadores_opciones: {
      type: Array,
      required: true
    },
    remito_data: {
      type: Array,
      required: true
    },
    operador_seleccionado: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      operador_selected: this.operador_seleccionado,
      remito_selected: this.remito_data[0],
      producto_selected: null,
      productos_filtrados: this.productos_opciones,
      cantidad_selected: 0,
      maxCantidad: 99,
      detalles: [],
      observaciones: '',
      isLoading: false,
      detalle_remito_data: [],
      productos_remito_data: [],
      fechaActual: new Date().toISOString().slice(0, 19).replace('T', ' ') // Obtiene la fecha y hora actual en formato YYYY-MM-DD HH:MM:SS
    };
  },
  mounted() {
    // Llama a la función fetchRemitoDetails si hay un remito seleccionado
    if (this.remito_selected) {
      this.fetchRemitoDetails();
    }
    
    console.log("fecha:|", this.fechaActual);
    this.fetchAsignacionEppDetails();
    
  },
  watch: {
    producto_selected(newVal, oldVal) {
      if (newVal && this.detalle_remito_data.length > 0) {
        const detalle = this.detalle_remito_data.find(detalle => detalle.producto_id === newVal.id);
        if (detalle) {
          this.maxCantidad = detalle.cantidad;
          this.cantidad_selected = Math.min(detalle.cantidad, this.cantidad_selected);
        } else {
          this.maxCantidad = 0;
          this.cantidad_selected = 0;
        }
      } else {
        this.maxCantidad = 0;
        this.cantidad_selected = 0;
      }
    }
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
    confirmar() {
      this.isLoading = true;
      axios.post('/api/asignacion-epp', {
        operador_id: this.operador_selected.id,
        remito_id: this.remito_selected.id,
        detalles: this.detalles,
        observaciones: this.observaciones,
        fecha: this.fechaActual  // Incluye la fecha actual
      })
      .then(response => {
        this.isLoading = false;
        toastr.success('Asignación guardada correctamente');
        // Lógica adicional después de guardar, si es necesario
      })
      .catch(error => {
        console.error("Error al guardar la asignación EPP:", error);
        this.isLoading = false;
        toastr.error('Error al guardar la asignación');
      });
    },
    fetchRemitoDetails() {
      if (this.remito_selected && this.remito_selected.id) {
        this.isLoading = true;
        axios.get(`/api/obtener-detalles-remito/${this.remito_selected.id}`)
          .then(response => {
            this.detalle_remito_data = response.data.detalle_remito_data;
            this.productos_remito_data = response.data.productos_remito_data;

            // Filtrar productos_opciones para incluir solo los productos en productos_remito_data
            const resultado = this.productos_opciones.filter(producto =>
              this.productos_remito_data.find(p => p.id === producto.id)
            );
            this.productos_filtrados = resultado;
            this.isLoading = false;
            window.location.href = `/area/enod/asignacion-remito/${this.remito_selected.id}`;
          })
          .catch(error => {
            console.error("Error al obtener los detalles del remito:", error);
            this.isLoading = false;
          });
      }
    },
    fetchAsignacionEppDetails() {
      axios.get(`/api/asignacion-epp-details/${this.operador_selected.id}/${this.remito_selected.id}`)
        .then(response => {
          this.detalles = response.data.asignacion.detalles;
          this.observaciones = response.data.observaciones; // Asignar las observaciones recibidas
          this.fechaActual = response.data.fecha; // Asignar la fecha recibida
        })
        .catch(error => {
          console.error("Error al obtener los detalles de asignación EPP:", error);
        });
    },
  }
};
</script>

<style scoped>
/* Puedes agregar tus estilos personalizados aquí */
</style>